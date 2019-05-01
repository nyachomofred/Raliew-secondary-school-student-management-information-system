

<?php
    
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Add Subject</title>
<link rel="stylesheet" href="../../styles/form_template.css">
</head>

<body>
<?php 
if(isset($_POST['btnAdd_Subject'])){
	//assign variables to fields
	$txtSubject_ID=$_POST['txtSubj_Id'];
	$txtSubjectName=escape(strtoupper($_POST['txtSubject_Name']));
	$txtSubject_ShortName=escape(strtoupper($_POST['txtShort_Name']));
	
	//prepare sql to insert them
	$sql_addsubject="INSERT INTO `sms`.`add_subject` (`Subject_Id`, `Name`, `Short_Name`) 
	VALUES (?,?,?)";
	$pstm=mysqli_prepare($conn,$sql_addsubject);
	
	//bind parameters
	mysqli_stmt_bind_param($pstm,'iss',$sub_id,$sub_name,$sub_shrt_name);
	$sub_id=$txtSubject_ID;
	$sub_name=$txtSubjectName;
	$sub_shrt_name=$txtSubject_ShortName;
	
	//execute the statement
	if(mysqli_stmt_execute($pstm)){
		echo 'subject added successfully';
		?>
        <script type="text/javascript">
        window.location.assign("View_Subjects.php");
        </script>
        <?php
		}
	}

?>

<form name="frmAdd_Subject" method="post" action="Add_Subject.php" class="form-container">
<div class="form-title"><h2>Subject Registration Form</h2></div>
  
    
      <div class="form-title">Subject ID</div>
    <input type="text" name="txtSubj_Id" id="txtSubj_Id" / maxlength="15" required class="form-field" patter="/d">
  
  
    
      <div class="form-title">Subject Name</div>
    <input type="text" name="txtSubject_Name" id="txtSubject_Name" / maxlength="30" required class="form-field">
  
      <div class="form-title">Subject Short Name</div>
    <input type="text" name="txtShort_Name" id="txtShort_Name"  required class="form-field"/>
  
  
    
    
    <div class="submit-container">
      <input type="submit" name="btnAdd_Subject" id="btnAdd_Subject" value="Submit" class="submit-button"/>
      <input type="reset" name="btnCancel" id="btnCancel" value="Cancel" onClick="window.location.assign('Admin_Dashboard.php')" class="submit-button"/>
      </div>
  </form>

</body>
</html>