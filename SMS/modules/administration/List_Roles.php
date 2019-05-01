<?php require_once('../../../Connections/sms.php'); 
require_once dirname(__FILE__).'/Admin_dash.php';?>
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

$maxRows_rsListRoles = 50;
$pageNum_rsListRoles = 0;
if (isset($_GET['pageNum_rsListRoles'])) {
  $pageNum_rsListRoles = $_GET['pageNum_rsListRoles'];
}
$startRow_rsListRoles = $pageNum_rsListRoles * $maxRows_rsListRoles;

mysql_select_db($database_sms, $sms);
$query_rsListRoles = "SELECT * FROM add_role";
$query_limit_rsListRoles = sprintf("%s LIMIT %d, %d", $query_rsListRoles, $startRow_rsListRoles, $maxRows_rsListRoles);
$rsListRoles = mysql_query($query_limit_rsListRoles, $sms) or die(mysql_error());
$row_rsListRoles = mysql_fetch_assoc($rsListRoles);

if (isset($_GET['totalRows_rsListRoles'])) {
  $totalRows_rsListRoles = $_GET['totalRows_rsListRoles'];
} else {
  $all_rsListRoles = mysql_query($query_rsListRoles);
  $totalRows_rsListRoles = mysql_num_rows($all_rsListRoles);
}
$totalPages_rsListRoles = ceil($totalRows_rsListRoles/$maxRows_rsListRoles)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | List Roles</title>
</head>
<body>

<div class="content">
<div class="table_views">
Available Roles&nbsp;&nbsp;<a href="Add_Role.php"><img src="/SMS/SMS/img/add-gen.png" alt="Add Role" data-toggle="tooltip" data-placement="bottom" title="Add role"></a>&nbsp;&nbsp;<a href="view_teacher_roles.php"><img src="/SMS/SMS/img/view.png" alt="View Teacher Roles" data-toggle="tooltip" data-placement="bottom" title="View Teacher Roles"></a>
<br /><br />
<table border="1" cellpadding="1">
  <tr>
    <td>Role_Id</td>
    <td>Role_Name</td>
    <td>Operation</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsListRoles['Role_Id']; ?></td>
      <td><?php echo $row_rsListRoles['Role_Name']; ?></td>
      <td><a href="Edit_Role.php?Role_Id=<?php echo $row_rsListRoles['Role_Id']; ?>"><img src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Role"></a> <a href="Delete_Role.php?Role_Id=<?php echo $row_rsListRoles['Role_Id']; ?>" onclick="return confirm('Do you really want to delete ?')">&nbsp;&nbsp;<img src="/SMS/SMS/img/delete.png" alt="Delete" data-toggle="tooltip" data-placement="bottom" title="Delete Role"></a></td>
    </tr>
    <?php } while ($row_rsListRoles = mysql_fetch_assoc($rsListRoles)); ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsListRoles);
?>
