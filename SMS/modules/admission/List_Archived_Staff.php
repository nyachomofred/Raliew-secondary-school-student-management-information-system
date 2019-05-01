<?php require_once('../../../Connections/sms.php'); ?>
<?php require_once('../../../Connections/sms.php'); ?>
<?php require_once('../../../Connections/sms.php'); 
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

$maxRows_rsList_ArchivedStaff = 50;
$pageNum_rsList_ArchivedStaff = 0;
if (isset($_GET['pageNum_rsList_ArchivedStaff'])) {
  $pageNum_rsList_ArchivedStaff = $_GET['pageNum_rsList_ArchivedStaff'];
}
$startRow_rsList_ArchivedStaff = $pageNum_rsList_ArchivedStaff * $maxRows_rsList_ArchivedStaff;

mysql_select_db($database_sms, $sms);
$query_rsList_ArchivedStaff = "SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, `Role` FROM archived_staff";
$query_limit_rsList_ArchivedStaff = sprintf("%s LIMIT %d, %d", $query_rsList_ArchivedStaff, $startRow_rsList_ArchivedStaff, $maxRows_rsList_ArchivedStaff);
$rsList_ArchivedStaff = mysql_query($query_limit_rsList_ArchivedStaff, $sms) or die(mysql_error());
$row_rsList_ArchivedStaff = mysql_fetch_assoc($rsList_ArchivedStaff);

if (isset($_GET['totalRows_rsList_ArchivedStaff'])) {
  $totalRows_rsList_ArchivedStaff = $_GET['totalRows_rsList_ArchivedStaff'];
} else {
  $all_rsList_ArchivedStaff = mysql_query($query_rsList_ArchivedStaff);
  $totalRows_rsList_ArchivedStaff = mysql_num_rows($all_rsList_ArchivedStaff);
}
$totalPages_rsList_ArchivedStaff = ceil($totalRows_rsList_ArchivedStaff/$maxRows_rsList_ArchivedStaff)-1;

mysql_select_db($database_sms, $sms);
$query_rsCount_ArchivedStaff = "SELECT COUNT(*) FROM `archived_staff`";
$rsCount_ArchivedStaff = mysql_query($query_rsCount_ArchivedStaff, $sms) or die(mysql_error());
$row_rsCount_ArchivedStaff = mysql_fetch_assoc($rsCount_ArchivedStaff);
$totalRows_rsCount_ArchivedStaff = mysql_num_rows($rsCount_ArchivedStaff);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | List Archived Staff</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
<?php 
if (mysql_num_rows($rsList_ArchivedStaff) == 0) {
    echo "No records found.";
	die();
}
?>
Total Archived Staff: <strong><?php echo $row_rsCount_ArchivedStaff['COUNT(*)']; ?></strong>
<table border="1" cellpadding="1">
  <tr>
    <td>S/No</td>
    <td>Staff_Id</td>
    <td>First_Name</td>
    <td>Last_Name</td>
    <td>Gender</td>
    <td>DOB</td>
    <td>Phone_No</td>
    <td>Email</td>
    <td>Role</td>
    <td>Operations</td>
  </tr>
  <?php 
  $count=1; do { ?>
    <tr>
      <td><?php echo $count?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Staff_Id']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['First_Name']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Last_Name']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Gender']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['DOB']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Phone_No']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Email']; ?></td>
      <td><?php echo $row_rsList_ArchivedStaff['Role']; ?></td>
      <td><a href="reactivateSatff.php?Staff_Id=<?php echo $row_rsList_ArchivedStaff['Staff_Id']; ?>" onclick="return confirm('Do you really want to reactivate ?')">Activate</a></td>
    </tr>
    <?php 
	$count++;} while ($row_rsList_ArchivedStaff = mysql_fetch_assoc($rsList_ArchivedStaff)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsList_ArchivedStaff);

mysql_free_result($rsCount_ArchivedStaff);
?>
