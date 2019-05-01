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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE add_gurdian SET First_Name=%s, Last_Name=%s, Gender=%s, Phone_Number=%s, Email=%s WHERE Id_No=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['Phone_Number'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Id_No'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "../administration/Admin_Dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsUpdate_Parent = "-1";
if (isset($_POST['txtSearch_Parent'])) {
  $colname_rsUpdate_Parent = $_POST['txtSearch_Parent'];
}
mysql_select_db($database_sms, $sms);
$query_rsUpdate_Parent = sprintf("SELECT * FROM add_gurdian WHERE Id_No = %s", GetSQLValueString($colname_rsUpdate_Parent, "int"));
$rsUpdate_Parent = mysql_query($query_rsUpdate_Parent, $sms) or die(mysql_error());
$row_rsUpdate_Parent = mysql_fetch_assoc($rsUpdate_Parent);
$totalRows_rsUpdate_Parent = mysql_num_rows($rsUpdate_Parent);
?>
<!DOCTYPE html>
<html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Update Parent</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>

<body>
<div class="content">
<form id="form1" name="form1" method="post" action="Update_Parent.php" class="form-container">
<div class="form-title"><h2>Update Gurdian Details</h2></div>
<table width="500" cellpadding="5">
  <tr>
    <td>
      <label for="txtSearch_Parent">Search Parent</label>
    </td>
    <td><input type="text" name="txtSearch_Parent" placeholder="Enter ID Number" id="txtSearch_Parent" />&nbsp;&nbsp;
      <input type="submit" name="btnSearch" id="btnSearch" value="Go" />
</td>
  </tr>
</table>
</form
>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2" class="form-container">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ID Number:</td>
      <td><?php echo $row_rsUpdate_Parent['Id_No']; ?></td>
    </tr>
    </table>
    
    
    <div class="form-title">First Name</div>
     <input type="text" name="First_Name" value="<?php echo htmlentities($row_rsUpdate_Parent['First_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
 
    
    <div class="form-title">Last Name</div>
      <input type="text" name="Last_Name" value="<?php echo htmlentities($row_rsUpdate_Parent['Last_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
  
    
    <div class="form-title">Gender</div>
      <input type="text" name="Gender" value="<?php echo htmlentities($row_rsUpdate_Parent['Gender'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
  
    
    <div class="form-title">Phone Number</div>
      <input type="text" name="Phone_Number" value="<?php echo htmlentities($row_rsUpdate_Parent['Phone_Number'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
   
    
    <div class="form-title">Email</div>
     <input type="email" name="Email" value="<?php echo htmlentities($row_rsUpdate_Parent['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
   
    
  <div class="submit-container">
      <input type="submit" value="Update record"  class="submit-button"/>
  </div>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="Id_No" value="<?php echo $row_rsUpdate_Parent['Id_No']; ?>" />
</form>
<p>&nbsp;</p>
</div>
>
</body>
</html>
<?php
mysql_free_result($rsUpdate_Parent);
?>
