<?php 
session_start();
require_once('../../../Connections/sms.php'); 
		require dirname(__FILE__).'/../administration/Admin_dash.php';
?>
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

$maxRows_rsPaymentsDetails = 50;
$pageNum_rsPaymentsDetails = 0;
if (isset($_GET['pageNum_rsPaymentsDetails'])) {
  $pageNum_rsPaymentsDetails = $_GET['pageNum_rsPaymentsDetails'];
}
$startRow_rsPaymentsDetails = $pageNum_rsPaymentsDetails * $maxRows_rsPaymentsDetails;

mysql_select_db($database_sms, $sms);
$query_rsPaymentsDetails = "SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) as Name, add_student.Form,tblstudent_acc.Debit,tblstudent_acc.Credit,tblstudent_acc.Debit-tblstudent_acc.Credit as Balance FROM add_student,tblstudent_acc WHERE add_student.Admission_No=tblstudent_acc.Admission_No ORDER BY add_student.Form";
$query_limit_rsPaymentsDetails = sprintf("%s LIMIT %d, %d", $query_rsPaymentsDetails, $startRow_rsPaymentsDetails, $maxRows_rsPaymentsDetails);
$rsPaymentsDetails = mysql_query($query_limit_rsPaymentsDetails, $sms) or die(mysql_error());
$row_rsPaymentsDetails = mysql_fetch_assoc($rsPaymentsDetails);

if (isset($_GET['totalRows_rsPaymentsDetails'])) {
  $totalRows_rsPaymentsDetails = $_GET['totalRows_rsPaymentsDetails'];
} else {
  $all_rsPaymentsDetails = mysql_query($query_rsPaymentsDetails);
  $totalRows_rsPaymentsDetails = mysql_num_rows($all_rsPaymentsDetails);
}
$totalPages_rsPaymentsDetails = ceil($totalRows_rsPaymentsDetails/$maxRows_rsPaymentsDetails)-1;$maxRows_rsPaymentsDetails = 50;
$pageNum_rsPaymentsDetails = 0;
if (isset($_GET['pageNum_rsPaymentsDetails'])) {
  $pageNum_rsPaymentsDetails = $_GET['pageNum_rsPaymentsDetails'];
}
$startRow_rsPaymentsDetails = $pageNum_rsPaymentsDetails * $maxRows_rsPaymentsDetails;

mysql_select_db($database_sms, $sms);
$query_rsPaymentsDetails = "SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) as Name, add_student.Form,tblstudent_acc.Debit,tblstudent_acc.Credit,tblstudent_acc.Debit-tblstudent_acc.Credit as Balance FROM add_student,tblstudent_acc WHERE add_student.Admission_No=tblstudent_acc.Admission_No ORDER BY add_student.Form";
$query_limit_rsPaymentsDetails = sprintf("%s LIMIT %d, %d", $query_rsPaymentsDetails, $startRow_rsPaymentsDetails, $maxRows_rsPaymentsDetails);
$rsPaymentsDetails = mysql_query($query_limit_rsPaymentsDetails, $sms) or die(mysql_error());
$row_rsPaymentsDetails = mysql_fetch_assoc($rsPaymentsDetails);

if (isset($_GET['totalRows_rsPaymentsDetails'])) {
  $totalRows_rsPaymentsDetails = $_GET['totalRows_rsPaymentsDetails'];
} else {
  $all_rsPaymentsDetails = mysql_query($query_rsPaymentsDetails);
  $totalRows_rsPaymentsDetails = mysql_num_rows($all_rsPaymentsDetails);
}
$totalPages_rsPaymentsDetails = ceil($totalRows_rsPaymentsDetails/$maxRows_rsPaymentsDetails)-1;
?>
<!DOCTYPE html>
<html>
<head>
<?php

require dirname(__FILE__).'/../../config/dbConnect.php';
require dirname(__FILE__).'/../../config/security.php';

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Payements</title>
</head>

<body>
<?php if(isset($_POST['btnSubmit'])){
	$admNo=escape($_POST['txtSearchPayment']);
	
	
	}?>
    <div class="content">
    <div class="table_views">
<form id="form1" name="form1" method="post" action="View_One_Payment.php?admNo=<?php echo $admNo?>">
  <table width="500" cellpadding="5">
    <tr>

      <td width="285"><input type="text" name="txtSearchPayment" id="txtSearchPayment" placeholder="Search By Admission" />&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Go" /></td>
    </tr>
  </table>
</form>
<table border="1" cellpadding="1">
  <tr>
    <td>S/No</td>
    <td>Name</td>
    <td>Form</td>
    <td>Debit</td>
    <td>Credit</td>
    <td>Balance</td>
  </tr>
  <?php $count=1;do { ?>
    <tr>
      <td><?php echo $count?></td>
      <td><?php echo $row_rsPaymentsDetails['Name']; ?></td>
      <td><?php echo $row_rsPaymentsDetails['Form']; ?></td>
      <td><?php echo $row_rsPaymentsDetails['Debit']; ?></td>
      <td><?php echo $row_rsPaymentsDetails['Credit']; ?></td>
      <td><?php echo $row_rsPaymentsDetails['Balance']; ?></td>
    </tr>
    <?php 
	$count++;
	} while ($row_rsPaymentsDetails = mysql_fetch_assoc($rsPaymentsDetails)); ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsPaymentsDetails);
?>
