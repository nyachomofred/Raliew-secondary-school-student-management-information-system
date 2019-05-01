<?php require_once('../../../Connections/sms.php'); ?>
<?php require_once('../../../Connections/sms.php'); ?>
<?php require_once('../../../Connections/sms.php');
require_once('Admin_dash.php'); ?>
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

$maxRows_rs_viewHouse = 50;
$pageNum_rs_viewHouse = 0;
if (isset($_GET['pageNum_rs_viewHouse'])) {
  $pageNum_rs_viewHouse = $_GET['pageNum_rs_viewHouse'];
}
$startRow_rs_viewHouse = $pageNum_rs_viewHouse * $maxRows_rs_viewHouse;

mysql_select_db($database_sms, $sms);
$query_rs_viewHouse = "SELECT * FROM add_house";
$query_limit_rs_viewHouse = sprintf("%s LIMIT %d, %d", $query_rs_viewHouse, $startRow_rs_viewHouse, $maxRows_rs_viewHouse);
$rs_viewHouse = mysql_query($query_limit_rs_viewHouse, $sms) or die(mysql_error());
$row_rs_viewHouse = mysql_fetch_assoc($rs_viewHouse);

if (isset($_GET['totalRows_rs_viewHouse'])) {
  $totalRows_rs_viewHouse = $_GET['totalRows_rs_viewHouse'];
} else {
  $all_rs_viewHouse = mysql_query($query_rs_viewHouse);
  $totalRows_rs_viewHouse = mysql_num_rows($all_rs_viewHouse);
}
$totalPages_rs_viewHouse = ceil($totalRows_rs_viewHouse/$maxRows_rs_viewHouse)-1;

mysql_select_db($database_sms, $sms);
$query_rsCount_House = "SELECT COUNT(*) FROM `add_house`";
$rsCount_House = mysql_query($query_rsCount_House, $sms) or die(mysql_error());
$row_rsCount_House = mysql_fetch_assoc($rsCount_House);
$totalRows_rsCount_House = mysql_num_rows($rsCount_House);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="content">
<div class="table_views">
Available Houses :<strong><?php echo $row_rsCount_House['COUNT(*)']; ?></strong>&nbsp;&nbsp;<a href="Add_House.php" data-toggle="tooltip" data-placement="bottom" title="Add House"><img src="/SMS/SMS/img/add-gen.png" alt="Add" ></a>
<br />
<table border="1" cellpadding="1">
  <tr>
    <td>S/NO</td>
    <td>House_ID</td>
    <td>House_Name</td>
    <td>Bed_Capacity</td>
    <td>Operations</td>
  </tr>
  <?php $count=1; do { ?>
    <tr>
      <td><?php echo $count?></td>
      <td><?php echo $row_rs_viewHouse['House_ID']; ?></td>
      <td><?php echo $row_rs_viewHouse['House_Name']; ?></td>
      <td><?php echo $row_rs_viewHouse['Bed_Capacity']; ?></td>
      <td><a href="Edit_House.php?House_ID=<?php echo $row_rs_viewHouse['House_ID']; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit House">&nbsp;&nbsp;&nbsp;<img src="/SMS/SMS/img/edit-gen.png" alt="Edit"></a> <a href="Delete_House.php?House_ID=<?php echo $row_rs_viewHouse['House_ID']; ?>" onclick="return confirm('Do you really want to delete')"  data-toggle="tooltip" data-placement="bottom" title="Delete House">&nbsp;&nbsp;<img src="/SMS/SMS/img/delete.png" alt="Delete"> </a></td>
    </tr>
    <?php $count++;} while ($row_rs_viewHouse = mysql_fetch_assoc($rs_viewHouse)); ?>
    
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rs_viewHouse);

mysql_free_result($rsCount_House);
?>
