<!DOCTYPE html>
<html>

<?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Revoke Teacher Role</title>
</head>

<body>
<?php
$Staff_Id=$_GET['Staff_Id'];
$Role_Name=$_GET['Role_Name'];

//get role id

$sql_getrole_id="SELECT add_role.Role_Id FROM add_role WHERE add_role.Role_Name='".$Role_Name."'";
$result=mysqli_query($conn,$sql_getrole_id);
while($row=mysqli_fetch_assoc($result)){
	$role_id=$row['Role_Id'];
	 $role_id;
	}
	//revoke role by deleting it
$sql_revoke_role="DELETE FROM teacher_role WHERE teacher_role.Staff_Id='".$Staff_Id."' AND teacher_role.Role_ID='".$role_id."'";
if(mysqli_query($conn,$sql_revoke_role)){
	echo 'Role Has Been Revoked Successfully';
	header('Refresh:1;url=view_teacher_roles.php');
	}

?>
</body>
</html>