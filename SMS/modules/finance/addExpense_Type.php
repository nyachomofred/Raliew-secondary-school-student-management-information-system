<!DOCTYPE html>
<html>
<head>
 <?php

require dirname(__FILE__).'/../../config/dbConnect.php';
require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Add Expense Type</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>

<body>
<?php 
if(isset($_POST['btnSubmit'])){
	//assign the fields variables
	$Expense_Type=escape($_POST['txt_Expense_Type']);
	$Expense_Desc=escape($_POST['txa_Desc']);
	
	//prepare sql statement to insert
	$sql_add_expenseType="INSERT INTO `sms`.`tbl_expensetype` 
	(`ID`, `Expense_Type`, `Description`)
	 VALUES (NULL, ?,?)";
	 
	//prepare the statement
	$pstm=mysqli_prepare($conn,$sql_add_expenseType);
	
	//bind the param
	mysqli_stmt_bind_param($pstm,'ss',$expenseType,$expenseDsc);
	$expenseType=$Expense_Type;
	$expenseDsc=$Expense_Desc;
	
	//execute the statement
	if(mysqli_stmt_execute($pstm)){
		echo "<script>alert('Added Successfully');</script>";
		}else{
			echo "<script>alert('Insert Failed');</script>".mysqli_error($conn);
			}
	
	}
?>

<div class="content">
<form action="" method="post" name="frm_AddExpense_Type" class="form-container">
<div class="form-title"><h2>Please Fill The Expense Details</h2></div>
 
  <div class="form-title">Expense Type</div>
    <input type="text" name="txt_Expense_Type" id="txt_Expense_Type" required class="form-field"/>
  
  
   <div class="form-title">Expense Description</div>
   <textarea name="txa_Desc" id="txa_Desc" cols="45" rows="5" required class="form-field"></textarea>
   
 <div class="submit-container">
<input type="submit" name="btnSubmit" id="btnSubmit" value="Add" class="submit-button" />&nbsp;&nbsp;
 <input type="reset" name="btnCancel" id="btnCancel" value="Cancel"  class="submit-button"/>
</div>
</form>
</div>
</body>
</html>