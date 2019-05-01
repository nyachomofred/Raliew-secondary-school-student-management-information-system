<!DOCTYPE html>
<html>
<head>
<?php

require dirname(__FILE__).'/../../config/dbConnect.php';
require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Trial Balance</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>

<body>
<div class="content">
<form action="" method="post" name="frmTrial_Bal" class="form-container">
<div class="form-title"><h2>Trial Balance</h2></div>

  <label for="cmbAcad_Year">Academic Year :</label></td>
   
      <select name="cmbAcad_Year" id="cmbAcad_Year">
        <?php 
	//sql to populate acad year
	$sql="SELECT DISTINCT YEAR
	(tblfee_payments_details.Date_Paid) AS Yea FROM tblfee_payments_details 
	ORDER BY Yea ASC ";
	$result=mysqli_query($conn,$sql);
	
	?>
        <option selected="selected">Please Select</option>
        <?php 
		while($row=mysqli_fetch_assoc($result)){
			$acad=$row['Yea'];
			?>
        <option value="<?php echo $acad?>"><?php echo $acad?></option>
        <?php
			}
		?>
      </select>
      &nbsp;
    <input type="submit" name="btnGo" id="btnGo" value="Go" /></td>
  </tr>
  <hr>
  <?php 
  if(isset($_POST['btnGo'])){
	  $selectedYear=$_POST['cmbAcad_Year'];
	  //filter the trial balnce by yaer
	  $sql="SELECT (SELECT SUM(tblfee_payments_details.Amount_Paid)FROM tblfee_payments_details WHERE(SELECT YEAR(tblfee_payments_details.Date_Paid))='".$selectedYear."')AS Total_Fee, (SELECT SUM(tbl_expense_payment.Expense_Amount)FROM tbl_expense_payment WHERE(SELECT YEAR(tbl_expense_payment.Expense_Date))='".$selectedYear."')as Total_Expenditure, ((SELECT SUM(tblfee_payments_details.Amount_Paid)FROM tblfee_payments_details WHERE(SELECT YEAR(tblfee_payments_details.Date_Paid))='".$selectedYear."') - (SELECT SUM(tbl_expense_payment.Expense_Amount)FROM tbl_expense_payment WHERE(SELECT YEAR(tbl_expense_payment.Expense_Date))='".$selectedYear."')) as Bal";
	  //get the result
	  $resultTrial=mysqli_query($conn,$sql);
	  while($rowTrial=mysqli_fetch_assoc($resultTrial)){
		  $Total_fee=$rowTrial['Total_Fee'];
		  $Total_Expenses=$rowTrial['Total_Expenditure'];
		  $Trianl_Bal=$rowTrial['Bal'];
		  }
	  
	  ?>
<div class="form-title">Academic Year</div>
<input type="text" name="txtYear" id="txtYear" readonly="readonly" class="form-field" value="<?php echo $selectedYear?>" />

<div class="form-title">Total Fee Collected</div>
<input type="text" name="txtTotal_Collected" id="txtTotal_Collected" value="<?php echo $Total_fee?>" readonly="readonly" class="form-field">

<div class="form-title">Total Expenditure</div>
<input type="text" name="txtTotal_Expenses" id="txtTotal_Expenses" value="<?php echo $Total_Expenses?>" readonly="readonly" class="form-field">

<div class="form-title">Total Balance</div>
 <input type="text" name="txtTrial_Bal" id="txtTrial_Bal" value="<?php echo $Trianl_Bal?>" readonly="readonly" class="form-field">


      <?php
	  }
  ?>


</form>
</div>
</body>
</html>