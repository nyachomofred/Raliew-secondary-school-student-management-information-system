<?php session_start()?>

<!DOCTYPE html>
<html>
<head>
<?php
    
    require dirname(__FILE__).'/../../../config/dbConnect.php';
    require dirname(__FILE__).'/../../../config/security.php';
	require dirname(__FILE__).'/Teachers_dashboard.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Edit Marks</title>
</head>

<body>
<div class="content">
<form action="" method="post" name="frmSearch"><table width="464" cellpadding="5">
  <tr>
    <td width="134"><label for="cmbForm">Form :</label></td>
    <td width="302"><select name="cmbForm" id="cmbForm">
      <option>Please Select</option>
      <option value="1">Form One</option>
      <option value="2">Form Two</option>
      <option value="3">Form Three</option>
      <option value="4">Form Four</option>
    </select></td>
  </tr>
  <tr>
    <td><label for="txtAdmission">Admission No :</label></td>
    <td><input type="number" name="txtAdmission" id="txtAdmission" required/></td>
  </tr>
  <tr>
    <td><label for="cmbTerm">Term  :</label></td>
    <td><select name="cmbTerm" id="cmbTerm">
      <option>Please Select</option>
      <option value="1">Term One</option>
      <option value="2">Term Two</option>
      <option value="3">Term Three</option>
    </select></td>
  </tr>
  <tr>
    <td><label for="cmbExam_Id">Exam Type :</label></td>
    <td><select name="cmbExam_Id" id="cmbExam_Id">
      <option>Please Select</option>
      <option value="1">Exam One</option>
      <option value="2">Exam Two</option>
    </select></td>
  </tr>
  <tr>
    <td><label for="cmbSubject">Subject :</label></td>
    <td><select name="cmbSubject" id="cmbSubject">
      <option>Please Select</option>
      <?php 
	  //php to populate subjects
	  $sqlSub="SELECT add_subject.Subject_Id,add_subject.Short_Name FROM add_subject ORDER BY add_subject.Subject_Id";
	  $resultSub=mysqli_query($conn,$sqlSub);
	  while($rowSub=mysqli_fetch_assoc($resultSub)){
		  $subId=$rowSub['Subject_Id'];
		  $subShrtName=$rowSub['Short_Name'];
		  ?>
          <option value="<?php echo $subId?>"><?php echo $subShrtName?></option>
          <?php
		  }
	  ?>
      
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSearch" id="btnSearch" value="Go" /></td>
  </tr>
