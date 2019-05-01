
<?php 
//let's start the session
session_start();
 require dirname(__FILE__).'/../../config/dbConnect.php';
 require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';
    
 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Guardian Details</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
<script type="text/javascript">
function allnumeric(a){
	var numbers=/^[0-9]+$/;
	if(a.value.match(numbers)){
    return true;}else{
	alert('Please input numeric chars only');
	return false;
	
	}
	
	}
	
</script>
</head>

<body>
<?php
if(isset($_POST['btnStudent_Bio'])){
	 $_SESSION['student_form']=$_POST['cmb_Form'];
	 $_SESSION['student_stream']=$_POST['cmb_stream'];
	 $_SESSION['student_house']=$_POST['cmb_House'];
	 $_SESSION['student_fname']=escape(strtoupper($_POST['txtFname']));
	 $_SESSION['student_mname']=escape(strtoupper($_POST['txtMname']));
	 $_SESSION['student_lname']=escape(strtoupper($_POST['txtLname']));
	 $_SESSION['student_lname']=escape(strtoupper($_POST['txtLname']));
	 $_SESSION['student_dob']=$_POST['dob'];
	 $_SESSION['student_gender']=$_POST['cmbGender'];
	 $_SESSION['student_postaladd']=$_POST['txtPostal_Add'];
	 $_SESSION['student_postal_code']=$_POST['txtPostal_Code'];
	 $_SESSION['student_town']=escape(strtoupper($_POST['txtTown']));
	 
	 
}
 
 if(isset($_POST['btnAdd_Student'])){
	 $gurdian_id=$_POST['txtID'];
	 $gurdian_fname=escape(strtoupper($_POST['txtGurd_Fname']));
	 $gurdian_Lname=escape(strtoupper($_POST['txtGurd_Lname']));
	 $gurdian_Gender=$_POST['cmbGurd_Gender'];
	 $gurdian_Mobile=$_POST['txtPhome'];
	 $gurdian_Email=escape(strtolower($_POST['txtEmail']));
	 
	 mysqli_autocommit($conn,false);
	 $sql="SELECT Id_No FROM `add_gurdian` WHERE Id_No='".$gurdian_id."'";
	 $query_run=mysqli_query($conn,$sql);
	 $rows=mysqli_num_rows($query_run);
	 if($rows==0){
		 //add parent
		 $sql_guardian="INSERT INTO `sms`.`add_gurdian` 
		  (`Id_No`, `First_Name`, `Last_Name`, `Gender`, `Phone_Number`, `Email`)
		   VALUES (?,?,?,?,?,?)";
		   $sql_add_guardian=mysqli_prepare($conn,$sql_guardian);
		   mysqli_stmt_bind_param($sql_add_guardian,'isssss',$gurdId,$gurdFname,$gurdLname,$gurdGender,$gurdPhone,$gurdEmail);
		   
		   $gurdId=$gurdian_id;
		   $gurdFname=$gurdian_fname;
		   $gurdLname=$gurdian_Lname;
		   $gurdGender=$gurdian_Gender;
		   $gurdPhone=$gurdian_Mobile;
		   $gurdEmail=$gurdian_Email;
		   
		   
		   //check if query execute then add student
		   if(mysqli_stmt_execute($sql_add_guardian)){
			   	$sql_Student="INSERT INTO `sms`.`add_student` (`First_Name`, `Middle_Name`, `Last_Name`, `DOB`, `Gender`, `Postal_Address`, `Postal_Code`, `Town`, `Form`, `Stream`, `House`, `Parent_ID`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	  $sql_add_student=mysqli_prepare($conn,$sql_Student);
	  mysqli_stmt_bind_param($sql_add_student,'ssssssisissi',$stdntfname,$stdntmname,$stdntlname,$stdntdob,$stdntgender,$stdntpostal_add,$stdntpostal_code, $stdnttown,$stdntfrm,$stdntstream,$stdnthouse,$parentid);
	  
	  $stdntfname=$_SESSION['student_fname'];
	  $stdntmname=$_SESSION['student_mname'];
	  $stdntlname=$_SESSION['student_lname'];
	  $stdntdob=$_SESSION['student_dob'];
	  $stdntgender=$_SESSION['student_gender'];
	  $stdntpostal_add=$_SESSION['student_postaladd'];
	  $stdntpostal_code=$_SESSION['student_postal_code'];
	  $stdnttown=$_SESSION['student_town'];
	  $stdntfrm=$_SESSION['student_form'];
	  $stdntstream=$_SESSION['student_stream'];
	  $stdnthouse=$_SESSION['student_house'];
	  $parentid=$gurdian_id;
	  
	 	
	  if(mysqli_stmt_execute($sql_add_student)){
		  //open a new fincial transaction for that student in the student acc details
		  $sqlAdmission_No="SELECT add_student.Admission_No FROM add_student 
		  WHERE add_student.First_Name='".$stdntfname."' AND add_student.Middle_Name='".$stdntmname."' AND add_student.Parent_ID='".$parentid."'";
		  
		 $result=mysqli_query($conn,$sqlAdmission_No);
		 while($rowAdNO=mysqli_fetch_assoc($result)){
			 $admNo=$rowAdNO['Admission_No'];
			 }//end of while loop
			 $sqlOpenFinacialRes="INSERT INTO `sms`.`tblstudent_acc` (`Admission_No`) VALUES ('".$admNo."')";
		 
		   //prepare the statement for insert
		   if(mysqli_query($conn,$sqlOpenFinacialRes)){
			   mysqli_commit($conn);
			   
		 ?>
         <script type="text/javascript">
         var AdmNo="<?php echo $admNo?>";
		 alert('Saved Successfully...Admission No is :'+AdmNo);
		 window.location.assign("List_All_Student.php");
         </script>
         <?php  
		 		
			   session_destroy();
			   
		   		}//end of insert statement
				
				else{
					echo mysqli_error($conn);
					}//end of else block
		  }//end of finacial record entry
			   
			   }
		   
	 } else{
				   
				   //add the student only since the parent already exists
				   $sql_Student="INSERT INTO `sms`.`add_student` (`First_Name`, `Middle_Name`, `Last_Name`, `DOB`, `Gender`, `Postal_Address`, `Postal_Code`, `Town`, `Form`, `Stream`, `House`, `Parent_ID`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	  $sql_add_student=mysqli_prepare($conn,$sql_Student);
	  mysqli_stmt_bind_param($sql_add_student,'ssssssisissi',$stdntfname,$stdntmname,$stdntlname,$stdntdob,$stdntgender,$stdntpostal_add,$stdntpostal_code, $stdnttown,$stdntfrm,$stdntstream,$stdnthouse,$parentid);
	  $stdntfname=$_SESSION['student_fname'];
	  $stdntmname=$_SESSION['student_mname'];
	  $stdntlname=$_SESSION['student_lname'];
	  $stdntdob=$_SESSION['student_dob'];
	  $stdntgender=$_SESSION['student_gender'];
	  $stdntpostal_add=$_SESSION['student_postaladd'];
	  $stdntpostal_code=$_SESSION['student_postal_code'];
	  $stdnttown=$_SESSION['student_town'];
	  $stdntfrm=$_SESSION['student_form'];
	  $stdntstream=$_SESSION['student_stream'];
	  $stdnthouse=$_SESSION['student_house'];
	  $parentid=$gurdian_id;
	  
	if(mysqli_stmt_execute($sql_add_student)){
		  //open a new fincial transaction for that student in the student acc details
		  $sqlAdmission_No="SELECT add_student.Admission_No FROM add_student 
		  WHERE add_student.First_Name='".$stdntfname."' AND add_student.Middle_Name='".$stdntmname."' AND add_student.Parent_ID='".$parentid."'";
		  
		 $result=mysqli_query($conn,$sqlAdmission_No);
		 while($rowAdNO=mysqli_fetch_assoc($result)){
			 $admNo=$rowAdNO['Admission_No'];
			 }//end of while loop
			 $sqlOpenFinacialRes="INSERT INTO `sms`.`tblstudent_acc` (`Admission_No`) VALUES ('".$admNo."')";
		 
		   //prepare the statement for insert
		   if(mysqli_query($conn,$sqlOpenFinacialRes)){
			   mysqli_commit($conn);
			   
		 ?>
         <script type="text/javascript">
         var AdmNo="<?php echo $admNo?>";
		 alert('Savd Successfully...Admission No is :'+AdmNo);
		 window.location.assign("List_All_Student.php");
         </script>
         <?php  
		 		
			   session_destroy();
			   
		   		}//end of insert statement
				
				else{
					echo mysqli_error($conn);
					}//end of else block
		  }//end of finacial record entry
			   
			   }
			   
		  }
				 
				   
	 
	 
	 
