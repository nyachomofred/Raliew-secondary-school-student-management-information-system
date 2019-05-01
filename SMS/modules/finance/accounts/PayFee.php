
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php

require dirname(__FILE__).'/../../../config/dbConnect.php';
require dirname(__FILE__).'/../../../config/security.php';
require dirname(__FILE__).'/accountant_dash.php';

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Pay Fee</title>
<link rel="stylesheet" href="../../../styles/form_template.css" />
<script src="../../js/Formvalidation.js"></script>
</head>

<body>
<div class="content">
<form action="" method="post" name="frmSearchStudent" class="form-container">
<div class="form-title"><h2>Fee Payment Form</h2></div>
   <label for="txtStudentAdms">Admission Number</label>
  <input type="text" name="txtStudentAdms" id="txtStudentAdms" />
      <input type="submit" name="btnSearch" id="btnSearch" value="Search" />

</form>

<?php
if(isset($_POST['btnSearch'])){
	//declare
	$admNo=escape($_POST['txtStudentAdms']);
	
	//prepare sql to view student finance record
	$sql="SELECT add_student.Admission_No, CONCAT(add_student.First_Name,'  ',add_student.Last_Name)AS Full_Name,CONCAT(add_student.Form,'  ',add_student.Stream)AS Class,tblstudent_acc.Debit,tblstudent_acc.Credit,tblstudent_acc.Debit-tblstudent_acc.Credit AS Balance FROM add_student,tblstudent_acc WHERE add_student.Admission_No='".$admNo."' AND tblstudent_acc.Admission_No='".$admNo."'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==1){
	while($row=mysqli_fetch_assoc($result)){
		 $admission=$row['Admission_No'];
		$fullName=$row['Full_Name'];
		$frm=$row['Class'];
		$debit=$row['Debit'];
		$credit=$row['Credit'];
		$bal=$row['Balance'];
		
		
		}
		
		?>
		<!--design the markup form to hold the details-->
		<form action="" method="post" name="frm_StdFinance" class="form-container">
  <tr>
    <td><input type="hidden" name="admission_no" id="hiddenField" value="<?php echo $admission?>" /></td>
    <td>&nbsp;</td>
  </tr>
  
 <div class="form-title">Name</div>
   <input type="text" name="txtFull_Name" id="txtFull_Name" disabled="disabled" required class="form-field" value="<?php echo$fullName?>" />
   
 <div class="form-title">Form</div>
   <input type="text" name="txtForm" id="txtForm" disabled="disabled" required class="form-field" value="<?php echo $frm?>" />
  
  <div class="form-title">Debit Amount</div>
<input type="text" name="txtDebit" id="txtDebit" disabled="disabled" required class="form-field" value="<?php echo $debit?>" />

<div class="form-title">Credit Amount</div>
<input type="text" name="txtCredit" id="txtCredit" disabled="disabled" required class="form-field" value="<?php echo $credit?>" />

<div class="form-title">Balance</div>
 <input type="text" name="txtBal" id="txtBal" disabled="disabled" required class="form-field" value="<?php if($bal<0){
		$TrimedBal=$bal*-1;
		echo "(".$TrimedBal.")";
		}else{
			echo $bal;
			}?>" />
            
<div class="form-title">Receipt Number</div>
<input type="text" name="txtReceiptNo" id="txtReceiptNo" required class="form-field"/>

<div class="form-title">Amount Paid</div>
<input type="number" name="txtAmount_Paid" id="txtAmount_Paid" placeholder="no comma allowed" required class="form-field" maxlength="6" onblur="allnumeric(txtAmount_Paid)" min="0"/>
  
 <div class="submit-container"> 
<input type="submit" name="btnConfirm" id="btnConfirm" value="Submit" class="submit-button" />
<input type="reset" name="btnCancel" id="btnCancel" value="Cancel" class="submit-button" /></td>
</div>
</form>
		<?php
	}//end if num of rows==1
	else{
	echo "No result found...";
	}//end of  rows  not found
	
}// end of if if is set btn search
	if(isset($_POST['btnConfirm'])){
		 $ReceipNo=escape($_POST['txtReceiptNo']);
		 $Amount=escape($_POST['txtAmount_Paid']);
		 $admissionNo=escape($_POST['admission_no']);
		 
		 //disable autocommit
		 mysqli_autocommit($conn,false);
		 
		 //define sql to update the credit account
		 $sql="UPDATE tblstudent_acc SET tblstudent_acc.Credit=tblstudent_acc.Credit+'".$Amount."' WHERE tblstudent_acc.Admission_No='".$admissionNo."'";
		 if(mysqli_query($conn,$sql)){
			 //define sql statement to capture the payment details
			 $sql="INSERT INTO `sms`.`tblfee_payments_details` (`Receipt_No`, `Admission_No`, `Amount_Paid`)
			  VALUES (?,?,?)";
			  
			  //prepare statement
			  $pstm=mysqli_prepare($conn,$sql);
			  //bind param
			  mysqli_stmt_bind_param($pstm,'iid',$reptNo,$AdmN,$Amnt);
			  $reptNo=$ReceipNo;
			  $AdmN=$admissionNo;
			  $Amnt=$Amount;
			  
			 if(mysqli_stmt_execute($pstm)){
			 mysqli_commit($conn);
			 //calculate the new balance
			 $sqlNewBal="SELECT tblstudent_acc.Debit-tblstudent_acc.Credit as NewBal FROM tblstudent_acc WHERE tblstudent_acc.Admission_No='".$admissionNo."'";
			 $result=mysqli_query($conn,$sqlNewBal);
			 while($rows=mysqli_fetch_assoc($result)){
				 $NewBal=$rows['NewBal'];
				 
				 }
				 //check the balance type
				 if($NewBal<0){
		$TrimedBal=$NewBal*-1;
		?>
        <script type="text/javascript">
        var bal="<?php echo "(".$TrimedBal.")"?>";
		alert('Account credited successfully...your new balance is '+bal);
        </script>
        <?php
			
		}else{
			?>
        <script type="text/javascript">
        var bal="<?php echo $NewBal?>";
		alert('Account credited successfully...your new balance is '+bal);
        </script>
        <?php
			 
			}
			 
			 }
		 }
		 
		}

?>
</div>
</body>
</html>