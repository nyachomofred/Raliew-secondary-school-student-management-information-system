<!DOCTYPE html>
<html>
<?php
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
//get the staff ID from the URL
 $inactive_staffID=$_GET['Staff_Id'];
 
 //disable autocommit
 mysqli_autocommit($conn,false);
 
 //retrieve data from archive table and insert it into add teacher table
 $sql1="INSERT INTO add_teacher
SELECT * FROM archived_teachers
WHERE archived_teachers.Staff_Id='".$inactive_staffID."'";
mysqli_query($conn,$sql1);

$sql2="DELETE FROM archived_teachers WHERE archived_teachers.Staff_Id='".$inactive_staffID."'";
mysqli_query($conn,$sql2);

//commit the transaction
mysqli_commit($conn);
?>

<script type="text/javascript">
alert('Teacher Is Activated Successfully');
window.location.assign('View_Teachers.php');
</script>
<?php
 
 ?>
</body>
</html>