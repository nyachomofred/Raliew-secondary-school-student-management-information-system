<?php require_once('../../../Connections/sms.php'); 
	require dirname(__FILE__).'/../administration/Admin_dash.php';?>
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

$maxRows_rsViewPayment_Transaction = 50;
$pageNum_rsViewPayment_Transaction = 0;
if (isset($_GET['pageNum_rsViewPayment_Transaction'])) {
  $pageNum_rsViewPayment_Transaction = $_GET['pageNum_rsViewPayment_Transaction'];
}
$startRow_rsViewPayment_Transaction = $pageNum_rsViewPayment_Transaction * $maxRows_rsViewPayment_Transaction;

$colname_rsViewPayment_Transaction = "-1";
if (isset($_POST['txtSearch'])) {
  $colname_rsViewPayment_Transaction = $_POST['txtSearch'];
}
mysql_select_db($database_sms, $sms);
$query_rsViewPayment_Transaction = sprintf("SELECT * FROM tblfee_payments_details WHERE Admission_No = %s ORDER BY Date_Paid ASC", GetSQLValueString($colname_rsViewPayment_Transaction, "int"));
$query_limit_rsViewPayment_Transaction = sprintf("%s LIMIT %d, %d", $query_rsViewPayment_Transaction, $startRow_rsViewPayment_Transaction, $maxRows_rsViewPayment_Transaction);
$rsViewPayment_Transaction = mysql_query($query_limit_rsViewPayment_Transaction, $sms) or die(mysql_error());
$row_rsViewPayment_Transaction = mysql_fetch_assoc($rsViewPayment_Transaction);

if (isset($_GET['totalRows_rsViewPayment_Transaction'])) {
  $totalRows_rsViewPayment_Transaction = $_GET['totalRows_rsViewPayment_Transaction'];
} else {
  $all_rsViewPayment_Transaction = mysql_query($query_rsViewPayment_Transaction);
  $totalRows_rsViewPayment_Transaction = mysql_num_rows($all_rsViewPayment_Transaction);
}
$totalPages_rsViewPayment_Transaction = ceil($totalRows_rsViewPayment_Transaction/$maxRows_rsViewPayment_Transaction)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Transactions</title>
</head>

<body>
<div class="content">
<form action="" method="post" name="frmGetTransactionDetails"><table width="500" cellpadding="5">
  <tr>
    <td width="211"><label for="txtSearch">Search By Admission Number:</label></td>
    <td width="261"><input type="text" name="txtSearch" id="txtSearch" />
      <input type="submit" name="btnSubmit" id="btnSubmit" value="Go" /></td>
  </tr>
</table>
</form>
<?php if(isset($_POST['btnSubmit'])){
	?>
    <table border="1" cellpadding="1">
  <tr>
    <td>Receipt_No</td>
    <td>Amount_Paid</td>
    <td>Date_Paid</td>
    <td>Processed_By</td>
    <td>Operations</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsViewPayment_Transaction['Receipt_No']; ?></td>
      <td><?php echo $row_rsViewPayment_Transaction['Amount_Paid']; ?></td>
      <td><?php echo $row_rsViewPayment_Transaction['Date_Paid']; ?></td>
      <td><?php echo $row_rsViewPayment_Transaction['Processed_By']; ?></td>
      <td><a href="CorrectPayment.php?Receipt_No=<?php echo $row_rsViewPayment_Transaction['Receipt_No']; ?>">Correct</a></td>
    </tr>
    <?php } while ($row_rsViewPayment_Transaction = mysql_fetch_assoc($rsViewPayment_Transaction)); ?>
</table>
    <?php
	
	
	}?>
</div>
</body>
</html>
<?php
mysql_free_result($rsViewPayment_Transaction);
?>
