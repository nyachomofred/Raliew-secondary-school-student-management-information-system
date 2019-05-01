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

mysql_select_db($database_sms, $sms);
$query_rsView_Teachers = "SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM add_teacher WHERE Status=1";
$rsView_Teachers = mysql_query($query_rsView_Teachers, $sms) or die(mysql_error());
$row_rsView_Teachers = mysql_fetch_assoc($rsView_Teachers);
$totalRows_rsView_Teachers = mysql_num_rows($rsView_Teachers);
$query_rsView_Teachers = "SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM add_teacher";
$rsView_Teachers = mysql_query($query_rsView_Teachers, $sms) or die(mysql_error());
$row_rsView_Teachers = mysql_fetch_assoc($rsView_Teachers);
$totalRows_rsView_Teachers = mysql_num_rows($rsView_Teachers);

mysql_select_db($database_sms, $sms);
$query_rsCountCurrent_Teachers = "SELECT COUNT(*) FROM add_teacher ";
$rsCountCurrent_Teachers = mysql_query($query_rsCountCurrent_Teachers, $sms) or die(mysql_error());
$row_rsCountCurrent_Teachers = mysql_fetch_assoc($rsCountCurrent_Teachers);
$totalRows_rsCountCurrent_Teachers = mysql_num_rows($rsCountCurrent_Teachers);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Teachers</title>
<style type="text/css">
a{
	text-decoration:none;
	color:blue;}
	table,td,tr{
		font-size:13px;}
</style>
</head>

<body>
<div class="content">
<p>Current Teachers :<strong> <?php echo $row_rsCountCurrent_Teachers['COUNT(*)']; ?></strong>&nbsp;&nbsp;<a href="/SMS/SMS/modules/admission/add_teacher.php"><img src="/SMS/SMS/img/teacher_role.png" alt="Add" data-toggle="tooltip" data-placement="bottom" title="Add Teacher" ></a></p>
<table width="500" cellpadding="5">
<form action="Search_Teacher.php" method="post">
  <tr>
    <td>
      <label for="txtSearch_Teacher">Search Teacher By ID :</label>
    </td>
    <td><input type="text" name="txtSearch_Teacher" id="txtSearch_Teacher" />&nbsp; &nbsp;<input type="submit" name="btnSearch" id="btnSearch" value="Go" />
    </td>
  </tr>
  </form>
</table>
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
    <td>Operations</td>
  </tr>
  <?php
  $count=1;
   do { ?>
    <tr>
      <td><?php echo $count?></td>
      <td><?php echo $row_rsView_Teachers['Staff_Id']; ?></td>
      <td><?php echo $row_rsView_Teachers['First_Name']; ?></td>
      <td><?php echo $row_rsView_Teachers['Last_Name']; ?></td>
      <td><?php echo $row_rsView_Teachers['Gender']; ?></td>
      <td><?php echo $row_rsView_Teachers['DOB']; ?></td>
      <td><?php echo $row_rsView_Teachers['Phone_No']; ?></td>
      <td><?php echo $row_rsView_Teachers['Email']; ?></td>
      <td><?php echo $row_rsView_Teachers['Subjects']; ?></td>
      <td>&nbsp;&nbsp;<a href="Update_Teacher.php?Staff_Id=<?php echo $row_rsView_Teachers['Staff_Id']; ?>"><img src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Teacher"></a>&nbsp;&nbsp;&nbsp; <a href="archive_teacher.php?Staff_Id=<?php echo $row_rsView_Teachers['Staff_Id']; ?>" onclick="return confirm('Move To Archive ?')"><img src="/SMS/SMS/img/exit.png" alt="Exit" data-toggle="tooltip" data-placement="bottom" title="Exit Teacher"></a>&nbsp;&nbsp;<a href="../administration/Assign_Role.php?Staff_Id=<?php echo $row_rsView_Teachers['Staff_Id']; ?>"><img src="/SMS/SMS/img/exit.png" alt="Assign" data-toggle="tooltip" data-placement="bottom" title="Assign Role"></a>&nbsp;&nbsp;</a></td>
    </tr>
    <?php 
	$count++;
	} while ($row_rsView_Teachers = mysql_fetch_assoc($rsView_Teachers)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsView_Teachers);

mysql_free_result($rsCountCurrent_Teachers);
?>
