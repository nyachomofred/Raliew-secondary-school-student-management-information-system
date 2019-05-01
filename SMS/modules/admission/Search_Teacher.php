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

$maxRows_rsSearchTeacher = 10;
$pageNum_rsSearchTeacher = 0;
if (isset($_GET['pageNum_rsSearchTeacher'])) {
  $pageNum_rsSearchTeacher = $_GET['pageNum_rsSearchTeacher'];
}
$startRow_rsSearchTeacher = $pageNum_rsSearchTeacher * $maxRows_rsSearchTeacher;

$colname_rsSearchTeacher = "-1";
if (isset($_POST['txtSearch_Teacher'])) {
  $colname_rsSearchTeacher = $_POST['txtSearch_Teacher'];
}
mysql_select_db($database_sms, $sms);
$query_rsSearchTeacher = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM add_teacher WHERE Staff_Id = %s", GetSQLValueString($colname_rsSearchTeacher, "int"));
$query_limit_rsSearchTeacher = sprintf("%s LIMIT %d, %d", $query_rsSearchTeacher, $startRow_rsSearchTeacher, $maxRows_rsSearchTeacher);
$rsSearchTeacher = mysql_query($query_limit_rsSearchTeacher, $sms) or die(mysql_error());
$row_rsSearchTeacher = mysql_fetch_assoc($rsSearchTeacher);

if (isset($_GET['totalRows_rsSearchTeacher'])) {
  $totalRows_rsSearchTeacher = $_GET['totalRows_rsSearchTeacher'];
} else {
  $all_rsSearchTeacher = mysql_query($query_rsSearchTeacher);
  $totalRows_rsSearchTeacher = mysql_num_rows($all_rsSearchTeacher);
}
$totalPages_rsSearchTeacher = ceil($totalRows_rsSearchTeacher/$maxRows_rsSearchTeacher)-1;

$colname_rsSearchTeacher = "-1";
if (isset($_POST['txtSearch_Teacher'])) {
  $colname_rsSearchTeacher = $_POST['txtSearch_Teacher'];
}
mysql_select_db($database_sms, $sms);
$query_rsSearchTeacher = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM add_teacher WHERE Staff_Id = %s", GetSQLValueString($colname_rsSearchTeacher, "int"));
$rsSearchTeacher = mysql_query($query_rsSearchTeacher, $sms) or die(mysql_error());
$row_rsSearchTeacher = mysql_fetch_assoc($rsSearchTeacher);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Search</title>
</head>

<body>
<table border="1" cellpadding="1">
  <tr>
    <td>Staff_Id</td>
    <td>First_Name</td>
    <td>Last_Name</td>
    <td>Gender</td>
    <td>DOB</td>
    <td>Phone_No</td>
    <td>Email</td>
    <td>Subjects</td>
    <td>Operations</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsSearchTeacher['Staff_Id']; ?></td>
      <td><?php echo $row_rsSearchTeacher['First_Name']; ?></td>
      <td><?php echo $row_rsSearchTeacher['Last_Name']; ?></td>
      <td><?php echo $row_rsSearchTeacher['Gender']; ?></td>
      <td><?php echo $row_rsSearchTeacher['DOB']; ?></td>
      <td><?php echo $row_rsSearchTeacher['Phone_No']; ?></td>
      <td><?php echo $row_rsSearchTeacher['Email']; ?></td>
      <td><?php echo $row_rsSearchTeacher['Subjects']; ?></td>
      <td><a href="Update_Teacher.php?Staff_Id=<?php echo $row_rsSearchTeacher['Staff_Id']; ?>">Edit</a> <a href="archive_teacher.php?Staff_Id=<?php echo $row_rsSearchTeacher['Staff_Id']; ?>" onclick="return confirm('Move to Archives ?')">Exit</a></td>
    </tr>
    <?php } while ($row_rsSearchTeacher = mysql_fetch_assoc($rsSearchTeacher)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsSearchTeacher);
?>
