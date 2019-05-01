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

if ((isset($_GET['Admission_No'])) && ($_GET['Admission_No'] != "")) {
  $deleteSQL = sprintf("DELETE FROM add_student WHERE Admission_No=%s",
                       GetSQLValueString($_GET['Admission_No'], "text"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($deleteSQL, $sms) or die(mysql_error());

  $deleteGoTo = "List_All_Student.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Delete_Student = "-1";
if (isset($_GET['Admission_No'])) {
  $colname_Delete_Student = $_GET['Admission_No'];
}
mysql_select_db($database_sms, $sms);
$query_Delete_Student = sprintf("SELECT * FROM add_student WHERE Admission_No = %s", GetSQLValueString($colname_Delete_Student, "int"));
$Delete_Student = mysql_query($query_Delete_Student, $sms) or die(mysql_error());
$row_Delete_Student = mysql_fetch_assoc($Delete_Student);
$totalRows_Delete_Student = mysql_num_rows($Delete_Student);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Delete Student</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($Delete_Student);
?>
