<?php require_once('../../../../Connections/sms.php');
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
$query_rsTeachers_contact_list = "SELECT First_Name, Last_Name, Phone_No, Email FROM add_teacher";
$rsTeachers_contact_list = mysql_query($query_rsTeachers_contact_list, $sms) or die(mysql_error());
$row_rsTeachers_contact_list = mysql_fetch_assoc($rsTeachers_contact_list);
$totalRows_rsTeachers_contact_list = mysql_num_rows($rsTeachers_contact_list);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Teachers Contacts</title>
</head>

<body>
<div class="content">
<table border="1">
  <tr>
    <td>First_Name</td>
    <td>Last_Name</td>
    <td>Phone_No</td>
    <td>Email</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsTeachers_contact_list['First_Name']; ?></td>
      <td><?php echo $row_rsTeachers_contact_list['Last_Name']; ?></td>
      <td><?php echo $row_rsTeachers_contact_list['Phone_No']; ?></td>
      <td><?php echo $row_rsTeachers_contact_list['Email']; ?></td>
    </tr>
    <?php } while ($row_rsTeachers_contact_list = mysql_fetch_assoc($rsTeachers_contact_list)); ?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($rsTeachers_contact_list);
?>
