<?php require_once('../../../Connections/sms.php'); 
require dirname(__FILE__).'/../administration/Admin_dash.php';
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
  $updateSQL = sprintf("UPDATE add_staff SET First_Name=%s, Last_Name=%s, Gender=%s, DOB=%s, Phone_No=%s, Email=%s, `Role`=%s WHERE Staff_Id=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['DOB'], "text"),
                       GetSQLValueString($_POST['Phone_No'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Role'], "text"),
                       GetSQLValueString($_POST['Staff_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "List_Staff.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsUpdate_Staff = "-1";
if (isset($_GET['Staff_Id'])) {
  $colname_rsUpdate_Staff = $_GET['Staff_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rsUpdate_Staff = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, `Role` FROM add_staff WHERE Staff_Id = %s", GetSQLValueString($colname_rsUpdate_Staff, "int"));
$rsUpdate_Staff = mysql_query($query_rsUpdate_Staff, $sms) or die(mysql_error());
$row_rsUpdate_Staff = mysql_fetch_assoc($rsUpdate_Staff);
$totalRows_rsUpdate_Staff = mysql_num_rows($rsUpdate_Staff);$colname_rsUpdate_Staff = "-1";
if (isset($_GET['Staff_Id'])) {
  $colname_rsUpdate_Staff = $_GET['Staff_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rsUpdate_Staff = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, `Role` FROM add_staff WHERE Staff_Id = %s", GetSQLValueString($colname_rsUpdate_Staff, "int"));
$rsUpdate_Staff = mysql_query($query_rsUpdate_Staff, $sms) or die(mysql_error());
$row_rsUpdate_Staff = mysql_fetch_assoc($rsUpdate_Staff);
$totalRows_rsUpdate_Staff = mysql_num_rows($rsUpdate_Staff);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Edit Staff</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
<div class="form-title"><h2>Update Staff Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Staff_Id:</td>
      <td><?php echo $row_rsUpdate_Staff['Staff_Id']; ?></td>
    </tr>
    </table>
    
      <div class="form-title">First Name</div>
        <input type="text" name="First_Name" value="<?php echo htmlentities($row_rsUpdate_Staff['First_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
       <div class="form-title">Last Name</div> 
      <input type="text" name="Last_Name" value="<?php echo htmlentities($row_rsUpdate_Staff['Last_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
 
<div class="form-title">Gender</div>
      <input type="text" name="Gender" value="<?php echo htmlentities($row_rsUpdate_Staff['Gender'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
    
      <div class="form-title">Date of Birth</div>
      <input type="date" name="DOB" value="<?php echo htmlentities($row_rsUpdate_Staff['DOB'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
    
      <div class="form-title">Phone No</div>
      <input type="text" name="Phone_No" value="<?php echo htmlentities($row_rsUpdate_Staff['Phone_No'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
    
      <div class="form-title">Email</div>
     <input type="text" name="Email" value="<?php echo htmlentities($row_rsUpdate_Staff['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
   

      <div class="form-title">Role</div>
      <input type="text" name="Role" value="<?php echo htmlentities($row_rsUpdate_Staff['Role'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
   
     <div class="submit-container"> 
     <input type="submit" value="Update record" class="submit-button" />
</div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Staff_Id" value="<?php echo $row_rsUpdate_Staff['Staff_Id']; ?>" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($rsUpdate_Staff);
?>
