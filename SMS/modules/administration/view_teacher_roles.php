<?php require_once('../../../Connections/sms.php'); 
require_once('Admin_dash.php');
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

$maxRows_rsView_Teacher_Roles = 50;
$pageNum_rsView_Teacher_Roles = 0;
if (isset($_GET['pageNum_rsView_Teacher_Roles'])) {
  $pageNum_rsView_Teacher_Roles = $_GET['pageNum_rsView_Teacher_Roles'];
}
$startRow_rsView_Teacher_Roles = $pageNum_rsView_Teacher_Roles * $maxRows_rsView_Teacher_Roles;

mysql_select_db($database_sms, $sms);
$query_rsView_Teacher_Roles = "SELECT add_teacher.Staff_Id, add_teacher.First_Name,add_teacher.Last_Name,add_role.Role_Name FROM add_teacher,add_role,teacher_role WHERE add_teacher.Staff_Id=teacher_role.Staff_Id AND add_role.Role_Id=teacher_role.Role_ID ORDER BY add_role.Role_Id ";
$query_limit_rsView_Teacher_Roles = sprintf("%s LIMIT %d, %d", $query_rsView_Teacher_Roles, $startRow_rsView_Teacher_Roles, $maxRows_rsView_Teacher_Roles);
$rsView_Teacher_Roles = mysql_query($query_limit_rsView_Teacher_Roles, $sms) or die(mysql_error());
$row_rsView_Teacher_Roles = mysql_fetch_assoc($rsView_Teacher_Roles);

if (isset($_GET['totalRows_rsView_Teacher_Roles'])) {
  $totalRows_rsView_Teacher_Roles = $_GET['totalRows_rsView_Teacher_Roles'];
} else {
  $all_rsView_Teacher_Roles = mysql_query($query_rsView_Teacher_Roles);
  $totalRows_rsView_Teacher_Roles = mysql_num_rows($all_rsView_Teacher_Roles);
}
$totalPages_rsView_Teacher_Roles = ceil($totalRows_rsView_Teacher_Roles/$maxRows_rsView_Teacher_Roles)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Teacher Roles</title>
</head>

<body>
<div class="content">
<div class="table_views">
Teacher Roles
<table border="1" cellpadding="1">
  <tr>
    <td>S/No</td>
    <td>Staff_Id</td>
    <td>First_Name</td>
    <td>Last_Name</td>
    <td>Role_Name</td>
    <td>Operations</td>
  </tr>
  <?php $count=1;do { ?>
    <tr>
      <td><?php echo $count;?></td>
      <td><?php echo $row_rsView_Teacher_Roles['Staff_Id']; ?></td>
      <td><?php echo $row_rsView_Teacher_Roles['First_Name']; ?></td>
      <td><?php echo $row_rsView_Teacher_Roles['Last_Name']; ?></td>
      <td><?php echo $row_rsView_Teacher_Roles['Role_Name']; ?></td>
      <td align="center"><a href="Revoke_Teacher_Role.php?Staff_Id=<?php echo $row_rsView_Teacher_Roles['Staff_Id']; ?>&amp;Role_Name=<?php echo $row_rsView_Teacher_Roles['Role_Name']; ?>" onclick="return confirm('Do you really want to revoke ?')"><img src="/SMS/SMS/img/revoke.png" alt="Revoke" data-toggle="tooltip" data-placement="bottom" title="Revoke Role"></a></td>
    </tr>
    <?php 
	$count++;} while ($row_rsView_Teacher_Roles = mysql_fetch_assoc($rsView_Teacher_Roles)); ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsView_Teacher_Roles);
?>
