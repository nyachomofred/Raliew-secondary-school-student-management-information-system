<!DOCTYPE html>
<html>
<?php
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Reactivate Student</title>
</head>

<body>
<?php
//disable autocommit
mysqli_autocommit($conn,false);
//retrive the student admission from url
$admission_No=$_GET['Admission_No'];

//retrive the parent id
$sql_parentId="SELECT archived_students.Parent_ID FROM archived_students WHERE archived_students.Admission_No='".$admission_No."'";
$result=mysqli_query($conn,$sql_parentId);

while($row=mysqli_fetch_assoc($result)){
	//retrieve the parent Id
	$parentID=$row['Parent_ID'];
	}
	
	//check if the parent exist in the add students table
	$sql_check_parent="SELECT add_student.Parent_ID from add_student WHERE add_student.Parent_ID='".$parentID."'";
	$result_parent=mysqli_query($conn,$sql_check_parent);
	//check the number of rows retruned
	$num_rows=mysqli_num_rows($result_parent);
	if($num_rows>=1){
		//insert the student 
		$sql_inser_student="INSERT INTO add_student SELECT * FROM archived_students WHERE archived_students.Admission_No='".$admission_No."'";
		mysqli_query($conn,$sql_inser_student);
		
		//delete the student from archives
			$sql_delete_student="DELETE FROM archived_students WHERE archived_students.Admission_No='".$admission_No."'";
			mysqli_query($conn,$sql_delete_student);
			
			
			//check if the number of instances of students represneted by the same parent in the archived students
			$sql_gurd_archived="SELECT archived_students.Parent_ID FROM archived_students WHERE archived_students.Parent_ID='".$parentID."'";
		   $result=mysqli_query($conn,$sql_gurd_archived);
		
		//check the number of students returned
		$num_of_rows=mysqli_num_rows($result);
		if($num_of_rows==0){
			//delete the parent from the archive
			$sql_delete_gurdian="DELETE FROM archived_gurdians WHERE archived_gurdians.Id_No='".$parentID."'";
			mysqli_query($conn,$sql_delete_gurdian);
			mysqli_commit($conn);
			?>
            <script type="text/javascript">
            alert('Student has benn reactivated successfully');
			window.location.assign("List_Archived_Students.php");
            </script>
            <?php
			
			}else{
				mysqli_commit($conn);
				?>
            <script type="text/javascript">
            alert('Student has benn reactivated successfully');
			window.location.assign("List_Archived_Students.php");
            </script>
            <?php
				}
	}else{
		//insert the parent
		$sql_inser_gurd="INSERT INTO add_gurdian SELECT * FROM archived_gurdians WHERE archived_gurdians.Id_No='".$parentID."'";
		mysqli_query($conn,$sql_inser_gurd);
		
		//insert the student
		$sql_inser_student="INSERT INTO add_student SELECT * FROM archived_students WHERE archived_students.Admission_No='".$admission_No."'";
		mysqli_query($conn,$sql_inser_student);
		
		//delete student
		$sql_delete_student="DELETE FROM archived_students WHERE archived_students.Admission_No='".$admission_No."'";
			mysqli_query($conn,$sql_delete_student);
			
			//check if the number of instances of students represneted by the same parent in the archived students
			$sql_gurd_archived="SELECT archived_students.Parent_ID FROM archived_students WHERE archived_students.Parent_ID='".$parentID."'";
		   $result=mysqli_query($conn,$sql_gurd_archived);
		
		//check the number of students returned
		$num_of_rows=mysqli_num_rows($result);
		if($num_of_rows==0){
			//delete the parent from the archive
			$sql_delete_gurdian="DELETE FROM archived_gurdians WHERE archived_gurdians.Id_No='".$parentID."'";
			mysqli_query($conn,$sql_delete_gurdian);
			mysqli_commit($conn);
			?>
            <script type="text/javascript">
            alert('Student has benn reactivated successfully');
			window.location.assign("List_Archived_Students.php");
            </script>
            <?php
			
			}else{
				mysqli_commit($conn);
				?>
            <script type="text/javascript">
            alert('Student has been reactivated successfully');
			window.location.assign("List_Archived_Students.php");
            </script>
            <?php
				}
		}
?>
</body>
</html>