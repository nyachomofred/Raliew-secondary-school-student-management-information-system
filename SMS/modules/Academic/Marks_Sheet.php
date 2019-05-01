
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <?php
   
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Marks_Sheet</title>
</head>

<body>
<hr>
<div class="content">
<form action="" method="post" name="frmMarksheet_Load">
<table width="1044" cellpadding="5">
  <tr>
    <td width="191"><label for="cmbForm">Form</label>&nbsp;&nbsp;
      <select name="cmbForm" id="cmbForm" tabindex="-1">
        <option>Please Select</option>
        <option value="1">Form One</option>
        <option value="2">Form Two</option>
        <option value="3">Form Three</option>
        <option value="4">Form Four</option>
      </select></td>
    <td width="210"><label for="cmbStream">Stream</label>&nbsp;&nbsp;
      <select name="cmbStream" id="cmbStream" tabindex="-2">
        <option selected="selected">Please Select</option>
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
        
      </select></td>
    <td width="168"><label for="cmbTerm">Term</label>
      <select name="cmbTerm" id="cmbTerm" tabindex="-3">
        <option>Please Select</option>
        <option value="1">Term One</option>
        <option value="2">Term Two</option>
        <option value="3">Term Three</option>
      </select></td>
    <td width="169"><label for="cmbSubjects">Subject</label>
      <select name="cmbSubjects" id="cmbSubjects" tabindex="-4">
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
    <td width="187"><label for="cmbExam_Type">Exam Type</label>
      <select name="cmbExam_Type" id="cmbExam_Type" tabindex="-5">
        <option>Please Select</option>
        <option value="1">Exam One</option>
        <option value="2">Exam Two</option>
      </select></td>
    <td width="43"><input type="submit" tabindex="-8" name="btnGo" id="btnGo" value="Load" /></td>
  </tr>
</table>

</form>
<hr>

<form name="frmMarksheet" action="" method="post">

