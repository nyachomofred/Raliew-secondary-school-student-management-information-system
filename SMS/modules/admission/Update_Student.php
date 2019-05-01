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
  $updateSQL = sprintf("UPDATE add_student SET First_Name=%s, Middle_Name=%s, Last_Name=%s, DOB=%s, Gender=%s, Postal_Address=%s, Postal_Code=%s, Town=%s, `Form`=%s, Stream=%s, House=%s WHERE Admission_No=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Middle_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['DOB'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['Postal_Address'], "int"),
                       GetSQLValueString($_POST['Postal_Code'], "int"),
                       GetSQLValueString($_POST['Town'], "text"),
                       GetSQLValueString($_POST['Form'], "text"),
                       GetSQLValueString($_POST['Stream'], "text"),
                       GetSQLValueString($_POST['House'], "text"),
                       GetSQLValueString($_POST['Admission_No'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "List_All_Student.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Update_Student = "-1";
if (isset($_GET['Admission_No'])) {
  $colname_Update_Student = $_GET['Admission_No'];
}
mysql_select_db($database_sms, $sms);
$query_Update_Student = sprintf("SELECT * FROM add_student WHERE Admission_No = %s", GetSQLValueString($colname_Update_Student, "int"));
$Update_Student = mysql_query($query_Update_Student, $sms) or die(mysql_error());
$row_Update_Student = mysql_fetch_assoc($Update_Student);
$totalRows_Update_Student = mysql_num_rows($Update_Student);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Update Student</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
<div class="form-title"><h2>Update Student Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Admission_No:
      <?php echo $row_Update_Student['Admission_No']; ?>
      </td>
    </tr>
    </table>
      <div class="form-title">First Name</div>
      <input type="text" name="First_Name" value="<?php echo htmlentities($row_Update_Student['First_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field"/>
    
    
      <div class="form-title">Middle Name</div>
      <input type="text" name="Middle_Name" value="<?php echo htmlentities($row_Update_Student['Middle_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field" />
      
      <div class="form-title">Last Name</div>
      <input type="text" name="Last_Name" value="<?php echo htmlentities($row_Update_Student['Last_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field" />
    
      <div class="form-title">Date of Birth</div>
      <input type="date" name="DOB" value="<?php echo htmlentities($row_Update_Student['DOB'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
    
      <div class="form-title">Gender</div>
      <input type="text" name="Gender" value="<?php echo htmlentities($row_Update_Student['Gender'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
    
      <div class="form-title">Postal Address</div>
      <input type="text" name="Postal_Address" value="<?php echo htmlentities($row_Update_Student['Postal_Address'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required  class="form-field"/>
    
      <div class="form-title">Postal Code</div>
      <input type="text" name="Postal_Code" value="<?php echo htmlentities($row_Update_Student['Postal_Code'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field" />
    
      <div class="form-title">Town</div>
      <input type="text" name="Town" value="<?php echo htmlentities($row_Update_Student['Town'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field"/>
    
      <div class="form-title">Form</div>
      <input type="text" name="Form" value="<?php echo htmlentities($row_Update_Student['Form'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field" />
    
      <div class="form-title">Stream</div>
      <input type="text" name="Stream" value="<?php echo htmlentities($row_Update_Student['Stream'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="30" required class="form-field" />
    
    
      <div class="form-title">House</div>
      <input type="text" name="House" value="<?php echo htmlentities($row_Update_Student['House'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
    
      <div class="submit-container">
      <input type="submit" value="Update record" class="submit-button" />
      </div>
    
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Admission_No" value="<?php echo $row_Update_Student['Admission_No']; ?>" />
</form>
<p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($Update_Student);
?>
