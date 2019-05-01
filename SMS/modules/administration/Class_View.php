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

mysql_select_db($database_sms, $sms);
$query_View_Class = "SELECT Class_Id, CONCAT('FORM',' ',Form,' ',Name)as Class,Capacity FROM add_class ORDER BY Class";
$View_Class = mysql_query($query_View_Class, $sms) or die(mysql_error());
$row_View_Class = mysql_fetch_assoc($View_Class);
$totalRows_View_Class = mysql_num_rows($View_Class);

mysql_select_db($database_sms, $sms);
$query_rsNum_Classes = "SELECT COUNT(*) FROM add_class";
$rsNum_Classes = mysql_query($query_rsNum_Classes, $sms) or die(mysql_error());
$row_rsNum_Classes = mysql_fetch_assoc($rsNum_Classes);
$totalRows_rsNum_Classes = mysql_num_rows($rsNum_Classes);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Classes</title>
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
<p> Available Classes:<strong> <?php echo $row_rsNum_Classes['COUNT(*)']; ?></strong>&nbsp;&nbsp;<a href="Add_Class.php" data-toggle="tooltip" data-placement="bottom" title="Add Class"><img src="/SMS/SMS/img/add-gen.png" alt="Add" ></a>&nbsp;&nbsp;</a></p>
<br />
<table border="5" align="center" cellpadding="1">
  <tr>
    <td>S/No</td>
    
    <td>Name</td>
    <td>Capacity</td>
    <td>Operartions</td>
  </tr>
  <?php
  
  $count=1;
   do { ?>
    <tr>
      <td><?php echo $count; ?></td>
      
      <td><?php echo $row_View_Class['Class']; ?></td>
      <td><?php echo $row_View_Class['Capacity']; ?></td>
      <td><a style="text-decoration:none; color:blue" href="Class_Edit.php?Class_Id=<?php echo $row_View_Class['Class_Id']; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Class">&nbsp;&nbsp;&nbsp;<img src="/SMS/SMS/img/edit-gen.png" alt="Edit"></a>&nbsp;&nbsp;<a href="Delete_Class.php?Class_Id=<?php echo $row_View_Class['Class_Id']; ?>" onclick="return confirm('Do you really want to delete ?')" style="text-decoration:none; color:blue" data-toggle="tooltip" data-placement="bottom" title="Delete Class">&nbsp;&nbsp;<img src="/SMS/SMS/img/delete.png" alt="Delete"></a></td>
    </tr>
    <?php 
	
	$count++;} while ($row_View_Class = mysql_fetch_assoc($View_Class)); ?>
</table>
</div><!--end of class view div-->
</div>

</body>
</html>
<?php
mysql_free_result($View_Class);

mysql_free_result($rsNum_Classes);
?>
