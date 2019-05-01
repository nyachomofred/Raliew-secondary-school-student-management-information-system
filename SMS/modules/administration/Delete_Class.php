<?php require_once('../../../Connections/sms.php'); ?>
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

if ((isset($_GET['Class_Id'])) && ($_GET['Class_Id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM add_class WHERE Class_Id=%s",
                       GetSQLValueString($_GET['Class_Id'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($deleteSQL, $sms) or die(mysql_error());

  $deleteGoTo = "Class_View.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_rs_delete = "-1";
if (isset($_GET['Class_Id'])) {
  $colname_rs_delete = $_GET['Class_Id'];
}
mysql_select_db($database_sms, $sms);
$query_rs_delete = sprintf("SELECT * FROM add_class WHERE Class_Id = %s", GetSQLValueString($colname_rs_delete, "int"));
$rs_delete = mysql_query($query_rs_delete, $sms) or die(mysql_error());
$row_rs_delete = mysql_fetch_assoc($rs_delete);
$totalRows_rs_delete = mysql_num_rows($rs_delete);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Delete Class</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($rs_delete);
?>
