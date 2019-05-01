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

$maxRows_List_All_Students = 50;
$pageNum_List_All_Students = 0;
if (isset($_GET['pageNum_List_All_Students'])) {
  $pageNum_List_All_Students = $_GET['pageNum_List_All_Students'];
}
$startRow_List_All_Students = $pageNum_List_All_Students * $maxRows_List_All_Students;

mysql_select_db($database_sms, $sms);
$query_List_All_Students = "SELECT * FROM add_student";
$query_limit_List_All_Students = sprintf("%s LIMIT %d, %d", $query_List_All_Students, $startRow_List_All_Students, $maxRows_List_All_Students);
$List_All_Students = mysql_query($query_limit_List_All_Students, $sms) or die(mysql_error());
$row_List_All_Students = mysql_fetch_assoc($List_All_Students);

if (isset($_GET['totalRows_List_All_Students'])) {
  $totalRows_List_All_Students = $_GET['totalRows_List_All_Students'];
} else {
  $all_List_All_Students = mysql_query($query_List_All_Students);
  $totalRows_List_All_Students = mysql_num_rows($all_List_All_Students);
}
$totalPages_List_All_Students = ceil($totalRows_List_All_Students/$maxRows_List_All_Students)-1;

mysql_select_db($database_sms, $sms);
$query_Student_Count = "SELECT COUNT( *) FROM add_student";
$Student_Count = mysql_query($query_Student_Count, $sms) or die(mysql_error());
$row_Student_Count = mysql_fetch_assoc($Student_Count);
$totalRows_Student_Count = mysql_num_rows($Student_Count);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Student List</title>
<style type="text/css">
table,tr,td,th{
	font-size:14px;}
	a{
		color:blue;}
</style>
</head>

<body>
<div class="content">
<p>Total Student Population:   <?php echo $row_Student_Count['COUNT( *)']; ?>&nbsp;&nbsp;<a href="/SMS/SMS/modules/admission/Add_Student.php"><img src="/SMS/SMS/img/add-gen.png" alt="Add" data-toggle="tooltip" data-placement="bottom" title="Add Student" ></a></p>
<form id="form1" name="form1" method="post" action="List_One_Student.php">
  <div class="box">
  <div class="container-1">
      <span class="icon"><i class="fa fa-search"></i></span>
  <input type="search" name="txtSearch_Student" id="search" placeholder="Search..." />
  <input type="submit" name="btnSearch_Student" id="btnSearch_Student" value="Go" />
  </div><br /><br />
</div>
  
</form>

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
  <?php  
  $count=1;
  do { ?>
    <tr>
      <td><?php echo $count;?></td>
      <td><?php echo $row_List_All_Students['Admission_No']; ?></td>
      <td><?php echo $row_List_All_Students['First_Name']; ?></td>
      <td><?php echo $row_List_All_Students['Middle_Name']; ?></td>
      <td><?php echo $row_List_All_Students['Last_Name']; ?></td>
      <td><?php echo $row_List_All_Students['DOB']; ?></td>
      <td><?php echo $row_List_All_Students['Gender']; ?></td>
      <td><?php echo $row_List_All_Students['Postal_Address']; ?></td>
      <td><?php echo $row_List_All_Students['Postal_Code']; ?></td>
      <td><?php echo $row_List_All_Students['Town']; ?></td>
      <td><?php echo $row_List_All_Students['Form']; ?></td>
      <td><?php echo $row_List_All_Students['Stream']; ?></td>
      <td><?php echo $row_List_All_Students['House']; ?></td>
      <td>&nbsp;&nbsp;<a href="Update_Student.php?Admission_No=<?php echo $row_List_All_Students['Admission_No']; ?>" style="text-decoration:none"><img src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Student"></a>&nbsp;&nbsp;&nbsp; <a href="Archive_Student.php?Admission_No=<?php echo $row_List_All_Students['Admission_No']; ?>" onclick="return confirm('Move to Archive ?')" style="text-decoration:none"><img src="/SMS/SMS/img/exit.png" alt="Exit" data-toggle="tooltip" data-placement="bottom" title="Exit Student"></a></td>
    </tr>
    <?php 
	$count++;
	} while ($row_List_All_Students = mysql_fetch_assoc($List_All_Students)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($List_All_Students);

mysql_free_result($Student_Count);
?>
