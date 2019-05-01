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

$maxRows_rsList_Staff = 50;
$pageNum_rsList_Staff = 0;
if (isset($_GET['pageNum_rsList_Staff'])) {
  $pageNum_rsList_Staff = $_GET['pageNum_rsList_Staff'];
}
$startRow_rsList_Staff = $pageNum_rsList_Staff * $maxRows_rsList_Staff;

mysql_select_db($database_sms, $sms);
$query_rsList_Staff = "SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, `Role` FROM add_staff";
$query_limit_rsList_Staff = sprintf("%s LIMIT %d, %d", $query_rsList_Staff, $startRow_rsList_Staff, $maxRows_rsList_Staff);
$rsList_Staff = mysql_query($query_limit_rsList_Staff, $sms) or die(mysql_error());
$row_rsList_Staff = mysql_fetch_assoc($rsList_Staff);

if (isset($_GET['totalRows_rsList_Staff'])) {
  $totalRows_rsList_Staff = $_GET['totalRows_rsList_Staff'];
} else {
  $all_rsList_Staff = mysql_query($query_rsList_Staff);
  $totalRows_rsList_Staff = mysql_num_rows($all_rsList_Staff);
}
$totalPages_rsList_Staff = ceil($totalRows_rsList_Staff/$maxRows_rsList_Staff)-1;

mysql_select_db($database_sms, $sms);
$query_rsCountStaff = "SELECT COUNT(*) FROM `add_staff` ";
$rsCountStaff = mysql_query($query_rsCountStaff, $sms) or die(mysql_error());
$row_rsCountStaff = mysql_fetch_assoc($rsCountStaff);
$totalRows_rsCountStaff = mysql_num_rows($rsCountStaff);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | List Staff</title>
</head>

<body>
<div class="content">
Current Staffs: <strong><?php echo $row_rsCountStaff['COUNT(*)']; ?></strong>&nbsp;&nbsp;<a href="/SMS/SMS/modules/admission/Add_Staff.php"><img src="/SMS/SMS/img/add-gen.png" alt="Add" data-toggle="tooltip" data-placement="bottom" title="Add Staff" ></a><br /><br />
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
    <td>Operation</td>
  </tr>
  <?php
  $count=1; do { ?>
    <tr>
      <td><?php echo $count;?></td>
      <td><?php echo $row_rsList_Staff['Staff_Id']; ?></td>
      <td><?php echo $row_rsList_Staff['First_Name']; ?></td>
      <td><?php echo $row_rsList_Staff['Last_Name']; ?></td>
      <td><?php echo $row_rsList_Staff['Gender']; ?></td>
      <td><?php echo $row_rsList_Staff['DOB']; ?></td>
      <td><?php echo $row_rsList_Staff['Phone_No']; ?></td>
      <td><?php echo $row_rsList_Staff['Email']; ?></td>
      <td><?php echo $row_rsList_Staff['Role']; ?></td>
      <td>&nbsp;&nbsp;<a href="Edit_Staff.php?Staff_Id=<?php echo $row_rsList_Staff['Staff_Id']; ?>"><img src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Staff"></a>&nbsp;&nbsp;&nbsp;</a> <a href="Archive_Staff.php?Staff_Id=<?php echo $row_rsList_Staff['Staff_Id']; ?>" onclick="return confirm('Move to Archive ?')"><img src="/SMS/SMS/img/exit.png" alt="Exit" data-toggle="tooltip" data-placement="bottom" title="Exit Staff"></a></td>
    </tr>
    <?php 
	$count++;} while ($row_rsList_Staff = mysql_fetch_assoc($rsList_Staff)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsList_Staff);

mysql_free_result($rsCountStaff);
?>
