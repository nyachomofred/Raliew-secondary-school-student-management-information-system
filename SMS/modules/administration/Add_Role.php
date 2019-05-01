<!DOCTYPE html>
<html>
<?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require_once('Admin_dash.php');
    ?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Add Role</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<?php
        // put your code here
        if(isset($_POST['btnAdd_Role'])){
            $RoleName=  escape(strtoupper($_POST['txtRoleName']));
            
            //query
            $sql="INSERT INTO `sms`.`add_role` (`Role_Id`, `Role_Name`) VALUES (NULL, ?)";
            $pstm=  mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($pstm, 's', $name);
            $name=$RoleName;
            
            if(mysqli_stmt_execute($pstm)){
                echo "<script>alert('Role added successfully')</script>";
				?>
                <script type="text/javascript">
                window.location.assign("List_Roles.php");
                </script>
                <?php
                
            }  else {
                echo mysqli_error($conn);
            }
            
            
        }
        
        ?>
<body>
<?php


?>
<div class="content">
<form id="form1" name="form1" method="post" action="" class="form-container">
<div class="form-title"><h2>Role Registration Form</h2></div>

      <div class="form-title">Role Name</div>
    <input type="text" name="txtRoleName" id="txtRoleName" required class="form-field" />
    
    <div class="submit-container">
      <input type="submit" name="btnAdd_Role" id="btnAdd_Role" value="Add Role" class="submit-button" />
      <input type="reset" name="btnCancel" id="btnCancel" value="Cancel" class="submit-button" />
      </div>
</form>
</div>
</body>
</html>