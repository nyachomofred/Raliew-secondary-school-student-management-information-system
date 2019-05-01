
<?php session_start();?>
    <?php

//require dirname(__FILE__).'/../../config/dbConnect.php';
require_once('SMS/config/dbConnect.php');
require_once('SMS/config/security.php');

?>
<?php
  
        if(isset($_POST['login'])){
            $username=  escape($_POST['username']);
            $password=  escape(md5($_POST['password']));   
        
       //select login details
        $sql="SELECT CONCAT(First_Name,'  ',Last_Name)AS Full_Name,Username,Password,Status FROM admin_details WHERE Binary Username=Binary '".$username."' AND Binary Password=Binary '".$password."'";
        
        //execute the query
        $query_run=  mysqli_query($conn, $sql);
        
        //check if the num of rows is equal to one
        $num_rows=  mysqli_num_rows($query_run);
		
        if($num_rows==1){
            
			while($row=mysqli_fetch_assoc($query_run)){
				$status=$row['Status'];
				$username=strtolower($row['Full_Name']);
				if($status==0){
					header('Refresh:2;url=SMS/modules/administration/Admin_Signup.php');
					
					}//end of status equal to 1
					else if($status==1){
						$_SESSION['username']=$username;
						
						//check if the school had been set
						$sqlSchool="SELECT code FROM `school_details` ";
						$sqlRunSchl=mysqli_query($conn,$sqlSchool);
						$numRowsSchl=mysqli_num_rows($sqlRunSchl);
						
						if($numRowsSchl==1){
							$_SESSION['user']=$username;
						header('Refresh:2;url=SMS/modules/administration/Admin_dash.php');
						
					        }else if($numRowsSchl==0){
								header('Refresh:2;url=SMS/modules/administration/Add_School.php');
								}
						}//end of status not equal to one
				
				}//end of while lopp
			
			
			
        }//end of if num rows equal to one
		
		else if($num_rows==0){
			//check the user in the teachers table
			$sqlTeacher="SELECT Email,Password,Status,Access_Level FROM add_teacher WHERE Binary Email='".$username."' AND  Binary Password='".$password."'";
			$queryRun=mysqli_query($conn,$sqlTeacher);
			$rowTeachers=mysqli_num_rows($queryRun);
			if($rowTeachers==1){
				//check if the teacher had  changed passwd
				while($row=mysqli_fetch_assoc($queryRun)){
					$StatusTeacher=$row['Status'];
					$Email=$row['Email'];
					$Access_Level=$row['Access_Level'];
					}//end of while loop to get status
					if($StatusTeacher==0){
						$_SESSION['Email']=$Email;
						//redirect the teacher to change passwd page
						
						?>
                        <script type="text/javascript">
                        window.location.assign("SMS/modules/administration/Change_Teacher_Passwd.php");
                        </script>
                        <?php
						}//end of if teacher has not chenaged passwd
						else if($StatusTeacher==1){
							
							?>
                        <script type="text/javascript">
                        window.location.assign("SMS/modules/Academic/Teachers/Teachers_dashboard.php");
                        </script>
                        <?php
							}//end of if pass is already changed
				
				?>
               <!-- <script type="text/javascript">
                window.location.assign("SMS/modules/administration/Admin_dash.php");
                </script>-->
                <?php
				}//end of row
				else if($rowTeachers==0){
					$sqlBurser="SELECT Email,Password,Status,Access_Level FROM add_staff 
					WHERE Binary Email='".$username."' AND  Binary Password='".$password."' AND Access_Level=3";
					
					$result=mysqli_query($conn,$sqlBurser);
					$num_rows_burser=mysqli_num_rows($result);
					if($num_rows_burser==1){
						while($row_burser=mysqli_fetch_assoc($result)){
							$StatusBurse=$row_burser['Status'];
							$Email=$row_burser['Email'];
						
							}//end of while loop
							if($StatusBurse==0){
								$_SESSION['Email']=$Email;
								//redirect to change burser pass
								?>
                                <script type="text/javascript">
                                window.location.assign("SMS/modules/administration/Change_Password_Burser.php");
                                </script>
                                <?php
								
								}//end of redirect burser to change passwd
								else if($StatusBurse==1){
									//redirect to dashboard
								?>
                                <script type="text/javascript">
                                window.location.assign("SMS/modules/finance/accounts/accountant_dash.php");
                                </script>
                                <?php
									}//end of if status is one
						
						}//end of if details are correct
						
						else if($num_rows_burser==0){
							echo "<script>alert('Invalid credentials...')</script>";
							}	
					
					}//end of if the user is not a teacher
			
			}//end of if the user is not admin...
	  
		}//end of if is set log
        ?>
