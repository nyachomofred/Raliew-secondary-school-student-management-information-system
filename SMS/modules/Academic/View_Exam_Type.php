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

$maxRows_rsView_Exam_Type = 10;
$pageNum_rsView_Exam_Type = 0;
if (isset($_GET['pageNum_rsView_Exam_Type'])) {
  $pageNum_rsView_Exam_Type = $_GET['pageNum_rsView_Exam_Type'];
}
$startRow_rsView_Exam_Type = $pageNum_rsView_Exam_Type * $maxRows_rsView_Exam_Type;

mysql_select_db($database_sms, $sms);
$query_rsView_Exam_Type = "SELECT * FROM tblexam_types";
$query_limit_rsView_Exam_Type = sprintf("%s LIMIT %d, %d", $query_rsView_Exam_Type, $startRow_rsView_Exam_Type, $maxRows_rsView_Exam_Type);
$rsView_Exam_Type = mysql_query($query_limit_rsView_Exam_Type, $sms) or die(mysql_error());
$row_rsView_Exam_Type = mysql_fetch_assoc($rsView_Exam_Type);

if (isset($_GET['totalRows_rsView_Exam_Type'])) {
  $totalRows_rsView_Exam_Type = $_GET['totalRows_rsView_Exam_Type'];
} else {
  $all_rsView_Exam_Type = mysql_query($query_rsView_Exam_Type);
  $totalRows_rsView_Exam_Type = mysql_num_rows($all_rsView_Exam_Type);
}
$totalPages_rsView_Exam_Type = ceil($totalRows_rsView_Exam_Type/$maxRows_rsView_Exam_Type)-1;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="content">
<table border="1" cellpadding="1">
  <tr>
    <td>Id</td>
    <td>Exam_Type</td>
    <td>Marks_Allocation</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsView_Exam_Type['Id']; ?></td>
      <td><?php echo $row_rsView_Exam_Type['Exam_Type']; ?></td>
      <td><?php echo $row_rsView_Exam_Type['Marks_Allocation']; ?></td>
    </tr>
    <?php } while ($row_rsView_Exam_Type = mysql_fetch_assoc($rsView_Exam_Type)); ?>
</table> 
<br>
<p><a href="Edit_Marks_Allocation.php"><img  src="/SMS/SMS/img/edit-gen.png" alt="Edit" data-toggle="tooltip" data-placement="bottom" title="Edit Marks Allocation"  ></a></p>
</div>
</body>
</html>
<?php
mysql_free_result($rsView_Exam_Type);
?>
