<!DOCTYPE html>
<html>
<?php
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Archive Staff</title>
</head>
<body>
<?php 
//diable autocommit
mysqli_autocommit($conn,false);
//get staff id from the url
$staff_id=$_GET['Staff_Id'];

//select the details of the staff and insert into the archives table
$sql1="INSERT INTO archived_staff
SELECT * FROM add_staff WHERE Staff_Id='".$staff_id."'";
mysqli_query($conn,$sql1);
$sql2="DELETE FROM add_staff WHERE Staff_Id='".$staff_id."'";
mysqli_query($conn,$sql2);

//commit the archivation
mysqli_commit($conn);

?>

<script type="text/javascript">
alert('Staff Is Archived Successfully');
window.location.assign('List_Archived_Staff.php');
</script>
<?php


?>
</body>
</html>