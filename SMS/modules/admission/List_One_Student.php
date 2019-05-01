<?php require_once('../../../Connections/sms.php');
require dirname(__FILE__).'/../administration/Admin_dash.php'; ?>
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

$maxRows_List_One_Student = 10;
$pageNum_List_One_Student = 0;
if (isset($_GET['pageNum_List_One_Student'])) {
  $pageNum_List_One_Student = $_GET['pageNum_List_One_Student'];
}
$startRow_List_One_Student = $pageNum_List_One_Student * $maxRows_List_One_Student;

$colname_List_One_Student = "-1";
if (isset($_POST['txtSearch_Student'])) {
  $colname_List_One_Student = $_POST['txtSearch_Student'];
}
mysql_select_db($database_sms, $sms);
$query_List_One_Student = sprintf("SELECT * FROM add_student WHERE Admission_No = %s", GetSQLValueString($colname_List_One_Student, "int"));
$query_limit_List_One_Student = sprintf("%s LIMIT %d, %d", $query_List_One_Student, $startRow_List_One_Student, $maxRows_List_One_Student);
$List_One_Student = mysql_query($query_limit_List_One_Student, $sms) or die(mysql_error());
$row_List_One_Student = mysql_fetch_assoc($List_One_Student);

if (isset($_GET['totalRows_List_One_Student'])) {
  $totalRows_List_One_Student = $_GET['totalRows_List_One_Student'];
} else {
  $all_List_One_Student = mysql_query($query_List_One_Student);
  $totalRows_List_One_Student = mysql_num_rows($all_List_One_Student);
}
$totalPages_List_One_Student = ceil($totalRows_List_One_Student/$maxRows_List_One_Student)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM| Search one student</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
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
      <td><?php echo $row_List_One_Student['Admission_No']; ?></td>
      <td><?php echo $row_List_One_Student['First_Name']; ?></td>
      <td><?php echo $row_List_One_Student['Middle_Name']; ?></td>
      <td><?php echo $row_List_One_Student['Last_Name']; ?></td>
      <td><?php echo $row_List_One_Student['DOB']; ?></td>
      <td><?php echo $row_List_One_Student['Gender']; ?></td>
      <td><?php echo $row_List_One_Student['Postal_Address']; ?></td>
      <td><?php echo $row_List_One_Student['Postal_Code']; ?></td>
      <td><?php echo $row_List_One_Student['Town']; ?></td>
      <td><?php echo $row_List_One_Student['Form']; ?></td>
      <td><?php echo $row_List_One_Student['Stream']; ?></td>
      <td><?php echo $row_List_One_Student['House']; ?></td>
      <td><a href="Update_Student.php?Admission_No=<?php echo $row_List_One_Student['Admission_No']; ?>" style="text-decoration:none">Edit</a> <a href="Archive_Student.php?Admission_No=<?php echo $row_List_One_Student['Admission_No']; ?>" style="text-decoration:none" onclick="return confirm(Move to Archive ?)">Exit</a></td>
    </tr>
    <?php } while ($row_List_One_Student = mysql_fetch_assoc($List_One_Student)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($List_One_Student);
?>
