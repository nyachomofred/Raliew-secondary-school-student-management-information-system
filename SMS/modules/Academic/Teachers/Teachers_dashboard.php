<?php require_once('../../../../../Connections/sms.php'); ?>
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
<link rel="stylesheet" href="../../../styles/teacher_dash.css" />
</head>

<body>

<div id="header">
  <div class="logo"><a href="/SMS/SMS/modules/Academic/Teachers/Teachers_dashboard.php">FDM <span>School Managers&reg;</span></a>
  <span style="margin-left:350px; color:#fff"><a href="/SMS/SMS/modules/Academic/Teachers/Teachers_dashboard.php"><?php echo $row_rsGetSchoolName['name']; ?></a></span>
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
       <a href="#">Log Out</a>
       </li>
      </ul>
      </div><!--end of dropdown-content div-->
  </div><!--end of menu div-->
</div><!--end of drp down div-->
</div><!--*end of header div*-->
<div id="container">
	<div class="sidebar">
    
   
     <h2>Academics</h2> 
     <ul>
        <li><a href="/SMS/SMS/modules/Academic/Teachers/Marks_Sheet.php">Marks Entry</a></li>
        <li><a href="/SMS/SMS/modules/Academic/Teachers/View_Marks_Sheet.php">View Marks</a></li>
        
        <li><a href="/SMS/SMS/modules/Academic/Teachers/Edit_Student_Marks.php">Edit Marks</a></li>
        <li><a href="/SMS/SMS/modules/Academic/Teachers/Generate_Results.php">Generate Results</a></li>
        </ul>
     
    <h2>Attendance</h2>
    <ul>
        <li><a href="#">Student Attendance</a></li>
       
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
