<!DOCTYPE html>
<html>
<?php
    
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require_once('Admin_dash.php');
    ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Assign Role</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>


<?php 
$staff_id=$_GET['Staff_Id'];
$sql_roles="SELECT * FROM `add_role`";
$result=mysqli_query($conn,$sql_roles);
?>
<div class="content">
<form id="form1" name="form1" method="post" action="" class="form-container">
	<div class="form-title"><h2>Assign Role</h2></div>
    
   <div class="form-title">Role</div> 
<select required name="cmbRole" class="form-field">
    <option value="0" selected="selected">Please select</option>
<?php
while($row=mysqli_fetch_assoc($result)){
	?>
    <option value="<?php echo $row['Role_Id']?>"><?php echo $row['Role_Name']?></option>
    <?php
	
	}
?>
</select>
<div class="submit-container">
<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="submit-button" />
</div>
</form>
</div>
<?php
if(isset($_POST['btnSubmit'])){
	$role=$_POST['cmbRole'];
	$sql_assign_role="INSERT INTO `sms`.`teacher_role` (`Staff_Id`, `Role_ID`)
	 VALUES (?,?)";
	 $pstm=mysqli_prepare($conn,$sql_assign_role);
	 mysqli_stmt_bind_param($pstm,'ii',$staffID,$roleID);
	 $staffID=$staff_id;
	 $roleID=$role;
	 if(mysqli_stmt_execute($pstm)){
		 echo 'Role Assigned Successfully';
		 }else{
			 echo mysqli_error($conn);
			 }
	 
	 
	}
?>
</body>
</html>