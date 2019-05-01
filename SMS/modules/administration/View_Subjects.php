<?php require_once('../../../Connections/sms.php'); 
require_once dirname(__FILE__).'/Admin_dash.php';
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

$maxRows_rsViewSubjects = 50;
$pageNum_rsViewSubjects = 0;
if (isset($_GET['pageNum_rsViewSubjects'])) {
  $pageNum_rsViewSubjects = $_GET['pageNum_rsViewSubjects'];
}
$startRow_rsViewSubjects = $pageNum_rsViewSubjects * $maxRows_rsViewSubjects;

mysql_select_db($database_sms, $sms);
$query_rsViewSubjects = "SELECT * FROM add_subject";
$query_limit_rsViewSubjects = sprintf("%s LIMIT %d, %d", $query_rsViewSubjects, $startRow_rsViewSubjects, $maxRows_rsViewSubjects);
$rsViewSubjects = mysql_query($query_limit_rsViewSubjects, $sms) or die(mysql_error());
$row_rsViewSubjects = mysql_fetch_assoc($rsViewSubjects);

if (isset($_GET['totalRows_rsViewSubjects'])) {
  $totalRows_rsViewSubjects = $_GET['totalRows_rsViewSubjects'];
} else {
  $all_rsViewSubjects = mysql_query($query_rsViewSubjects);
  $totalRows_rsViewSubjects = mysql_num_rows($all_rsViewSubjects);
}
$totalPages_rsViewSubjects = ceil($totalRows_rsViewSubjects/$maxRows_rsViewSubjects)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Subjects</title>

<style type="text/css">
        tr:nth-child(even) {
                background-color: rgb(223,233,244)
              }
         tr:nth-child(odd) {
               background-color:rgb(255,255,255)
        }
        </style>
</head>

<body>
<div class="content">
<div class="table_views">
<table border="1" cellpadding="1">
  <tr>
    <th>S/No</th>
    <th>Subject_Id</th>
    <th>Name</th>
    <th>Short_Name</th>
    <th>Operations</th>
  </tr>
  <?php $count=1; do { ?>
    <tr>
      <td><?php echo $count ?></td>
      <td><?php echo $row_rsViewSubjects['Subject_Id']; ?></td>
      <td><?php echo $row_rsViewSubjects['Name']; ?></td>
      <td><?php echo $row_rsViewSubjects['Short_Name']; ?></td>
      <td><a href="Edit_Subject.php?Subject_Id=<?php echo $row_rsViewSubjects['Subject_Id']; ?>">&nbsp;&nbsp;&nbsp;<img src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Subject"></a> <a href="Delete_Subject.php?Subject_Id=<?php echo $row_rsViewSubjects['Subject_Id']; ?>"  data-toggle="tooltip" data-placement="bottom" title="Delete Subject" onclick="return confirm('Do you really want to delete?')" >&nbsp;&nbsp;<img src="/SMS/SMS/img/delete.png" alt="Delete"></a></td>
    </tr>
    <?php $count++; } while ($row_rsViewSubjects = mysql_fetch_assoc($rsViewSubjects)); ?>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($rsViewSubjects);
?>