?>

<div class="content">
<form name="frm_Finish_" method="post" action="" id="Form1" class="form-container">
<div class="form-title"><h2>Please Fill Gurdian Details</h2></div>

<div class="form-title">National ID</div>
<input type="number" id="txtID" name="txtID" value="" maxlength="10" required class="form-field" onblur="allnumeric(txtID)">

<div class="form-title">First Name</div>
<input type="text" id="Editbox2"  name="txtGurd_Fname" value="" maxlength="30" required class="form-field">

<div class="form-title">Last Name</div>
<input type="text" id="Editbox3"  name="txtGurd_Lname" value="" maxlength="30" required class="form-field">

<div class="form-title">Gender</div>
<select name="cmbGurd_Gender" size="1" id="Combobox1"  required class="form-field">
<option selected>[Please Select]</option>
<option value="Male">Male</option>
<option value="Female">Female</option>
</select>
<div class="form-title">Phone No</div>
<input type="tel" id="Editbox4"  name="txtPhome" value="" maxlength="10" required class="form-field">

<div class="form-title">Email</div>
<input type="email" id="Editbox5"  name="txtEmail" value="" maxlength="30" class="form-field">

<div class="submit-container">
<input type="submit" id="Button1" name="btnAdd_Student" value="Finish and Save" class="submit-button">
</div>
</form>
</div>
</body>
</html>