<!DOCTYPE html>
<html>
<?php
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FMD | Reactivate Staff"</title>
</head>

<body>
<?php 
//get the staff ID from the URL
 $inactive_staffID=$_GET['Staff_Id'];
 
 //disable autocommit
 mysqli_autocommit($conn,false);
 
 //retrieve data from archive table and insert it into add teacher table
 $sql1="INSERT INTO add_staff
SELECT * FROM archived_staff
WHERE archived_staff.Staff_Id='".$inactive_staffID."'";
mysqli_query($conn,$sql1);

$sql2="DELETE FROM archived_staff WHERE archived_staff.Staff_Id='".$inactive_staffID."'";
mysqli_query($conn,$sql2);

//commit the transaction
mysqli_commit($conn);
?>

<script type="text/javascript">
alert('Staff Is Activated Successfully');
window.location.assign('List_Staff.php');
</script>
<?php
 
 ?>
</body>
</html>