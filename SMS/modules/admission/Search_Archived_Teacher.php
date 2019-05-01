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

$maxRows_Search_Archived_Teacher = 50;
$pageNum_Search_Archived_Teacher = 0;
if (isset($_GET['pageNum_Search_Archived_Teacher'])) {
  $pageNum_Search_Archived_Teacher = $_GET['pageNum_Search_Archived_Teacher'];
}
$startRow_Search_Archived_Teacher = $pageNum_Search_Archived_Teacher * $maxRows_Search_Archived_Teacher;

$colname_Search_Archived_Teacher = "-1";
if (isset($_POST['txtSearch_ArchivedTacher'])) {
  $colname_Search_Archived_Teacher = $_POST['txtSearch_ArchivedTacher'];
}
mysql_select_db($database_sms, $sms);
$query_Search_Archived_Teacher = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM archived_teachers WHERE Staff_Id = %s", GetSQLValueString($colname_Search_Archived_Teacher, "int"));
$query_limit_Search_Archived_Teacher = sprintf("%s LIMIT %d, %d", $query_Search_Archived_Teacher, $startRow_Search_Archived_Teacher, $maxRows_Search_Archived_Teacher);
$Search_Archived_Teacher = mysql_query($query_limit_Search_Archived_Teacher, $sms) or die(mysql_error());
$row_Search_Archived_Teacher = mysql_fetch_assoc($Search_Archived_Teacher);

if (isset($_GET['totalRows_Search_Archived_Teacher'])) {
  $totalRows_Search_Archived_Teacher = $_GET['totalRows_Search_Archived_Teacher'];
} else {
  $all_Search_Archived_Teacher = mysql_query($query_Search_Archived_Teacher);
  $totalRows_Search_Archived_Teacher = mysql_num_rows($all_Search_Archived_Teacher);
}
$totalPages_Search_Archived_Teacher = ceil($totalRows_Search_Archived_Teacher/$maxRows_Search_Archived_Teacher)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Seach Archived Teacher</title>
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
      <td><?php echo $row_Search_Archived_Teacher['Staff_Id']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['First_Name']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['Last_Name']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['Gender']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['DOB']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['Phone_No']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['Email']; ?></td>
      <td><?php echo $row_Search_Archived_Teacher['Subjects']; ?></td>
      <td><a href="reactivate_teacher.php?Staff_Id=<?php echo $row_Search_Archived_Teacher['Staff_Id']; ?>">Activate</a> <a href="Delete_Teacher.php?Staff_Id=<?php echo $row_Search_Archived_Teacher['Staff_Id']; ?>" onclick="return confirm('Do you really want to delete ?')">Delete Permenently</a></td>
    </tr>
    <?php } while ($row_Search_Archived_Teacher = mysql_fetch_assoc($Search_Archived_Teacher)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Search_Archived_Teacher);
?>
