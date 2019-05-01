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
  $updateSQL = sprintf("UPDATE add_teacher SET First_Name=%s, Last_Name=%s, Gender=%s, DOB=%s, Phone_No=%s, Email=%s,Subjects=%s WHERE Staff_Id=%s",
                       GetSQLValueString($_POST['First_Name'], "text"),
                       GetSQLValueString($_POST['Last_Name'], "text"),
                       GetSQLValueString($_POST['Gender'], "text"),
                       GetSQLValueString($_POST['DOB'], "text"),
                       GetSQLValueString($_POST['Phone_No'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Subjects'], "text"),
                       GetSQLValueString($_POST['Staff_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "View_Teachers.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsUpdateTeacher = "-1";
if (isset($_GET['Staff_Id'])) {
  $colname_rsUpdateTeacher = $_GET['Staff_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rsUpdateTeacher = sprintf("SELECT Staff_Id, First_Name, Last_Name, Gender, DOB, Phone_No, Email, Subjects FROM add_teacher WHERE Staff_Id = %s", GetSQLValueString($colname_rsUpdateTeacher, "int"));
$rsUpdateTeacher = mysql_query($query_rsUpdateTeacher, $sms) or die(mysql_error());
$row_rsUpdateTeacher = mysql_fetch_assoc($rsUpdateTeacher);
$totalRows_rsUpdateTeacher = mysql_num_rows($rsUpdateTeacher);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Update Teacher</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Staff_Id:</td>
      <td><?php echo $row_rsUpdateTeacher['Staff_Id']; ?></td>
    </tr>
    </table>
    
      <div class="form-title">First Name</div>
      <input type="text" name="First_Name" value="<?php echo htmlentities($row_rsUpdateTeacher['First_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
    
    
    <div class="form-title">Last Name</div>
      <input type="text" name="Last_Name" value="<?php echo htmlentities($row_rsUpdateTeacher['Last_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" />
   
    
    <div class="form-title">Gender</div>
      <td><input type="text" name="Gender" value="<?php echo htmlentities($row_rsUpdateTeacher['Gender'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" /></td>
    </tr>
    
    <div class="form-title">Date of Birth</div>
      <td><input type="text" name="DOB" value="<?php echo htmlentities($row_rsUpdateTeacher['DOB'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field" /></td>
    </tr>
    
    <div class="form-title">Phone Number</div>
      <td><input type="text" name="Phone_No" value="<?php echo htmlentities($row_rsUpdateTeacher['Phone_No'], ENT_COMPAT, 'utf-8'); ?>" size="32"  required class="form-field"/></td>
    </tr>
    
    <div class="form-title">Email</div>
      <td><input type="text" name="Email" value="<?php echo htmlentities($row_rsUpdateTeacher['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32"  class="form-field" /></td>
    
    <div class="form-title">Subject Combination</div>
      <td><input type="text" name="Subjects" value="<?php echo htmlentities($row_rsUpdateTeacher['Subjects'], ENT_COMPAT, 'utf-8'); ?>" size="32"  required class="form-field"/></td>
    </tr>
    

      <td><input type="submit" value="Update record" class="submit-button" /></td>
    <div class="submit-container">
    
  <input type="hidden" name="MM_update" value="form1" />
  </div>
  <input type="hidden" name="Staff_Id" value="<?php echo $row_rsUpdateTeacher['Staff_Id']; ?>" />
</form>

</body>
</html>
<?php
mysql_free_result($rsUpdateTeacher);
?>
