<!DOCTYPE html>
<html>
<?php
    
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>

<head>
<link rel="stylesheet" href="../../styles/form_template.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Add Teacher</title>
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
if(isset($_POST['btnSubmit'])){
	$txtID=$_POST['txtStaff_Id'];
	$txtFname=escape(strtoupper($_POST['txtFname']));
	$txtLname=escape(strtoupper($_POST['txtLnam']));
	$cmbGender=escape($_POST['cmbGender']);
	$txtDOB=escape($_POST['txtDOB']);
	$txtPhone=escape($_POST['txtPnone']);
	$txtEmail=escape(strtolower($_POST['txtEmail']));
	$cmbSubj1=escape($_POST['cmbSubjects']);
	$cmbSubj2=escape($_POST['cmdSubject2']);
	
	$sql_addTeacher="INSERT INTO `sms`.`add_teacher` 
	(`Staff_Id`, `First_Name`, `Last_Name`, `Gender`, `DOB`, `Phone_No`, `Email`, `Subjects`) 
	VALUES (?,?,?,?,?,?,?,?)";
	//prepare the sql
	$sql_prepare=mysqli_prepare($conn,$sql_addTeacher);
	
	//bind the parameters to field elements
	mysqli_stmt_bind_param($sql_prepare,'isssssss',$id,$fname,$lname,$gen,$dob,$pno,$email,$sub);
	
	//assign parameters values
	$id=$txtID;
	$fname=$txtFname;
	$lname=$txtLname;
	$gen=$cmbGender;
	$dob=$txtDOB;
	$pno=$txtPhone;
	$email=$txtEmail;
	$sub=$cmbSubj1.' / '.$cmbSubj2;
	
	//execute the statement
	if(mysqli_execute($sql_prepare)){
		
		$sqlAddSubjects="INSERT INTO `sms`.`teacher_subject` (`Teacher_Id`, `Subject_One`, `Subject_two`)
		 VALUES ('".$txtID."', '".$cmbSubj1."', '".$cmbSubj2."')";
		 $queryRun=mysqli_query($conn,$sqlAddSubjects);
		
		?>
        <script type="text/javascript">
        alert('Teacher added Successfully');
		window.location.assign("View_Teachers.php");
        </script>
        <?php
		}else{
			echo mysqli_error();
			}
	
	
	}
?>




<div class="content">

<form method="post" action="" class="form-container">
  
    <div class="form-title"><h2>Teacher Registration Form</h2></div>
      <div class="form-title">Staff ID</div>
    
    <input type="number" name="txtStaff_Id" id="txtStaff_Id" required maxlength="15" class="form-field" onblur="allnumeric(txtStaff_Id)"/>
  
  
    
      <div class="form-title">First Name</div>
    
    <input type="text" name="txtFname" id="txtFname" required maxlength="30" class="form-field" />
  
  
    
      <div class="form-title">Last Name</div>
    
    <input type="text" name="txtLnam" id="txtLnam" required maxlength="30" class="form-field"/>
  
  
    <div class="form-title">Gender</div>
    <select name="cmbGender" id="cmbGender" required class="form-field">
    <option value="0">[Select Gender]</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    </select>
  
  
    
      <div class="form-title">Date of Birth</div>
    
    <input type="date" name="txtDOB" id="txtDOB" required maxlength="30" class="form-field"/>
  
  
    
      <div class="form-title">Phone Number</div>
    
    <input type="tel" name="txtPnone" id="txtPnone" required maxlength="15" class="form-field"/>
  
  
    
      <div class="form-title">Email</div>
    
    <input type="email" name="txtEmail" id="txtEmail" required maxlength="30" class="form-field"/>
  
  
    
      <div class="form-title">Subject Combination</div>
    
    <select name="cmbSubjects" id="cmbSubjects" required class="form-field">
    <?php 
	$sql_subject1="SELECT DISTINCT Name,Subject_Id FROM `add_subject` ORDER BY Subject_Id";
	$result=mysqli_query($conn,$sql_subject1);
	?>
    <option>[Subject One]</option>
    <?php
	while($rows=mysqli_fetch_assoc($result)){
		
		?>
        
        <option value="<?php echo $rows['Subject_Id']?>"><?php echo $rows['Name']?></option>
        <?php
		
		}
	?>
    
    </select>&nbsp;&nbsp;
    
    
      <select name="cmdSubject2" id="cmdSubject2" required class="form-field">
          <?php 
	$sql_subject2="SELECT DISTINCT Name,Subject_Id FROM `add_subject` ORDER BY Subject_Id";
	$result2=mysqli_query($conn,$sql_subject2);
	?>
    <option>[Subject Two]</option>
    <?php
	while($rows=mysqli_fetch_assoc($result2)){
		
		?>
        
        <option value="<?php echo $rows['Subject_Id']?>"><?php echo $rows['Name']?></option>
        <?php
		
		}
	?>
      </select>
    
    <div class="submit-container">
      <input type="submit" class="submit-button" name="btnSubmit" id="btnSubmit" value="Add Teacher" />
      <input type="reset" class="submit-button" name="btnCancel" id="btnCancel" value="Cancel"  onClick="window.location.assign('../administration/Admin_Dashboard.php')"/>
    </div>
  
  </form>
</div>
</body>
</html>