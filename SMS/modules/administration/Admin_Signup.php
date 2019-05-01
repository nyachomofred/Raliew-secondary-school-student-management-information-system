
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>FDM | Sign Up</title>
        <link rel="stylesheet" href="../../styles/form_template.css">
        <script src="../../js/jquery-1.11.3.min.js"></script>
        <script src="../../js/wwb11.min.js"></script>
        
    </head>
    <body>
        
        <?php
       
        if(isset($_POST['btnSignUp'])){
            $fname=  escape(strtoupper($_POST['fname']));
            $lname=  escape(strtoupper($_POST['lname']));
            $email=  escape(strtolower($_POST['email']));
            $username=  escape($_POST['username']);
            $creatpasswd=  escape($_POST['Create_Passwd']);
            $confirm_passwd=  escape($_POST['Confirm_Passwd']);
            
            //check if the two password match
                if (!(($creatpasswd)==($confirm_passwd))){
                    echo 'Password do match';
                }  else if(!(strlen($creatpasswd)>=6)){
                    echo 'Password must be atleast six characters';
                } 
                
                //update the admin details
                else {
                    
        $query="UPDATE `sms`.`admin_details` SET `First_Name` = ?, "
                . "`Last_Name` = ?, `Email` = ?, "
                . "`Username` = ?, `Password` = ?,"
                . " `Status` = 1 "
                . "WHERE `admin_details`.`ID` = 1 ";
        $sql= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($sql,'sssss', $fn,$ln,$email_add,$user,$pass);
        $fn=$fname;
        $ln=$lname;
        $email_add=$email;
        $user=$username;
        $pass=  md5($creatpasswd);
        
        if(mysqli_stmt_execute($sql)){
        echo 'Account Created successfully';
        ?>
        <script type="text/javascript">
        window.location.assign('/../../SMS/index.php');
        </script>
        <?php
                }
				
				
				else{
                    echo 'erro'.  mysqli_error($conn);
                }
        }
        
                }
            
        ?>

                <form name="admin_signup" method="post" action="" id="Form1" class="form-container">
                <div class="form-title"><h2>Admin Registration Form</h2></div>
                
                <div class="form-title">First Name</div>
                <input type="text" id="Editbox1" name="fname" value="" maxlength="25" required="" class="form-field">
                
                <div class="form-title">Last Name</div>
                <input type="text" id="Editbox2" name="lname" value="" maxlength="25" required="" class="form-field">
                
                 <div class="form-title">Email</div>
                <input type="email" id="Editbox3" name="email" value="" maxlength="30" required="" class="form-field">
                
                 <div class="form-title">Username</div>
                <input type="text" id="Editbox4" name="username" value="" maxlength="30" required="" class="form-field">
                
                 <div class="form-title">Create Password</div>
                <input type="password" id="Editbox5" onclick="ShowObject('', 1);return false;" name="Create_Passwd" value="" maxlength="32" required="" class="form-field">
                
                 <div class="form-title">Confirm Password</div>
                <input type="password" id="Editbox6" name="Confirm_Passwd" value="" maxlength="32" required="" class="form-field">
                	
                <div class="submit-container">
                <input type="submit" id="Button1" name="btnSignUp" value="Submit" class="submit-button">
                </div>
                
</form>

    </body>
</html>
