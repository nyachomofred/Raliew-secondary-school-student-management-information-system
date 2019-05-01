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

$maxRows_rsList_Archived = 50;
$pageNum_rsList_Archived = 0;
if (isset($_GET['pageNum_rsList_Archived'])) {
  $pageNum_rsList_Archived = $_GET['pageNum_rsList_Archived'];
}
$startRow_rsList_Archived = $pageNum_rsList_Archived * $maxRows_rsList_Archived;

mysql_select_db($database_sms, $sms);
$query_rsList_Archived = "SELECT Admission_No, First_Name, Middle_Name, Last_Name, DOB, Gender, Postal_Address, Postal_Code, Town, `Form`, Stream, House FROM archived_students";
$query_limit_rsList_Archived = sprintf("%s LIMIT %d, %d", $query_rsList_Archived, $startRow_rsList_Archived, $maxRows_rsList_Archived);
$rsList_Archived = mysql_query($query_limit_rsList_Archived, $sms) or die(mysql_error());
$row_rsList_Archived = mysql_fetch_assoc($rsList_Archived);

if (isset($_GET['totalRows_rsList_Archived'])) {
  $totalRows_rsList_Archived = $_GET['totalRows_rsList_Archived'];
} else {
  $all_rsList_Archived = mysql_query($query_rsList_Archived);
  $totalRows_rsList_Archived = mysql_num_rows($all_rsList_Archived);
}
$totalPages_rsList_Archived = ceil($totalRows_rsList_Archived/$maxRows_rsList_Archived)-1;

mysql_select_db($database_sms, $sms);
$query_rsCount_Archived_Student = "SELECT COUNT( *) FROM archived_students";
$rsCount_Archived_Student = mysql_query($query_rsCount_Archived_Student, $sms) or die(mysql_error());
$row_rsCount_Archived_Student = mysql_fetch_assoc($rsCount_Archived_Student);
$totalRows_rsCount_Archived_Student = mysql_num_rows($rsCount_Archived_Student);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | List Archived</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
<p>Total Archived Students : <strong><?php echo $row_rsCount_Archived_Student['COUNT( *)']; ?></strong></p>
<form action="search_archived_Student.php" method="post">
<table width="500" cellpadding="5">
  <tr>
     <td> <label for="txtSearch_Archived_Student">Search Student By ID</label>
    </td>
    <td><input type="text" name="txtSearch_Archived_Student" id="txtSearch_Archived_Student" />&nbsp;&nbsp;
      <input type="submit" name="btnSearch" id="btnSearch" value="Go" />
  </tr>
</table>
</form>
<p>&nbsp;</p>
<table border="1" cellpadding="1">
  <tr>
    <td>S/No</td>
    <td>Admission_No</td>
    <td>First_Name</td>
    <td>Middle_Name</td>
    <td>Last_Name</td>
    <td>DOB</td>
    <td>Gender</td>
    <td>Postal_Address</td>
    <td>Postal_Code</td>
    <td>Town</td>
    <td>Form</td>
    <td>Stream</td>
    <td>House</td>
    <td>Operation</td>
  </tr>
  <?php $count=1;do { ?>
    <tr>
      <td><?php echo $count;?></td>
      <td><?php echo $row_rsList_Archived['Admission_No']; ?></td>
      <td><?php echo $row_rsList_Archived['First_Name']; ?></td>
      <td><?php echo $row_rsList_Archived['Middle_Name']; ?></td>
      <td><?php echo $row_rsList_Archived['Last_Name']; ?></td>
      <td><?php echo $row_rsList_Archived['DOB']; ?></td>
      <td><?php echo $row_rsList_Archived['Gender']; ?></td>
      <td><?php echo $row_rsList_Archived['Postal_Address']; ?></td>
      <td><?php echo $row_rsList_Archived['Postal_Code']; ?></td>
      <td><?php echo $row_rsList_Archived['Town']; ?></td>
      <td><?php echo $row_rsList_Archived['Form']; ?></td>
      <td><?php echo $row_rsList_Archived['Stream']; ?></td>
      <td><?php echo $row_rsList_Archived['House']; ?></td>
      <td><a href="reactivate_student.php?Admission_No=<?php echo $row_rsList_Archived['Admission_No']; ?>" onclick="return confirm('Do you really want to reactivate ?')">Activate</a></td>
    </tr>
    <?php $count++;} while ($row_rsList_Archived = mysql_fetch_assoc($rsList_Archived)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsList_Archived);

mysql_free_result($rsCount_Archived_Student);
?>
