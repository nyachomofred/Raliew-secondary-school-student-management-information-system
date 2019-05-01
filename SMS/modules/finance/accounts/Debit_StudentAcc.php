<!DOCTYPE html>
<html>
<head>
<?php

require dirname(__FILE__).'/../../../config/dbConnect.php';
require dirname(__FILE__).'/../../../config/security.php';
require dirname(__FILE__).'/accountant_dash.php';

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Set Fee</title>
<link rel="stylesheet" href="../../../styles/form_template.css" />
<script src="../../js/Formvalidation.js"></script>
</head>

<body>
   <?php
   if(isset($_POST['btnAdd'])){
	   $frm=$_POST['cmbForm'];
	   $amount=escape($_POST['txtAmount']);
	 
	   
	   //prepare statement to insert
	   $sql="UPDATE tblstudent_acc,add_student SET tblstudent_acc.Debit=tblstudent_acc.Debit+'".$amount."' WHERE tblstudent_acc.Admission_No=add_student.Admission_No AND add_student.Form='".$frm."'";
	   if(mysqli_query($conn,$sql)){
		   //success message
		   echo "<script>alert('Transaction is successful')</script>";
		   }else{
			   echo "<script>alert('Transaction is successful')</script>".mysqli_error($conn);
			   }
	   
	   }
   
   ?>

<div class="content">
<form action="" method="post" name="frmSet_fee" class="form-container">
<div class="form-title"><h2>Student Account Debit Form</h2></div>

<div class="form-title">Academic Year</div>
        <?php 
		$count=date('Y');
	  ?>
   <select name="cmbAcademic_Year" id="cmbAcademic_Year" class="form-field">
      <option>Please Select</option>
  		<?php 
		while($count<=3000){
			?>
            <option value="<?php echo  $count?>"><?php echo $count?></option>
            <?php
			$count++;
			}
		?>
      
      
    </select>


<div class="form-title">Form</div>
  <select name="cmbForm" id="cmbForm" class="form-field">
      <option>Please Select</option>
      <option value="1">Form One</option>
      <option value="2">Form Two</option>
      <option value="3">Form Three</option>
      <option value="4">Form Four</option>
  </select>
  
  <div class="form-title">Term</div>
<select name="cmbTerm" id="cmbTerm" class="form-field">
      <option>Please Select</option>
      <option value="1">Term One</option>
      <option value="2">Term Two</option>
      <option value="3">Term Three</option>
</select>

   <div class="form-title">Amount</div>
   <input type="number"  maxlength="6" required name="txtAmount" id="txtAmount" class="form-field" onblur="allnumeric(txtAmount)" min="0" />
  
 <div class="submit-container">
    <td><input type="submit" name="btnAdd" id="btnAdd" value="Submit" class="submit-button" />&nbsp;&nbsp;
      <input type="reset" name="cmbCancel" id="cmbCancel" value="Cancel" class="submit-button" /></td>
</div>
</form>
</div>
</body>
</html>