<!DOCTYPE html>


<html>
    <head>
        <meta charset="UTF-8">
        <title>FDM | Admin_Login</title>
        <link href="../../styles/admin_login.css" rel="stylesheet">
        <link rel="stylesheet" href="../../Styles/normalize.css">
        
        <style>

      @import url(http://fonts.googleapis.com/css?family=Open+Sans);
.btn { display: inline-block; *display: inline; *zoom: 1; padding: 4px 10px 4px; margin-bottom: 0; font-size: 13px; line-height: 18px; color: #333333; text-align: center;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; background-color: #f5f5f5; background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#ffffff, endColorstr=#e6e6e6, GradientType=0); border-color: #e6e6e6 #e6e6e6 #e6e6e6; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); border: 1px solid #e6e6e6; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer; *margin-left: .3em; }
.btn:hover, .btn:active, .btn.active, .btn.disabled, .btn[disabled] { background-color: #e6e6e6; }
.btn-large { padding: 9px 14px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
.btn:hover { color: #333333; text-decoration: none; background-color: #e6e6e6; background-position: 0 -15px; -webkit-transition: background-position 0.1s linear; -moz-transition: background-position 0.1s linear; -ms-transition: background-position 0.1s linear; -o-transition: background-position 0.1s linear; transition: background-position 0.1s linear; }
.btn-primary, .btn-primary:hover { text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); color: #ffffff; }
.btn-primary.active { color: rgba(255, 255, 255, 0.75); }
.btn-primary { background-color: #4a77d4; background-image: -moz-linear-gradient(top, #6eb6de, #4a77d4); background-image: -ms-linear-gradient(top, #6eb6de, #4a77d4); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6eb6de), to(#4a77d4)); background-image: -webkit-linear-gradient(top, #6eb6de, #4a77d4); background-image: -o-linear-gradient(top, #6eb6de, #4a77d4); background-image: linear-gradient(top, #6eb6de, #4a77d4); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#6eb6de, endColorstr=#4a77d4, GradientType=0);  border: 1px solid #3762bc; text-shadow: 1px 1px 1px rgba(0,0,0,0.4); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.5); }
.btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled] { filter: none; background-color: #4a77d4; }
.btn-block { width: 100%; display:block; }

* { -webkit-box-sizing:border-box; -moz-box-sizing:border-box; -ms-box-sizing:border-box; -o-box-sizing:border-box; box-sizing:border-box; }

html { width: 100%; height:100%; overflow:hidden; }

body { 
	width: 100%;
	height:100%;
	font-family: 'Open Sans', sans-serif;
	background: #092756;
	background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
	background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
	background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
	background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
	background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );
}
.login { 
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -150px 0 0 -150px;
	width:300px;
	height:300px;
}
.login h1 { color: #fff; text-shadow: 0 0 10px rgba(0,0,0,0.3); letter-spacing:1px; text-align:center; }

input { 
	width: 100%; 
	margin-bottom: 10px; 
	background: rgba(0,0,0,0.3);
	border: none;
	outline: none;
	padding: 10px;
	font-size: 13px;
	color: #fff;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
	border: 1px solid rgba(0,0,0,0.3);
	border-radius: 4px;
	box-shadow: inset 0 -5px 45px rgba(100,100,100,0.2), 0 1px 1px rgba(255,255,255,0.2);
	-webkit-transition: box-shadow .5s ease;
	-moz-transition: box-shadow .5s ease;
	-o-transition: box-shadow .5s ease;
	-ms-transition: box-shadow .5s ease;
	transition: box-shadow .5s ease;
}
input:focus { box-shadow: inset 0 -5px 45px rgba(100,100,100,0.4), 0 1px 1px rgba(255,255,255,0.2); }

    </style>

    
        <script src="../../js/prefixfree.min.js"></script>

    </head>
    <body>

        <div class="login">
	<h1>Login</h1>
    <form method="post">
    	<input type="text" name="username" placeholder="Username" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Let me in.</button>
    </form>
</div>
    
        <script src="../../js/index.js"></script> 
    </body>
</html>
