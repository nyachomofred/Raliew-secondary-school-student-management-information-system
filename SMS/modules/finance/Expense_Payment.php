<!DOCTYPE html>
<html>
<head>
 <?php

require dirname(__FILE__).'/../../config/dbConnect.php';
require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Expense Payment</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
<script src="../../js/Formvalidation.js"></script>
</head>

<?php
//check if the expense is submitted
if(isset($_POST['btnAdd'])){
	//set variables to field
	$expenseType=escape($_POST['cmbExpense_Type']);
	$expenseAmount=escape($_POST['txtExpense_Amount']);
	$specfic_desc=escape($_POST['txaSpeciciDesc']);
	
	//prepare sql statement for insert
	$sql="INSERT INTO `sms`.`tbl_expense_payment` (`Expense_Type`, `Expense_Amount`,`Specfic_Description`)
	 VALUES (?,?,?)";
	 
	$pstm=mysqli_prepare($conn,$sql);
	
	//bind param
	mysqli_stmt_bind_param($pstm,'sds',$expense_Type,$expense_Amount,$Descption);
	$expense_Type=$expenseType;
	$expense_Amount=$expenseAmount;
	$Descption=$specfic_desc;
	
	//execute the statement
	if(mysqli_stmt_execute($pstm)){
		//success message
		echo "<script>alert('Transaction is successful')</script>";
		}else{
			//failure message
			echo "<script>alert('Transaction Failed')</script>".mysqli_error($conn);
			}
	
	
	}
?>


<body>
<div class="content">
<form action="" method="post" name="frm_PayExpenses" class="form-container">
<div class="form-title"><h2>Please Fill Payment Details</h2></div>
 
  <div class="form-title">Expense Type</div>
    <select name="cmbExpense_Type" id="cmbExpense_Type" class="form-field">
    <option>Please Select</option>
   <?php 
   $sql="SELECT DISTINCT tbl_expensetype.Expense_Type FROM tbl_expensetype";
   $result=mysqli_query($conn,$sql);
   while($rows=mysqli_fetch_assoc($result)){
	   ?>
       <option value="<?php echo $rows['Expense_Type']?>"><?php echo $rows['Expense_Type']?></option>
       <?php
	   }
   ?>
   
   
    </select>
    
  <div class="form-title">Expense Amount</div>
    <input type="number" maxlength="6"  required name="txtExpense_Amount" id="txtExpense_Amount" class="form-field" onblur="allnumeric(txtExpense_Amount)" min="0" />
 
  <div class="form-title">Specific Description</div>
 <textarea name="txaSpeciciDesc" id="txaSpeciciDesc" cols="45" rows="5" required  class="form-field"></textarea>

  <div class="submit-container">
   <input type="submit" name="btnAdd" id="btnAdd" value="Submit" class="submit-button" />
   <input type="reset" name="btnCancel" id="btnCancel" value="Cancel" class="submit-button"/>
</div>

</form>
</div>
</body>
</html>