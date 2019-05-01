<?php require_once('../../../../Connections/sms.php'); 
require dirname(__FILE__).'/accountant_dash.php';?>
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
  $updateSQL = sprintf("UPDATE tbl_expense_payment SET Expense_Type=%s, Expense_Amount=%s, Expense_Date=%s, Specfic_Description=%s, Approved_By=%s WHERE Expense_ID=%s",
                       GetSQLValueString($_POST['Expense_Type'], "text"),
                       GetSQLValueString($_POST['Expense_Amount'], "double"),
                       GetSQLValueString($_POST['Expense_Date'], "date"),
                       GetSQLValueString($_POST['Specfic_Description'], "text"),
                       GetSQLValueString($_POST['Approved_By'], "text"),
                       GetSQLValueString($_POST['Expense_ID'], "int"));

  mysql_select_db($database_sms, $sms);
  $Result1 = mysql_query($updateSQL, $sms) or die(mysql_error());

  $updateGoTo = "View_Expeses.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsUpdate_Expese = "-1";
if (isset($_GET['Expense_ID'])) {
  $colname_rsUpdate_Expese = $_GET['Expense_ID'];
}
mysql_select_db($database_sms, $sms);
$query_rsUpdate_Expese = sprintf("SELECT * FROM tbl_expense_payment WHERE Expense_ID = %s", GetSQLValueString($colname_rsUpdate_Expese, "int"));
$rsUpdate_Expese = mysql_query($query_rsUpdate_Expese, $sms) or die(mysql_error());
$row_rsUpdate_Expese = mysql_fetch_assoc($rsUpdate_Expese);
$totalRows_rsUpdate_Expese = mysql_num_rows($rsUpdate_Expese);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM</title>
<link rel="stylesheet" href="../../../styles/form_template.css" />
</head>

<body>
<div class="content">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1"  class="form-container">
<div class="form-title"><h2>Update Payment Details</h2></div>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Expense_ID:</td>
      <td><?php echo $row_rsUpdate_Expese['Expense_ID']; ?></td>
    </tr>
    </table>
    
  <div class="form-title">Expense Type</div>
 <input type="text" name="Expense_Type" value="<?php echo htmlentities($row_rsUpdate_Expese['Expense_Type'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field"/>
  
  <div class="form-title">Expense Amount</div>
<input type="text" name="Expense_Amount" value="<?php echo htmlentities($row_rsUpdate_Expese['Expense_Amount'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-field" min="0" />

  <div class="form-title">Expense Date</div>
<input type="text" class="form-field" readonly="readonly" name="Expense_Date" value="<?php echo htmlentities($row_rsUpdate_Expese['Expense_Date'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
 
  <div class="form-title">Specific description</div>
<textarea cols="24" rows="5" class="form-field" name="Specfic_Description" id="Specfic_Description"><?php echo htmlentities($row_rsUpdate_Expese['Specfic_Description'], ENT_COMPAT, 'utf-8'); ?></textarea>
   
    <div class="form-title">Approved By</div>
<input type="text" class="form-field" readonly="readonly" name="Approved_By" value="<?php echo htmlentities($row_rsUpdate_Expese['Approved_By'], ENT_COMPAT, 'utf-8'); ?>" size="32" />

 <div class="submit-container">

    <input type="submit" value="Update record" class="submit-button" />
    </div>
 
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="Expense_ID" value="<?php echo $row_rsUpdate_Expese['Expense_ID']; ?>" />
</form>
<p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($rsUpdate_Expese);
?>
