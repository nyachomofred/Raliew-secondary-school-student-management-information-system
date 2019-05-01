<?php session_start();
if(isset($_GET['logout'])){
	//unset session
	session_unset();
	session_destroy();
	echo 'redirecting...please wait...';
	header('refresh:3;url=Admin_Login.php');
	}
	

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Admin Dashboard</title>
<style type="text/css">
a{
	text-decoration:none;
	color:blue;
	}
ul{
	list-style:none;
	}
	#logout{
		float:right;
		padding:2px;
		margin:2px;
		color:blue;
		
		}
</style>
</head>

<body>
<div class="logout" id="logout"><a href="Admin_Dashboard.php?logout=1">Logout</a></div>
<?php if(isset($_SESSION['username'])){
	?>
<p>Welcome <?php echo '<strong>'.$_SESSION['username'].'</strong>' ?>  to Admin Dashboard.</p>
    <?php
	}
	else{
		echo 'You have been logged out';
		die();
		}
	?>

<p>Administration</p>
<p>Add</p>
<ul>
  <li><a href="Add_Class.php">Class</a></li>
  <li><a href="Add_House.php">House</a></li>
  <li><a href="Add_Subject.php">Subject</a></li>
  <li><a href="Add_Role.php">Role</a></li>
</ul>
<p>View </p>
<ul>
  <li><a href="Class_View.php">Class</a></li>
  <li><a href="View_House.php">House</a></li>
  <li><a href="View_Subjects.php">Subjects</a></li>
  <li><a href="List_Roles.php">Roles</a></li>
  <li><a href="view_teacher_roles.php">Teacher Roles</a></li>
</ul>
<p><a href="Update_Parent.php">Edit Gurdian</a></p>
<ul>
  <li></li>
  <li></li>
</ul>
<p>Admission</p>
<p>Add </p>
<ul>
  <li><a href="../admission/Add_Student.php">Student</a></li>
  <li><a href="../admission/add_teacher.php">Teacher</a></li>
  <li><a href="../admission/Add_Staff.php">Non-Teaching Staff</a></li>
</ul>
<p>View</p>
<ul>
  <li><a href="../admission/List_All_Student.php">Current Students</a></li>
  <li><a href="../admission/View_Teachers.php">Current Teachers</a></li>
  <li><a href="../admission/List_Staff.php">Current Non Teaching Staff</a></li>
  <li><a href="../admission/List_Archived_Students.php">Archived Students</a></li>
  <li><a href="../admission/View_Archived_Teachers.php">Archived Teachers</a></li>
  <li><a href="../admission/List_Archived_Staff.php">Archived Non-Teaching Staff</a></li>
</ul>
<p>Finance</p>
<ul>
  <li><a href="#">Add Record</a></li>
  <li><a href="#">Edit</a></li>
  <li><a href="#">Report</a></li>
</ul>
<p>Examination</p>
<ul>
  <li><a href="#">New Exam</a></li>
  <li><a href="#">Mark Entry</a></li>
  <li><a href="#">Reports</a></li>
</ul>
<p>Attendance</p>
<ul>
  <li><a href="#">Student Attendace</a></li>
  <li><a href="#">Staff Attendace</a></li>
</ul>
<p>Communication</p>
<ul>
  <li><a href="#">Bulk SMS</a></li>
  <li><a href="#">Bulk Email</a></li>
  <li></li>
</ul>
</body>
</html>