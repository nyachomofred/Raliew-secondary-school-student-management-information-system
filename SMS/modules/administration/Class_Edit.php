<?php require_once('../../../Connections/sms.php'); 
require_once('Admin_dash.php');?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE add_class SET `Form`=%s, Name=%s, Capacity=%s WHERE Class_Id=%s",
                       GetSQLValueString($_POST['Form'], "int"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Capacity'], "int"),
                       GetSQLValueString($_POST['Class_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "Class_View.php?" . $row_Class_Edit['Class_Id'] . "=" . $row_Class_Edit['Class_Id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Class_Edit = "-1";
if (isset($_GET['Class_Id'])) {
  $colname_Class_Edit = $_GET['Class_Id'];
}
mysql_select_db($database_sms, $sms);
$query_Class_Edit = sprintf("SELECT * FROM add_class WHERE Class_Id = %s", GetSQLValueString($colname_Class_Edit, "int"));
$Class_Edit = mysql_query($query_Class_Edit, $sms) or die(mysql_error());
$row_Class_Edit = mysql_fetch_assoc($Class_Edit);
$totalRows_Class_Edit = mysql_num_rows($Class_Edit);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Edit Classes</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container" >
<div class="form-title"><h2>Update Class</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Class Id:</td>
      <td><?php echo $row_Class_Edit['Class_Id']; ?></td>
    </tr>
    </table>
    
    <div class="form-title">Form</div>
      <input type="text" name="Form" value="<?php echo htmlentities($row_Class_Edit['Form'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" />
    
    <div class="form-title">Name</div>
      <input type="text" name="Name" value="<?php echo htmlentities($row_Class_Edit['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" />
    
    <div class="form-title">Capacity</div>
      <input type="text" name="Capacity" value="<?php echo htmlentities($row_Class_Edit['Capacity'], ENT_COMPAT, 'utf-8'); ?>" size="32"  class="form-field"/>
   
    <div class="submit-container">
      <input type="submit" value="Update record" class="submit-button" />
    </div>
  
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Class_Id" value="<?php echo $row_Class_Edit['Class_Id']; ?>" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($Class_Edit);
?>
