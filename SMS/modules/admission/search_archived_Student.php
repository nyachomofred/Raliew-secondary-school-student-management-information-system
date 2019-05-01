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

$maxRows_rsSearch_Archived_Student = 10;
$pageNum_rsSearch_Archived_Student = 0;
if (isset($_GET['pageNum_rsSearch_Archived_Student'])) {
  $pageNum_rsSearch_Archived_Student = $_GET['pageNum_rsSearch_Archived_Student'];
}
$startRow_rsSearch_Archived_Student = $pageNum_rsSearch_Archived_Student * $maxRows_rsSearch_Archived_Student;

$colname_rsSearch_Archived_Student = "-1";
if (isset($_POST['txtSearch_Archived_Student'])) {
  $colname_rsSearch_Archived_Student = $_POST['txtSearch_Archived_Student'];
}
mysql_select_db($database_sms, $sms);
$query_rsSearch_Archived_Student = sprintf("SELECT Admission_No, First_Name, Middle_Name, Last_Name, DOB, Gender, Postal_Address, Postal_Code, Town, `Form`, Stream, House FROM archived_students WHERE Admission_No = %s", GetSQLValueString($colname_rsSearch_Archived_Student, "int"));
$query_limit_rsSearch_Archived_Student = sprintf("%s LIMIT %d, %d", $query_rsSearch_Archived_Student, $startRow_rsSearch_Archived_Student, $maxRows_rsSearch_Archived_Student);
$rsSearch_Archived_Student = mysql_query($query_limit_rsSearch_Archived_Student, $sms) or die(mysql_error());
$row_rsSearch_Archived_Student = mysql_fetch_assoc($rsSearch_Archived_Student);

if (isset($_GET['totalRows_rsSearch_Archived_Student'])) {
  $totalRows_rsSearch_Archived_Student = $_GET['totalRows_rsSearch_Archived_Student'];
} else {
  $all_rsSearch_Archived_Student = mysql_query($query_rsSearch_Archived_Student);
  $totalRows_rsSearch_Archived_Student = mysql_num_rows($all_rsSearch_Archived_Student);
}
$totalPages_rsSearch_Archived_Student = ceil($totalRows_rsSearch_Archived_Student/$maxRows_rsSearch_Archived_Student)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Search Archived Student</title>
</head>

<body>
<table border="1" cellpadding="1">
  <tr>
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
    <td>Operations</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsSearch_Archived_Student['Admission_No']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['First_Name']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Middle_Name']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Last_Name']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['DOB']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Gender']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Postal_Address']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Postal_Code']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Town']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Form']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['Stream']; ?></td>
      <td><?php echo $row_rsSearch_Archived_Student['House']; ?></td>
      <td><a href="reactivate_student.php?Admission_No=<?php echo $row_rsSearch_Archived_Student['Admission_No']; ?>" onclick="return confirm('Do you really want to Reactivate ?')">Activate</a></td>
    </tr>
    <?php } while ($row_rsSearch_Archived_Student = mysql_fetch_assoc($rsSearch_Archived_Student)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsSearch_Archived_Student);
?>