</table>
</form>
<?php 
if(isset($_POST['btnSearch'])){
	//declare session vars
	$_SESSION['Form']=$_POST['cmbForm'];
	$_SESSION['Admission']=escape($_POST['txtAdmission']);
	$_SESSION['Term']=$_POST['cmbTerm'];
	$_SESSION['Exam']=$_POST['cmbExam_Id'];
	$_SESSION['Subject']=$_POST['cmbSubject'];
	
	//declare var to hold for session vars
	$form=$_SESSION['Form'];
	$admNo=$_SESSION['Admission'];
	$Term=$_SESSION['Term'];
	$Exam_Id=$_SESSION['Exam'];
	$Subject=$_SESSION['Subject'];
	
		//get the mark out of for each cat
	$sqlGetExamOut="SELECT Marks_Allocation FROM tblexam_types WHERE tblexam_types.Id='".$Exam_Id."'";
	$resultExamOut=mysqli_query($conn,$sqlGetExamOut);
	while($rowOut=mysqli_fetch_assoc($resultExamOut)){
		$marksOutOf=$rowOut['Marks_Allocation'];
		}
	// check the form of student
	if($form==1){
		//get name,Entry ID and score in the subject
		$sql="SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) AS Name,tblform_one_marks.`Entry_Id`,tblform_one_marks.$Subject from add_student,tblform_one_marks where add_student.`Admission_No`='".$admNo."' AND tblform_one_marks.`Admission_No`='".$admNo."' AND tblform_one_marks.`Term`='".$Term."' and tblform_one_marks.`Exam_Id`='".$Exam_Id."'";
		
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$Name=$row['Name'];
			 $EntryID=$row['Entry_Id'];
			 $Score=$row[$Subject];
			}
		
		
		}// end of if form is one
		
		else if($form==2){
		//get name,Entry ID and score in the subject
		$sql="SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) AS Name,tblform_two_marks.`Entry_Id`,tblform_two_marks.$Subject from add_student,tblform_two_marks where add_student.`Admission_No`='".$admNo."' AND tblform_two_marks.`Admission_No`='".$admNo."' AND tblform_two_marks.`Term`='".$Term."' and tblform_two_marks.`Exam_Id`='".$Exam_Id."'";
		
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$Name=$row['Name'];
			$EntryID=$row['Entry_Id'];
			$Score=$row[$Subject];
			}
		
		
		}// end of if form is two	
		
				else if($form==3){
		//get name,Entry ID and score in the subject
		$sql="SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) AS Name,tblform_three_marks.`Entry_Id`,tblform_three_marks.$Subject from add_student,tblform_three_marks where add_student.`Admission_No`='".$admNo."' AND tblform_three_marks.`Admission_No`='".$admNo."' AND tblform_three_marks.`Term`='".$Term."' and tblform_three_marks.`Exam_Id`='".$Exam_Id."'";
		
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			 $Name=$row['Name'];
			$EntryID=$row['Entry_Id'];
			$Score=$row[$Subject];
			}
		
		
		}// end of if form is three
		
						else if($form==4){
		//get name,Entry ID and score in the subject
		$sql="SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) AS Name,tblform_four_marks.`Entry_Id`,tblform_four_marks.$Subject from add_student,tblform_four_marks where add_student.`Admission_No`='".$admNo."' AND tblform_four_marks.`Admission_No`='".$admNo."' AND tblform_four_marks.`Term`='".$Term."' and tblform_four_marks.`Exam_Id`='".$Exam_Id."'";
		
		$result=mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$Name=$row['Name'];
			$EntryID=$row['Entry_Id'];
			$Score=$row[$Subject];
			}
		
		
		}// end of if form is four
		else{
			echo "<script>alert('Please select form')</script>";
			}//end form is required
	?>
    <form action="" method="post" name="frmUpdate_Marks"><table width="296" cellpadding="5">
  <tr>
    <td><input type="hidden" name="txtEntry_Id" id="txtEntry_Id" value="<?php echo $EntryID?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="119"><label for="txtName">Name :</label></td>
    <td width="226"><input type="text" name="txtName" id="txtName" value="<?php echo $Name?>" readonly="readonly" /></td>
  </tr>
  <tr>
    <td><label for="txtScore">Score :</label></td>
    <td><input type="number" name="txtScore" id="txtScore" value="<?php echo $Score?>" min="0" max="<?php echo $marksOutOf?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update" />
      <input type="reset" name="btnCancel" id="btnCancel" value="Cancel" /></td>
  </tr>
</table>
</form>
    <?php
	
	}//end of if search button is set
	
	if(isset($_POST['btnSubmit'])){
		 $Score=escape($_POST['txtScore']);
		 $Entry_ID=$_POST['txtEntry_Id'];
		  $form=$_SESSION['Form'];
		  $Subject=$_SESSION['Subject'];
		  
		  //use the form and entry id to effect updates on a given subject
		  if($form==1){
			  $sql="UPDATE `sms`.`tblform_one_marks` SET `$Subject` = '".$Score."' WHERE `tblform_one_marks`.`Entry_Id` = '".$Entry_ID."'";
			  mysqli_query($conn,$sql);
			  echo "<script>alert('Marks has been changed successfully')</script>";
			  
			  }//end of form one update
			  
			else if($form==2){
			  $sql="UPDATE `sms`.`tblform_two_marks` SET `$Subject` = '".$Score."' WHERE `tblform_two_marks`.`Entry_Id` = '".$Entry_ID."'";
			  mysqli_query($conn,$sql);
			  echo "<script>alert('Marks has been changed successfully')</script>";
			  
			  }//end of form two update
			  
			else if($form==3){
			  $sql="UPDATE `sms`.`tblform_three_marks` SET `$Subject` = '".$Score."' WHERE `tblform_three_marks`.`Entry_Id` = '".$Entry_ID."'";
			  mysqli_query($conn,$sql);
			  echo "<script>alert('Marks has been changed successfully')</script>";
			  
			  }//end of form two update
		  
				
		}//end of if isset button submit
	

?>

</div>
</body>
</html>