<?php 
if(isset($_POST['btnGo'])){
	$_SESSION['form']=$_POST['cmbForm'];
	$_SESSION['stream']=$_POST['cmbStream'];
	$_SESSION['term']=$_POST['cmbTerm'];
	$_SESSION['subject']=$_POST['cmbSubjects'];
	$_SESSION['Exam_Type']=$_POST['cmbExam_Type'];
	$frm=$_SESSION['form'];
	$strm=$_SESSION['stream'];
	$term=$_SESSION['term'];
	$subject=$_SESSION['subject'];
	$Exam_Type=$_SESSION['Exam_Type'];
	
	
	
	echo "<p><strong>"."MARKS SHEET FOR FORM ".$frm."  ".$strm."  TERM  ".$term."  EXAM  ".$Exam_Type."</strong></p>";
	echo "<strong>"."SUBJECT CODE: ".$subject."</strong><br><hr>"
	
	?>
    
  <table border="0">
<tr>
    <td>S/No</td>
    <td>Admission No</td>
    <td>Full Name</td>
    <td>Score</td>
  </tr>
    <?php
	
	//check if the load button is clicked and store the load criteria in sessions
	

	
	//retrieve class list
	$sql_classList="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,'  ',add_student.Last_Name)AS Name 
	FROM add_student 
	WHERE add_student.Form='".$frm."' AND add_student.Stream='".$strm."' ORDER BY add_student.Admission_No";
	$result = mysqli_query($conn,$sql_classList);
    $count=0;
	$tabIndex=1;
	
	//get the mark out of for each cat
	$sqlGetExamOut="SELECT Marks_Allocation FROM tblexam_types WHERE tblexam_types.Id='".$Exam_Type."'";
	$resultExamOut=mysqli_query($conn,$sqlGetExamOut);
	while($rowOut=mysqli_fetch_assoc($resultExamOut)){
		$marksOutOf=$rowOut['Marks_Allocation'];
		}
	while($row=mysqli_fetch_array($result)){
		$count++;
		echo "<tr>";
    echo "<td>".$count."</td>";
    echo"<td><input type='text' readonly tabindex='-6' name='admNo[]' value='".$row["Admission_No"]."'></td>";
    echo"<td><input type='text' readonly tabindex='-7' name='fname[]' value='".$row["Name"]."'></td>";
    echo "<td><input type='number' tabindex='".$tabIndex."' name='score[]' min='0'  max='".$marksOutOf."' required value='".$row["Name"]."'></td>";
    	echo "</tr>";
		$tabIndex++; 
		$btntabInd= $tabIndex+1; 
		
		}//end of while loop

	}//end of if isset btngo
		 //if score is  supplied , then click to save to database
	 if(isset($_POST['btnSubmit'])){
		 
	$frm=$_SESSION['form'];
	$strm=$_SESSION['stream'];
	$term=$_SESSION['term'];
	$subject=$_SESSION['subject'];
	$Exam_Type=$_SESSION['Exam_Type'];
	
	 if($frm==1){
		 
		 foreach($_POST["admNo"] as $rec=> $value){
		  $ad = $_POST["admNo"][$rec];
         $sc = $_POST["score"][$rec]; 
		 
		 //check the form selected to insert into correct table
		
				 //prepare sql to insert form one marks for the selected subject
				 
				 //first check whether a marks for any subject had been entered for that student in the current term and exam
				 
				 $sqlCheck_Marks="SELECT `Entry_Id` FROM `tblform_one_marks` 
				 WHERE `Admission_No`='".$ad."' AND `Stream`='".$strm."' AND`Exam_Id`='".$Exam_Type."' AND `Term`='".$term."'";
				 $resultCriteria=mysqli_query($conn,$sqlCheck_Marks);
				 
				 //check if an entry had been openned for those criteria
				 if(mysqli_num_rows($resultCriteria)==1){
						 //it means an entry had been openned...just update the entry for that student
						 while($roww=mysqli_fetch_assoc($resultCriteria)){
							 $entyID=$roww['Entry_Id'];
							 }
							 //use the entry ID to update new marks entered for a given subject
							 $sqlUpdateMarks="UPDATE tblform_one_marks SET `".$subject."`='".$sc."' WHERE `Entry_Id`='".$entyID."'";
							 mysqli_query($conn,$sqlUpdateMarks);
								
						 }//end of if an entry has been entered
					 
				 else{
					 $sqlInsert_Marks="INSERT INTO `sms`.`tblform_one_marks` 
					 (`Admission_No`, `Stream`, `Exam_Id`, `Term`, `".$subject."`)
					  VALUES ('".$ad."', '".$strm."', '".$Exam_Type."', '".$term."', '".$sc."')";
					  
					  $query_run=mysqli_query($conn,$sqlInsert_Marks);
			  
				}//end of if an entry has not been openned
				
		 }//end of for each loop
		
       }//end of if frm==1
	   else if($frm==2){
		   			 foreach($_POST["admNo"] as $rec=> $value){
		  $ad = $_POST["admNo"][$rec];
         $sc = $_POST["score"][$rec]; 
		 
		 //check the form selected to insert into correct table
		
				 //prepare sql to insert form two marks for the selected subject
				 
				 //first check whether a marks for any subject had been entered for that student in the current term and exam
				 
				 $sqlCheck_Marks="SELECT `Entry_Id` FROM `tblform_two_marks` 
				 WHERE `Admission_No`='".$ad."' AND `Stream`='".$strm."' AND`Exam_Id`='".$Exam_Type."' AND `Term`='".$term."'";
				 $resultCriteria=mysqli_query($conn,$sqlCheck_Marks);
				 
				 //check if an entry had been openned for those criteria
				 if(mysqli_num_rows($resultCriteria)==1){
						 //it means an entry had been openned...just update the entry for that student
						 while($roww=mysqli_fetch_assoc($resultCriteria)){
							 $entyID=$roww['Entry_Id'];
							 }
							 //use the entry ID to update new marks entered for a given subject
							 $sqlUpdateMarks="UPDATE tblform_two_marks SET `".$subject."`='".$sc."' WHERE `Entry_Id`='".$entyID."'";
							 mysqli_query($conn,$sqlUpdateMarks);
								
						 }//end of if an entry has been entered
					 
				 else{
					 $sqlInsert_Marks="INSERT INTO `sms`.`tblform_two_marks` 
					 (`Admission_No`, `Stream`, `Exam_Id`, `Term`, `".$subject."`)
					  VALUES ('".$ad."', '".$strm."', '".$Exam_Type."', '".$term."', '".$sc."')";
					  
					  $query_run=mysqli_query($conn,$sqlInsert_Marks);
			  
				}//end of if an entry has not been openned
				
		 }//end of for each loop
		   
		   
		   }//end of frm==2
		   
		   	   else if($frm==3){
		   			 foreach($_POST["admNo"] as $rec=> $value){
					  $ad = $_POST["admNo"][$rec];
					 $sc = $_POST["score"][$rec]; 
		 
		 //check the form selected to insert into correct table
		
				 //prepare sql to insert form three marks for the selected subject
				 
				 //first check whether a marks for any subject had been entered for that student in the current term and exam
				 
				 $sqlCheck_Marks="SELECT `Entry_Id` FROM `tblform_three_marks` 
				 WHERE `Admission_No`='".$ad."' AND `Stream`='".$strm."' AND`Exam_Id`='".$Exam_Type."' AND `Term`='".$term."'";
				 $resultCriteria=mysqli_query($conn,$sqlCheck_Marks);
				 
				 //check if an entry had been openned for those criteria
				 if(mysqli_num_rows($resultCriteria)==1){
						 //it means an entry had been openned...just update the entry for that student
						 while($roww=mysqli_fetch_assoc($resultCriteria)){
							 $entyID=$roww['Entry_Id'];
							 }
							 //use the entry ID to update new marks entered for a given subject
							 $sqlUpdateMarks="UPDATE tblform_three_marks SET `".$subject."`='".$sc."' WHERE `Entry_Id`='".$entyID."'";
							 mysqli_query($conn,$sqlUpdateMarks);
								
						 }//end of if an entry has been entered
					 
				 else{
					 $sqlInsert_Marks="INSERT INTO `sms`.`tblform_three_marks` 
					 (`Admission_No`, `Stream`, `Exam_Id`, `Term`, `".$subject."`)
					  VALUES ('".$ad."', '".$strm."', '".$Exam_Type."', '".$term."', '".$sc."')";
					  
					  $query_run=mysqli_query($conn,$sqlInsert_Marks);
			  
				}//end of if an entry has not been openned
				
		 }//end of for each loop
		   
		   
		   }//end of frm==3
		   
		   		   	   else if($frm==4){
		   			 foreach($_POST["admNo"] as $rec=> $value){
					  $ad = $_POST["admNo"][$rec];
					 $sc = $_POST["score"][$rec]; 
		 
		 //check the form selected to insert into correct table
		
				 //prepare sql to insert form four marks for the selected subject
				 
				 //first check whether a marks for any subject had been entered for that student in the current term and exam
				 
				 $sqlCheck_Marks="SELECT `Entry_Id` FROM `tblform_four_marks` 
				 WHERE `Admission_No`='".$ad."' AND `Stream`='".$strm."' AND`Exam_Id`='".$Exam_Type."' AND `Term`='".$term."'";
				 $resultCriteria=mysqli_query($conn,$sqlCheck_Marks);
				 
				 //check if an entry had been openned for those criteria
				 if(mysqli_num_rows($resultCriteria)==1){
						 //it means an entry had been openned...just update the entry for that student
						 while($roww=mysqli_fetch_assoc($resultCriteria)){
							 $entyID=$roww['Entry_Id'];
							 }
							 //use the entry ID to update new marks entered for a given subject
							 $sqlUpdateMarks="UPDATE tblform_four_marks SET `".$subject."`='".$sc."' WHERE `Entry_Id`='".$entyID."'";
							 mysqli_query($conn,$sqlUpdateMarks);
								
						 }//end of if an entry has been entered
					 
				 else{
					 $sqlInsert_Marks="INSERT INTO `sms`.`tblform_four_marks` 
					 (`Admission_No`, `Stream`, `Exam_Id`, `Term`, `".$subject."`)
					  VALUES ('".$ad."', '".$strm."', '".$Exam_Type."', '".$term."', '".$sc."')";
					  
					  $query_run=mysqli_query($conn,$sqlInsert_Marks);
			  
				}//end of if an entry has not been openned
				
		 }//end of for each loop
		   
		   
		   }//end of frm==4
	   
	   
	   
	echo "<script>alert('Marks saved successfully')</script>";
		session_destroy();		 
		 }
?>
<tr>
        <td><input type="submit" name="btnSubmit" tabindex="<?php $btntabInd?>" id="btnSubmit" value="Save Marks" /></td><td> <input type="reset" name="cancel" id="cancel" value="Cancel" /></td>
      </tr>

</table>

</form>
</div>
</body>
</html>