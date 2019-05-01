<!DOCTYPE html>
<html>
<head>
<?php
    require dirname(__FILE__).'/../../../config/dbConnect.php';
	require dirname(__FILE__).'/../../../config/security.php';
	require dirname(__FILE__).'/accountant_dash.php';
    ?>
<strong></strong>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Correct Fee Transaction</title>
<link rel="stylesheet" href="../../../styles/form_template.css" />
<script src="../../js/Formvalidation.js"></script>
</head>

<body>
<?php 
$receipt_No=$_GET['Receipt_No'];

//get the student's admission Number
$sql="SELECT * FROM tblfee_payments_details WHERE tblfee_payments_details.Receipt_No='".$receipt_No."'";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	 $admNo=$row['Admission_No'];
	 $amnt=$row['Amount_Paid'];
	$date_paid=$row['Date_Paid'];
	$proccessedBY=$row['Processed_By'];
	}
	
	if(mysqli_num_rows($result)==1){
		?>
        <div class="content">
		<form action="" method="post" name="frmCorrect_Fee" class="form-container">
        <div class="form-title"><h2>Fee Correction Form</h2></div>
        
        
 <div class="form-title">Receipt Number</div>
    <input type="number" name="txtReceiptNo" id="txtReceiptNo" class="form-field" value="<?php echo $receipt_No?>"/ readonly="readonly" onblur="allnumeric(txtReceiptNo)">
 
    <div class="form-title">Amount</div>
   <input type="text" name="txtAmount" id="txtAmount" class="form-field"  value="<?php echo $amnt?>" readonly="readonly" />
  
<div class="form-title">Date Of Payment</div> 
<input type="text" name="txtDate_Processed" id="txtDate_Processed" readonly="readonly" class="form-field" value="<?php echo $date_paid?>" />

<div class="form-title">Approved By</div>
<input type="text" name="txtApprovedBy" id="txtApprovedBy"  readonly="readonly" class="form-field" value=" <?php echo $proccessedBY ?>" />

<div class="form-title">Correct Amount</div>
 <input type="number" maxlength="6" name="txtCorrect_Amount" id="txtCorrect_Amount"  required class="form-field" min="0" />
 
 <div class="submit-container">
<input type="submit" name="btnCorrect" id="btnCorrect" value="Correct" class="submit-button"/>
<input type="reset" name="btnCancel" id="btnCancel" value="Reset" class="submit-button" />
</div>
</form>
        
        <?php
		
		//begin the transaction to correct the fee by disabling autocommit
		if(isset($_POST['btnCorrect'])){
			//declare variables for the corrected amount
			 $corrected_Amount=escape($_POST['txtCorrect_Amount']);
			 $recptNo=$_POST['txtReceiptNo'];
			 $amount=$_POST['txtAmount'];
			
			
			//disable autocommit
			mysqli_autocommit($conn,false);
			
			//define sql to update the fee payment details
			$sqlUpdateDetails="UPDATE `sms`.`tblfee_payments_details` 
			SET `Amount_Paid` ='".$corrected_Amount."' 
			WHERE `tblfee_payments_details`.`Receipt_No` = '".$recptNo."'";
			if(mysqli_query($conn,$sqlUpdateDetails)){
				//get student admissionNo
				$sql="SELECT tblfee_payments_details.Admission_No FROM tblfee_payments_details
				 WHERE tblfee_payments_details.Receipt_No='".$recptNo."'"; 
				 $result=mysqli_query($conn,$sql);
				 while($row=mysqli_fetch_assoc($result)){
					 $Admission=$row['Admission_No'];
					 }
					 //rollback the payment causing the error
					 $sql="UPDATE tblstudent_acc SET tblstudent_acc.Credit=tblstudent_acc.Credit - '".$amount."'
					  WHERE tblstudent_acc.Admission_No='".$Admission."'";
					 if(mysqli_query($conn,$sql)){
						 //correct the transaction by crediting the correct amount
						 $sql="UPDATE tblstudent_acc 
						 SET tblstudent_acc.Credit=tblstudent_acc.Credit + '".$corrected_Amount."'
					  WHERE tblstudent_acc.Admission_No='".$Admission."'";
					  if(mysqli_query($conn,$sql)){
						  
						  echo "<script>alert('Transaction is corrected succssfully')</script>";
						  }
						 }
					  
					 
					 
				}
			}
		
		}
		mysqli_commit($conn);
		
?>
</div>
</body>
</html>
