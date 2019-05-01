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

$maxRows_rsContactList = 100;
$pageNum_rsContactList = 0;
if (isset($_GET['pageNum_rsContactList'])) {
  $pageNum_rsContactList = $_GET['pageNum_rsContactList'];
}
$startRow_rsContactList = $pageNum_rsContactList * $maxRows_rsContactList;

mysql_select_db($database_sms, $sms);
$query_rsContactList = "SELECT First_Name, Last_Name, Phone_Number, Email FROM add_gurdian";
$query_limit_rsContactList = sprintf("%s LIMIT %d, %d", $query_rsContactList, $startRow_rsContactList, $maxRows_rsContactList);
$rsContactList = mysql_query($query_limit_rsContactList, $sms) or die(mysql_error());
$row_rsContactList = mysql_fetch_assoc($rsContactList);

if (isset($_GET['totalRows_rsContactList'])) {
  $totalRows_rsContactList = $_GET['totalRows_rsContactList'];
} else {
  $all_rsContactList = mysql_query($query_rsContactList);
  $totalRows_rsContactList = mysql_num_rows($all_rsContactList);
}
$totalPages_rsContactList = ceil($totalRows_rsContactList/$maxRows_rsContactList)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Parents Contacts</title>
</head>

<body>
<div class="content">
<form action="Search_Parent_Contact.php" method="get" name="frmStudentAdm"><table width="500" cellpadding="5">
  <tr>
    <td width="117"><label for="txtSearchParent">Search Parent :</label></td>
    <td width="355"><input type="text" name="txtSearchParent" id="txtSearchParent" size="25" placeholder="Enter Student Admission No" />&nbsp;&nbsp;
      <input type="submit" name="btnGo" id="btnGo" value="Go" /></td>
  </tr>
</table>
</form>
<table border="1">
  <tr>
    <td>First_Name</td>
    <td>Last_Name</td>
    <td>Phone_Number</td>
    <td>Email</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsContactList['First_Name']; ?></td>
      <td><?php echo $row_rsContactList['Last_Name']; ?></td>
      <td><?php echo $row_rsContactList['Phone_Number']; ?></td>
      <td><?php echo $row_rsContactList['Email']; ?></td>
    </tr>
    <?php } while ($row_rsContactList = mysql_fetch_assoc($rsContactList)); ?>
</table>
</div>
</body>

</html>
<?php
mysql_free_result($rsContactList);
?>
