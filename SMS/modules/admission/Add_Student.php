<!doctype html>
<html>
<?php
    
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>
    
    

<?php 
//populate stream

$sql_stream="select DISTINCT Name from add_class WHERE Form=1";
?>


<head>
<meta charset="utf-8">
<titleFDM | Student Bio</title>
<link rel="stylesheet" href="../../styles/form_template.css" />
</head>
<body>
<div class="content">
<form action="Guardian_Details.php" method="post" name="frmStduDetails" class="form-container">
<div class="form-title"><h2>Student Registration Form</h2></div>
  
    <div class="form-title">First Name</div>
    <input type="text" name="txtFname" id="txtFname" required class="form-field">
  
  
    <div class="form-title">Middle Name</div>
    <input type="text" name="txtMname" id="txtMname" required class="form-field">
  
  
    <div class="form-title">Last Name</div>
    <input type="text" name="txtLname" id="txtLname" required class="form-field">
  
  
    <div class="form-title">Date of Birth</div>
    <input type="text" name="dob" id="dob" required class="form-field">
  
  
    <div class="form-title">Gender</div>
    <select name="cmbGender" id="cmbGender" required class="form-field">
      <option>Please Select</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  
  
    <div class="form-title">Form</div>
    <select name="cmb_Form" id="cmb_Form" required class="form-field">
      <option>Please Select</option>
      <option value="1">Form One</option>
      <option value="2">Form Two</option>
      <option value="3">Form Three</option>
      <option value="4">Form Four</option>
    </select>
  
  
    <div class="form-title">Stream</div>
    <select name="cmb_stream" id="cmb_stream" required class="form-field">
      <option>Please Select</option>
      <?php 
		//populate stream
		$sql="SELECT DISTINCT add_class.Name FROM add_class ORDER BY add_class.Name";
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$stream=$row['Name'];
			?>
            <option value="<?php echo $stream?>"><?php echo $stream?></option>
            <?php
			
			}
		?>
      
    </select>
  
  
    <div class="form-title">House</div>
    <select name="cmb_House" id="cmb_House" required class="form-field">
      <option>Please Select</option>
      <?php 
$sql="SELECT DISTINCT House_Name FROM `add_house`;";
$query_run=mysqli_query($conn,$sql);
if($query_run){

	if(mysqli_num_rows($query_run)>0){
       
	   while($optn=mysqli_fetch_assoc($query_run)){

		   ?>
           <option><?php echo $optn['House_Name'];?></option>
           <?php
		   }
		}
	}
?>
      
    </select>
  
  
    <div class="form-title">Postal Address</div>
    <input type="text" name="txtPostal_Add" id="txtPostal_Add" required class="form-field">
  
  
    <div class="form-title">Postal Code</div>
    <input type="text" name="txtPostal_Code" id="txtPostal_Code" required class="form-field">
  
  
    <div class="form-title">Town</div>
    <input type="text" name="txtTown" id="txtTown" required class="form-field">
  <div class="submit-container">
    <input type="submit" name="btnStudent_Bio" id="btnStudent_Bio" value="Next&gt;&gt;" class="submit-button">
  
</div>
</form>
</div>
</body>
</html>