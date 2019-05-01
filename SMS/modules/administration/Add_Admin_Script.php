<?php
        session_start();
        require dirname(__FILE__).'/../../config/dbConnect.php';
        require dirname(__FILE__).'/../../config/security.php';
        
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
        $query="INSERT INTO `sms`.`admin_details` (`ID`, `First_Name`, `Last_Name`, `Email`, `Username`, `Password`, `Status`) VALUES (NULL,?,?,?,?,?,1)";
        $sql= mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($sql,'sssss', $fn,$ln,$email_add,$user,$pass);
        $fn=$fname;
        $ln=$lname;
        $email_add=$email;
        $user=$username;
        $pass=  md5($creatpasswd);
        
        if(mysqli_stmt_execute($sql)){
        echo 'admin added successfully';
        header('Refresh: 5;url=Admin_Login.php');
                }else{
                    echo 'erro'.  mysqli_error($conn);
                }
        }
        
                }

