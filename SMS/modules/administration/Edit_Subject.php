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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE add_subject SET Name=%s, Short_Name=%s WHERE Subject_Id=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Short_Name'], "text"),
                       GetSQLValueString($_POST['Subject_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "View_Subjects.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsEditsubject = "-1";
if (isset($_GET['Subject_Id'])) {
  $colname_rsEditsubject = $_GET['Subject_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rsEditsubject = sprintf("SELECT * FROM add_subject WHERE Subject_Id = %s", GetSQLValueString($colname_rsEditsubject, "int"));
$rsEditsubject = mysql_query($query_rsEditsubject, $sms) or die(mysql_error());
$row_rsEditsubject = mysql_fetch_assoc($rsEditsubject);
$totalRows_rsEditsubject = mysql_num_rows($rsEditsubject);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="form-container">
<div class="form-title"><h2>Update Subject Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Subject Id:</td>
      <td><?php echo $row_rsEditsubject['Subject_Id']; ?></td>
      </tr>
      </table>
      
     
    <div class="form-title">Subject Name</div>
    <input type="text" name="Name" value="<?php echo htmlentities($row_rsEditsubject['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
  
    <div class="form-title">Short Name</div>
      <input type="text" name="Short_Name" value="<?php echo htmlentities($row_rsEditsubject['Short_Name'], ENT_COMPAT, 'utf-8'); ?>" size="32" required class="form-field"/>
      
   <div class="submit-container">
    <input type="submit" value="Update record" required class="submit-button" />
      </div>
    
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Subject_Id" value="<?php echo $row_rsEditsubject['Subject_Id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsEditsubject);
?>
