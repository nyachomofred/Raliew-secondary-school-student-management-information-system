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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE add_house SET House_Name=%s, Bed_Capacity=%s WHERE House_ID=%s",
                       GetSQLValueString($_POST['House_Name'], "text"),
                       GetSQLValueString($_POST['Bed_Capacity'], "int"),
                       GetSQLValueString($_POST['House_ID'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "View_House.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsEditHouse = "-1";
if (isset($_GET['House_ID'])) {
  $colname_rsEditHouse = $_GET['House_ID'];
}
mysql_select_db($database_sms, $sms);
$query_rsEditHouse = sprintf("SELECT * FROM add_house WHERE House_ID = %s", GetSQLValueString($colname_rsEditHouse, "int"));
$rsEditHouse = mysql_query($query_rsEditHouse, $sms) or die(mysql_error());
$row_rsEditHouse = mysql_fetch_assoc($rsEditHouse);
$totalRows_rsEditHouse = mysql_num_rows($rsEditHouse);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
<div class="form-title"><h2>Update House Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">House ID:</td>
      <td><?php echo $row_rsEditHouse['House_ID']; ?></td>
    </tr>
    </table>
    <div class="form-title">House Name</div>
     <input type="text" name="House_Name" value="<?php echo htmlentities($row_rsEditHouse['House_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" />
    
    <div class="form-title">Bed Capacity</div>
      <input type="text" name="Bed_Capacity" value="<?php echo htmlentities($row_rsEditHouse['Bed_Capacity'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" />

     <div class="submit-container">
     <input type="submit" value="Update record" class="submit-button"/>
     </div>

  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="House_ID" value="<?php echo $row_rsEditHouse['House_ID']; ?>" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($rsEditHouse);
?>
