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

$maxRows_rsArchived_Teachers = 50;
$pageNum_rsArchived_Teachers = 0;
if (isset($_GET['pageNum_rsArchived_Teachers'])) {
  $pageNum_rsArchived_Teachers = $_GET['pageNum_rsArchived_Teachers'];
}
$startRow_rsArchived_Teachers = $pageNum_rsArchived_Teachers * $maxRows_rsArchived_Teachers;

mysql_select_db($database_sms, $sms);
$query_rsArchived_Teachers = "SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM archived_teachers";
$query_limit_rsArchived_Teachers = sprintf("%s LIMIT %d, %d", $query_rsArchived_Teachers, $startRow_rsArchived_Teachers, $maxRows_rsArchived_Teachers);
$rsArchived_Teachers = mysql_query($query_limit_rsArchived_Teachers, $sms) or die(mysql_error());
$row_rsArchived_Teachers = mysql_fetch_assoc($rsArchived_Teachers);

if (isset($_GET['totalRows_rsArchived_Teachers'])) {
  $totalRows_rsArchived_Teachers = $_GET['totalRows_rsArchived_Teachers'];
} else {
  $all_rsArchived_Teachers = mysql_query($query_rsArchived_Teachers);
  $totalRows_rsArchived_Teachers = mysql_num_rows($all_rsArchived_Teachers);
}
$totalPages_rsArchived_Teachers = ceil($totalRows_rsArchived_Teachers/$maxRows_rsArchived_Teachers)-1;

mysql_select_db($database_sms, $sms);
$query_rsTotalArchived = "SELECT count(*) FROM archived_teachers";
$rsTotalArchived = mysql_query($query_rsTotalArchived, $sms) or die(mysql_error());
$row_rsTotalArchived = mysql_fetch_assoc($rsTotalArchived);
$totalRows_rsTotalArchived = mysql_num_rows($rsTotalArchived);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Archived Teachers</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
<p>Total Archived Teachers : <?php echo $row_rsTotalArchived['count(*)']; ?></p>
<form id="form1" name="form1" method="post" action="Search_Archived_Teacher.php">
<table width="500" cellpadding="5">
  <tr>
    <td>
      <label for="txtSearch_ArchivedTacher">Search By ID</label>
    </td>
    <td><input type="text" name="txtSearch_ArchivedTacher" id="txtSearch_ArchivedTacher" />&nbsp;
      <input type="submit" name="btnSearchArchived_Teacher" id="btnSearchArchived_Teacher" value="Go" />

</td>
  </tr>
</table>
</form>
<p>
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
    <td>Subjects</td>
    <td>Operation</td>
  </tr>
  <?php 
  $count=1;
  do { ?>
    <tr>
      <td><?php echo $count;?></td>
      <td><?php echo $row_rsArchived_Teachers['Staff_Id']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['First_Name']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['Last_Name']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['Gender']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['DOB']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['Phone_No']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['Email']; ?></td>
      <td><?php echo $row_rsArchived_Teachers['Subjects']; ?></td>
      <td><a href="reactivate_teacher.php?Staff_Id=<?php echo $row_rsArchived_Teachers['Staff_Id']; ?>">Activate</a> <a href="Delete_Teacher.php?Staff_Id=<?php echo $row_rsArchived_Teachers['Staff_Id']; ?>" onclick="return confirm('Do you really want to delete ?')">Delete Permenently</a></td>
    </tr>
    <?php 
	$count++;
	} while ($row_rsArchived_Teachers = mysql_fetch_assoc($rsArchived_Teachers)); ?>
</table>
</p></div>
</body>
</html>
<?php
mysql_free_result($rsArchived_Teachers);

mysql_free_result($rsTotalArchived);
?>
