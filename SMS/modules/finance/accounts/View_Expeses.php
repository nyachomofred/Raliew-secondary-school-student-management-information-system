<?php require_once('../../../../Connections/sms.php');
require dirname(__FILE__).'/accountant_dash.php'; ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_rsViewExpenses = 50;
$pageNum_rsViewExpenses = 0;
if (isset($_GET['pageNum_rsViewExpenses'])) {
  $pageNum_rsViewExpenses = $_GET['pageNum_rsViewExpenses'];
}
$startRow_rsViewExpenses = $pageNum_rsViewExpenses * $maxRows_rsViewExpenses;

mysql_select_db($database_sms, $sms);
$query_rsViewExpenses = "SELECT * FROM tbl_expense_payment";
$query_limit_rsViewExpenses = sprintf("%s LIMIT %d, %d", $query_rsViewExpenses, $startRow_rsViewExpenses, $maxRows_rsViewExpenses);
$rsViewExpenses = mysql_query($query_limit_rsViewExpenses, $sms) or die(mysql_error());
$row_rsViewExpenses = mysql_fetch_assoc($rsViewExpenses);

if (isset($_GET['totalRows_rsViewExpenses'])) {
  $totalRows_rsViewExpenses = $_GET['totalRows_rsViewExpenses'];
} else {
  $all_rsViewExpenses = mysql_query($query_rsViewExpenses);
  $totalRows_rsViewExpenses = mysql_num_rows($all_rsViewExpenses);
}
$totalPages_rsViewExpenses = ceil($totalRows_rsViewExpenses/$maxRows_rsViewExpenses)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Expenses</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
&nbsp;&nbsp;<a href="/SMS/SMS/modules/finance/accounts/addExpense_Type.php">Add Expense Type</a>&nbsp;>>&nbsp;<a href="/SMS/SMS/modules/finance/accounts/Expense_Payment.php">Pay Expenses</a>
<table border="1" cellpadding="1">
  <tr>
    <td>Expense_ID</td>
    <td>Expense_Type</td>
    <td>Expense_Amount</td>
    <td>Expense_Date</td>
    <td>Specfic_Description</td>
    <td>Approved_By</td>
    <td>Operations</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsViewExpenses['Expense_ID']; ?></td>
      <td><?php echo $row_rsViewExpenses['Expense_Type']; ?></td>
      <td><?php echo $row_rsViewExpenses['Expense_Amount']; ?></td>
      <td><?php echo $row_rsViewExpenses['Expense_Date']; ?></td>
      <td><?php echo $row_rsViewExpenses['Specfic_Description']; ?></td>
      <td><?php echo $row_rsViewExpenses['Approved_By']; ?></td>
      <td><a href="Upadet_Expese.php?Expense_ID=<?php echo $row_rsViewExpenses['Expense_ID']; ?>">Edit</a></td>
    </tr>
    <?php } while ($row_rsViewExpenses = mysql_fetch_assoc($rsViewExpenses)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsViewExpenses);
?>
