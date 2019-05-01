
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
<title>FDM | Add Staff</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
<!--Include JQuery File-->
<script type="text/javascript" language="Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script src="../../js/jquery-1.11.3.min.js" type="text/javascript"></script>

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
	$txtRole=escape(strtoupper($_POST['txtRole']));
	
	$sql_addTeacher="INSERT INTO `sms`.`add_staff` 
	(`Staff_Id`, `First_Name`, `Last_Name`, `Gender`, `DOB`, `Phone_No`, `Email`, `Role`) 
	VALUES (?,?,?,?,?,?,?,?)";
	//prepare the sql
	$sql_prepare=mysqli_prepare($conn,$sql_addTeacher);
	
	//bind the parameters to field elements
	mysqli_stmt_bind_param($sql_prepare,'isssssss',$id,$fname,$lname,$gen,$dob,$pno,$email,$role);
	
	//assign parameters values
	$id=$txtID;
	$fname=$txtFname;
	$lname=$txtLname;
	$gen=$cmbGender;
	$dob=$txtDOB;
	$pno=$txtPhone;
	$email=$txtEmail;
	$role=$txtRole;
	
	//execute the statement
	if(mysqli_execute($sql_prepare)){
		echo "<script>alert('Staff Added Successfully')</script>";
		?>
        <script type="text/javascript">
        window.location.assign("List_Staff.php");
        </script>
        <?php
		}else{
			echo mysqli_error();
			}
	
	
	}
?>


<div class="content">
<form method="post" action="" class="form-container" id="frmAddStaff" name="frmAddStaff">
<div class="form-title"><h2>Staff Registration Form</h2></div>
  
      <div class="form-title">Staff ID</div>
   
   <input type="number" class="form-field" name="txtStaff_Id" id="txtStaff_Id" required  maxlength="10" onBlur='allnumeric(txtStaff_Id)'/><br />

      <div class="form-title">First Name</div>
   
   <input type="text" class="form-field" name="txtFname" id="txtFname" required maxlength="30" /><br />

      <div class="form-title">Last Name</div>
<input type="text" class="form-field" name="txtLnam" id="txtLnam" required maxlength="30"/><br />

    <div class="form-title">Gender</div>
    <select class="form-field" name="cmbGender" id="cmbGender" required>
    <option>[Select Gender]</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    </select><br />

      <div class="form-title">Date of Birth</div>
    
   <input type="date" class="form-field" name="txtDOB" id="txtDOB" required maxlength="30"/><br />

      <div class="form-title">Phone No</div>
   
    <input type="tel" class="form-field" name="txtPnone" id="txtPnone" required maxlength="15"/><br />

      <div class="form-title">Email</div>
    
    <input type="email" class="form-field" name="txtEmail" id="txtEmail" required maxlength="30"/><br />

    <div class="form-title">Role</div>
   
      <label for="cmdSubject2"></label>
      <select class="form-field" name="txtRole" id="txtRole" required>
      <option value="">Please Select</option>
      <?php
	  $sqlRole="SELECT DISTINCT Role_Name FROM add_role ORDER BY Role_Id";
	  $result=mysqli_query($conn,$sqlRole);
	  while($row=mysqli_fetch_assoc($result)){
		  $roleName=$row['Role_Name'];
		  
		  ?>
          <option><?php echo $roleName?></option>
          <?php
		  }
	  ?>
      
      
      
      </select>
      
      <br />
      <div class="submit-container">
      <input type="submit" class="submit-button" name="btnSubmit" id="btnSubmit" value="Add Staff"  />
      <input type="reset" class="submit-button" name="btnCancel" id="btnCancel" value="Cancel"  onClick="window.location.assign('../administration/Admin_Dashboard.php')"/>
</div>
  </form>
</div>
</body>
</html>
