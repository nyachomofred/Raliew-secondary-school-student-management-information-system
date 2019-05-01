<?php 
session_start();
require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../../config/dbConnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Change Password</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>

<body>
<?php 
if(isset($_POST['btnSubmit'])){
	 $Email=$_SESSION['Email'];
	 $NewPass=escape($_POST['txtNewPasswd']);
	 $ConfirmPass=escape($_POST['txtConfirmPasswd']);
	 
	 //check if passwds match
	 if($NewPass==$ConfirmPass){
		 //check the lenght
		 if(strlen($NewPass)>=6){
			 //prepare update
			 $encypetdPass=md5($NewPass);
			 
			 $sql="UPDATE add_teacher SET Password='".$encypetdPass."',Status=1 WHERE Email='".$Email."'";
			 $query=mysqli_query($conn,$sql);
			 if($query){
				   ?>
             <script type="text/javascript">
             alert('Password is changed successfully');
			 window.location.assign("../../../../SMS/");
             </script>
             <?php
				 }
			 
			 
			 }//end of pass len passed
			 else{
				  ?>
             <script type="text/javascript">
             alert('Passwords must be atleast six characters');
             </script>
             <?php
				 }//pass too short
		 
		 }//end of if pass match
		 else{
			 ?>
             <script type="text/javascript">
             alert('Passwords do not match');
             </script>
             <?php
			 }//end of if pass do not match
	
	}//end of if change button is set
?>


        <div class="content">
            <form name="frnAdd_House" method="post" action="" id="frmChangePasswd" class="form-container">
            <div class="form-title"><h2>Change Password</h2></div>
          
            
            <div class="form-title">New Password</div>
            <input type="password" id="Editbox1"  name="txtNewPasswd" required value="" maxlength="25" class="form-field">
            
            <div class="form-title">Retype Password</div>
            <input type="password" id="Editbox1"  name="txtConfirmPasswd" required value="" maxlength="25" class="form-field">
            
            <div class="submit-container">
            <input type="submit" id="Button1" name="btnSubmit" value="Change" class="submit-button">
            <input type="reset" id="Button2" name="btnCancel" value="Reset" class="submit-button">
            </div>
           
            </form>
            </div>
</body>
</html>