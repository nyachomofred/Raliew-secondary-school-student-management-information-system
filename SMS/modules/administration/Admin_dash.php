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

mysql_select_db($database_sms, $sms);
$query_rsGetSchoolName = "SELECT name FROM school_details";
$rsGetSchoolName = mysql_query($query_rsGetSchoolName, $sms) or die(mysql_error());
$row_rsGetSchoolName = mysql_fetch_assoc($rsGetSchoolName);
$totalRows_rsGetSchoolName = mysql_num_rows($rsGetSchoolName);
?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Dashboard</title>
<link rel="stylesheet" href="../../styles/Admin_dash.css" />
</head>

<body>

<div id="header">
  <div class="logo"><a href="/SMS/SMS/modules/administration/Admin_dash.php">FDM <span>School Managers&reg;</span></a>
  <span style="margin-left:350px; color:#fff"><a href="/SMS/SMS/modules/administration/View_School.php"><?php echo $row_rsGetSchoolName['name']; ?></a></span>
  </div> <!--end of logo div-->
  <div class="dropdown">
  <div id="menu" class="menuLink">Profile
      <div class="dropdown-content">
       <ul>
       <li>
       <a href="#">Profile</a>
       </li>
       <li>
       <a href="#">Account</a>
       </li>
       <li>
       <a href="/SMS/index.php">Log Out</a>
       </li>
      </ul>
      </div><!--end of dropdown-content div-->
  </div><!--end of menu div-->
</div><!--end of drp down div-->
</div><!--*end of header div*-->
<div id="container">
	<div class="sidebar">
    
    <h2>School Administration</h2>
    	<ul>
        <li><a href="/SMS/SMS/modules/administration/Class_View.php">Class Management</a></li>
        <li><a href="/SMS/SMS/modules/administration/View_House.php">House Management</a></li>
        <li><a href="/SMS/SMS/modules/administration/View_Subjects.php">Subject Management</a></li>
        <li><a href="/SMS/SMS/modules/administration/List_Roles.php">Role Management</a></li>
        <li><a href="/SMS/SMS/modules/administration/Update_Parent.php">Edit Parent</a></li>
        </ul>
        
    <h2>Admissions</h2>
    <ul>
        <li><a href="/SMS/SMS/modules/admission/List_All_Student.php">Students</a></li>
        <li><a href="/SMS/SMS/modules/admission/List_Staff.php">Non Teaching Staff</a></li>
        <li><a href="/SMS/SMS/modules/admission/View_Teachers.php">Teaching Staff</a></li>
        </ul>
    <h2>Finance</h2>
    <ul>
        <li><a href="/SMS/SMS/modules/finance/Debit_StudentAcc.php">Debit Accounts</a></li>
        <li><a href="/SMS/SMS/modules/finance/PayFee.php">Fee Payment</a></li>
        <li><a href="/SMS/SMS/modules/finance/View_Payment_Details.php">Fee Records</a></li>
         <li><a href="/SMS/SMS/modules/finance/View_Payment_Transactions.php">Correct Transaction</a></li>  
         <li><a href="/SMS/SMS/modules/finance/View_Expeses.php">Manage Expenses</a></li>  
        <li><a href="/SMS/SMS/modules/finance/Trial_Balance.php">Balance sheet</a></li>
        </ul>
     <h2>Academics</h2> 
     <ul>
        <li><a href="/SMS/SMS/modules/Academic/View_Exam_Type.php">Marks Allocation</a></li>
   
        <li><a href="/SMS/SMS/modules/Academic/Marks_Sheet.php">Marks Entry</a></li>
        <li><a href="/SMS/SMS/modules/Academic/View_Marks_Sheet.php">View Marks</a></li>
        
        <li><a href="/SMS/SMS/modules/Academic/Edit_Student_Marks.php">Edit Marks</a></li>
        <li><a href="/SMS/SMS/modules/Academic/Generate_Results.php">Generate Results</a></li>
        </ul>
     
    <h2>Attendance</h2>
    <ul>
        <li><a href="#">Student Attendance</a></li>
        <li><a href="#">Staff Attendance</a></li>
        </ul>
    
    <h2>Communication</h2>
    <ul>
    	<li><a href="/SMS/SMS/modules/communication/Teachers_Contact_List.php">Teachers Contacts </a> </li>
        <li><a href="/SMS/SMS/modules/communication/Parent_contact_list.php">Parent Contacts</a></li>
        <li><a href="/SMS/SMS/modules/communication/NonTeachingStaffContactList.php">Staff Contacts</a></li>
        <li><a href="http://sms.elimu.co.ke" target="_blank">Send Bulk SMS</a></li>
        </ul>
    <h2>Archives</h2>
    <ul>
        <li><a href="/SMS/SMS/modules/admission/View_Archived_Teachers.php">Teachers</a></li>
        <li><a href="/SMS/SMS/modules/admission/List_Archived_Students.php">Students</a></li>
        <li><a href="/SMS/SMS/modules/admission/List_Archived_Staff.php">Staffs</a></li>
    </ul>
    
    
    </div><!--End of sidebar div-->
    <!--<div class="content">
    SOME CONTENT HERE
    </div>end of content div-->

</div><!--End of container div-->


</body>
</html>
<?php
mysql_free_result($rsGetSchoolName);
?>
