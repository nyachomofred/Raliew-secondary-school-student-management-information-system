<!DOCTYPE html>
<html>
<?php
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Archive Student</title>
</head>

<body>
<?php 
$stdAdmission=$_GET['Admission_No'];

//diable autocommit
mysqli_autocommit($conn,false);

//check if the student has only one parent
$sql_std_parentID="SELECT add_student.Parent_ID FROM add_student WHERE Admission_No='".$stdAdmission."'";
//$result_parent_Id=mysqli_query($conn,$sql_std_parentID);
$result=mysqli_query($conn,$sql_std_parentID);
while($row=mysqli_fetch_assoc($result)){
	$result_parent_Id=$row['Parent_ID'];
	}

//use the parent Id to count parent ID
$sql_count_parent="SELECT add_student.Parent_ID FROM add_student WHERE add_student.Parent_ID='".$result_parent_Id."'";
$result=mysqli_query($conn,$sql_count_parent);
$count=mysqli_num_rows($result);

//check if count is two or more
if($count==1){
	//archive the parent
	
	$sql_archive_parent="INSERT INTO archived_gurdians SELECT * FROM add_gurdian WHERE add_gurdian.Id_No='".$result_parent_Id."'";
	mysqli_query($conn,$sql_archive_parent);
	
	
		
	//archive the student
	$sql_archive_student="INSERT INTO archived_students SELECT * FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_archive_student);
	$sql_delete_student="DELETE FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_delete_student);
	
	$sql_delete_parent="DELETE FROM add_gurdian WHERE add_gurdian.Id_No='".$result_parent_Id."'";
	mysqli_query($conn,$sql_delete_parent);
   ?>

<script type="text/javascript">
alert('Student Is Archived Successfully');
window.location.assign('List_Archived_Students.php');
</script>
<?php
		
}else{
	
	$sql_count_parent="SELECT archived_gurdians.Id_No FROM archived_gurdians WHERE archived_gurdians.Id_No='".$result_parent_Id."'";
$result=mysqli_query($conn,$sql_count_parent);
$count=mysqli_num_rows($result);
if($count==1){

	// archive the student but leave the parent
	$sql_archive_student="INSERT INTO archived_students SELECT * FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_archive_student);
	$sql_delete_student="DELETE FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_delete_student);
    ?>
<script type="text/javascript">
alert('Student Is Archived Successfully');
window.location.assign('List_Archived_Students.php');
</script>
<?php
		
}
else{
	
	$sql_archive_parent="INSERT INTO archived_gurdians SELECT * FROM add_gurdian WHERE add_gurdian.Id_No='".$result_parent_Id."'";
	mysqli_query($conn,$sql_archive_parent);
	//archive the student
	$sql_archive_student="INSERT INTO archived_students SELECT * FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_archive_student);
	$sql_delete_student="DELETE FROM add_student WHERE Admission_No='".$stdAdmission."'";
	mysqli_query($conn,$sql_delete_student);
	?>

<script type="text/javascript">
alert('Student Is Archived Successfully');
window.location.assign('List_Archived_Students.php');
</script>
<?php
		
	}
	}
	mysqli_commit($conn);
?>
</body>
</html>