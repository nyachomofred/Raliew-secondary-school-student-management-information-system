<?php require_once('../../../Connections/sms.php'); require_once('Admin_dash.php');?>
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
  $updateSQL = sprintf("UPDATE add_role SET Role_Name=%s WHERE Role_Id=%s",
                       GetSQLValueString($_POST['Role_Name'], "text"),
                       GetSQLValueString($_POST['Role_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "List_Roles.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsEdit_Role = "-1";
if (isset($_GET['Role_Id'])) {
  $colname_rsEdit_Role = $_GET['Role_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rsEdit_Role = sprintf("SELECT * FROM add_role WHERE Role_Id = %s", GetSQLValueString($colname_rsEdit_Role, "int"));
$rsEdit_Role = mysql_query($query_rsEdit_Role, $sms) or die(mysql_error());
$row_rsEdit_Role = mysql_fetch_assoc($rsEdit_Role);
$totalRows_rsEdit_Role = mysql_num_rows($rsEdit_Role);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Edit Role</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
<div class="form-title"><h2>Update Role Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Role_Id:</td>
      <td><?php echo $row_rsEdit_Role['Role_Id']; ?></td>
    </tr>
    </table>
    
    <div class="form-title">Role Name</div>
      <input type="text" name="Role_Name" value="<?php echo htmlentities($row_rsEdit_Role['Role_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" />

      <div class="submit-container">
      <input type="submit" value="Update record" class="submit-button" />
      </div>

  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Role_Id" value="<?php echo $row_rsEdit_Role['Role_Id']; ?>" />
</form>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsEdit_Role);
?>
