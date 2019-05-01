
<?php session_start();?>
<?php require_once('../../../Connections/sms.php'); 
?>

<!DOCTYPE html>
<html>
<head>
<?php
   
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View Marksheet</title>
</head>

<body>
<div class="content">
<form action="" method="post" name="frmMarksheet_Load">
  <table width="1044" cellpadding="5">
  <tr>
    <td width="191"><label for="cmbForm">Form</label>&nbsp;&nbsp;
      <select name="cmbForm" id="cmbForm">
        <option>Please Select</option>
        <option value="1">Form One</option>
        <option value="2">Form Two</option>
        <option value="3">Form Three</option>
        <option value="4">Form Four</option>
      </select></td>
    <td width="210"><label for="cmbStream">Stream</label>&nbsp;&nbsp;
      <select name="cmbStream" id="cmbStream">
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
      <select name="cmbTerm" id="cmbTerm">
        <option>Please Select</option>
        <option value="1">Term One</option>
        <option value="2">Term Two</option>
        <option value="3">Term Three</option>
      </select></td>
    <td width="169"><label for="cmbSubjects">Subject</label>
      <select name="cmbSubjects" id="cmbSubjects">
        <option>Please Select</option>
        <option value="1">ALL</option>
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
      <select name="cmbExam_Type" id="cmbExam_Type">
        <option>Please Select</option>
        <option value="1">Exam One</option>
        <option value="2">Exam Two</option>
      </select></td>
    <td width="43"><input type="submit" name="btnGo" id="btnGo" value="Load" /></td>
  </tr>
</table>

</form>

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
	echo "<p><strong>"."MARKS SHEET FOR FORM ".$frm."  ".$strm."  TERM  ".$term."   EXAM ".$Exam_Type."</strong></p>";
	
	
	//check the form selected form
				if($frm==1){
		//check the subjects selected..if all all then populate marks for each subject
			if($subject==1){
			$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_one_marks.101,tblform_one_marks.102,tblform_one_marks.121,tblform_one_marks.231,tblform_one_marks.232,tblform_one_marks.233,tblform_one_marks.311,tblform_one_marks.312,tblform_one_marks.313,tblform_one_marks.443,tblform_one_marks.565 FROM add_student,tblform_one_marks
			 WHERE tblform_one_marks.Term='".$term."' AND tblform_one_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_one_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			 ?>
             <table border="1" cellpadding="1">
  <tr>
    <td>Admission_No</td>
    <td>Name</td>
    <td>101</td>
    <td>102</td>
    <td>121</td>
    <td>231</td>
    <td>232</td>
    <td>233</td>
    <td>311</td>
    <td>312</td>
    <td>313</td>
    <td>443</td>
    <td>565</td>
  </tr>
             <?php
			 
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Eng=$rowPopAll['101'];
				 $Kis=$rowPopAll['102'];
				 $Maths=$rowPopAll['121'];
				 $Bio=$rowPopAll['231'];
				 $Phy=$rowPopAll['232'];
				 $Chem=$rowPopAll['233'];
				 $Hist=$rowPopAll['311'];
				 $Geog=$rowPopAll['312'];
				 $cre=$rowPopAll['313'];
				 $agric=$rowPopAll['443'];
				 $bs=$rowPopAll['565'];
				 ?>
                 <tr>

                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Eng?></td>
                    <td><?php echo $Kis?></td>
                    <td><?php echo $Maths?></td>
                    <td><?php echo $Bio?></td>
                    <td><?php echo $Phy?></td>
                    <td><?php echo $Chem?></td>
                    <td><?php echo $Hist?></td>
                    <td><?php echo $Geog?></td>
                    <td><?php echo $cre?></td>
                    <td><?php echo $agric?></td>
                    <td><?php echo $bs?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 
				 }//end of while loop for populating all subjects
				 
				 ?>
                 </table>
                 <?php
			
			}//end of if all subject selected
			
			else{
				$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_one_marks.$subject FROM add_student,tblform_one_marks
			 WHERE tblform_one_marks.Term='".$term."' AND tblform_one_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_one_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			

			 ?>
             <table border="1" cellpadding="1">
  <tr>
  	<td>S/No</td>
    <td>Admission_No</td>
    <td>Name</td>
    <td width="50px" valign="middle"><?php echo $subject?></td>

  </tr>
             <?php
			 $count=1;
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Subjc=$rowPopAll[$subject];
				 ?>
                 <tr>
					<td><?php echo $count?></td>	
                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Subjc?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 $count++;
				 }//end of while loop for populating one subject
				 
				 ?>
                 </table>
                 <?php
				
				}//end of if a given subject is selected
			
	
		}//end of form one selected
	
			else if($frm==2){
		//check the subjects selected..if all all then populate marks for each subject
			if($subject==1){
			$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_two_marks.101,tblform_two_marks.102,tblform_two_marks.121,tblform_two_marks.231,tblform_two_marks.232,tblform_two_marks.233,tblform_two_marks.311,tblform_two_marks.312,tblform_two_marks.313,tblform_two_marks.443,tblform_two_marks.565 FROM add_student,tblform_two_marks
			 WHERE tblform_two_marks.Term='".$term."' AND tblform_two_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_two_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			 ?>
             <table border="1" cellpadding="1">
  <tr>
    <td>Admission_No</td>
    <td>Name</td>
    <td>101</td>
    <td>102</td>
    <td>121</td>
    <td>231</td>
    <td>232</td>
    <td>233</td>
    <td>311</td>
    <td>312</td>
    <td>313</td>
    <td>443</td>
    <td>565</td>
  </tr>
             <?php
			 
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Eng=$rowPopAll['101'];
				 $Kis=$rowPopAll['102'];
				 $Maths=$rowPopAll['121'];
				 $Bio=$rowPopAll['231'];
				 $Phy=$rowPopAll['232'];
				 $Chem=$rowPopAll['233'];
				 $Hist=$rowPopAll['311'];
				 $Geog=$rowPopAll['312'];
				 $cre=$rowPopAll['313'];
				 $agric=$rowPopAll['443'];
				 $bs=$rowPopAll['565'];
				 ?>
                 <tr>

                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Eng?></td>
                    <td><?php echo $Kis?></td>
                    <td><?php echo $Maths?></td>
                    <td><?php echo $Bio?></td>
                    <td><?php echo $Phy?></td>
                    <td><?php echo $Chem?></td>
                    <td><?php echo $Hist?></td>
                    <td><?php echo $Geog?></td>
                    <td><?php echo $cre?></td>
                    <td><?php echo $agric?></td>
                    <td><?php echo $bs?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 
				 }//end of while loop for populating all subjects
				 
				 ?>
                 </table>
                 <?php
			
			}//end of if all subject selected
			
			else{
				$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_two_marks.$subject FROM add_student,tblform_two_marks
			 WHERE tblform_two_marks.Term='".$term."' AND tblform_two_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_two_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			

			 ?>
             <table border="1" cellpadding="1">
  <tr>
  	<td>S/No</td>
    <td>Admission_No</td>
    <td>Name</td>
    <td width="50px" valign="middle"><?php echo $subject?></td>

  </tr>
             <?php
			 $count=1;
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Subjc=$rowPopAll[$subject];
				 ?>
                 <tr>
					<td><?php echo $count?></td>	
                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Subjc?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 $count++;
				 }//end of while loop for populating one subject
				 
				 ?>
                 </table>
                 <?php
				
				}//end of if a given subject is selected
			
	
		}//end of form two selected
	
	
	else if($frm==3){
		//check the subjects selected..if all all then populate marks for each subject
			if($subject==1){
			$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_three_marks.101,tblform_three_marks.102,tblform_three_marks.121,tblform_three_marks.231,tblform_three_marks.232,tblform_three_marks.233,tblform_three_marks.311,tblform_three_marks.312,tblform_three_marks.313,tblform_three_marks.443,tblform_three_marks.565 FROM add_student,tblform_three_marks
			 WHERE tblform_three_marks.Term='".$term."' AND tblform_three_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_three_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			 ?>
             <table border="1" cellpadding="1">
  <tr>
    <td>Admission_No</td>
    <td>Name</td>
    <td>101</td>
    <td>102</td>
    <td>121</td>
    <td>231</td>
    <td>232</td>
    <td>233</td>
    <td>311</td>
    <td>312</td>
    <td>313</td>
    <td>443</td>
    <td>565</td>
  </tr>
             <?php
			 
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Eng=$rowPopAll['101'];
				 $Kis=$rowPopAll['102'];
				 $Maths=$rowPopAll['121'];
				 $Bio=$rowPopAll['231'];
				 $Phy=$rowPopAll['232'];
				 $Chem=$rowPopAll['233'];
				 $Hist=$rowPopAll['311'];
				 $Geog=$rowPopAll['312'];
				 $cre=$rowPopAll['313'];
				 $agric=$rowPopAll['443'];
				 $bs=$rowPopAll['565'];
				 ?>
                 <tr>

                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Eng?></td>
                    <td><?php echo $Kis?></td>
                    <td><?php echo $Maths?></td>
                    <td><?php echo $Bio?></td>
                    <td><?php echo $Phy?></td>
                    <td><?php echo $Chem?></td>
                    <td><?php echo $Hist?></td>
                    <td><?php echo $Geog?></td>
                    <td><?php echo $cre?></td>
                    <td><?php echo $agric?></td>
                    <td><?php echo $bs?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 
				 }//end of while loop for populating all subjects
				 
				 ?>
                 </table>
                 <?php
			
			}//end of if all subject selected
			
			else{
				$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_three_marks.$subject FROM add_student,tblform_three_marks
			 WHERE tblform_three_marks.Term='".$term."' AND tblform_three_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_three_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			

			 ?>
             <table border="1" cellpadding="1">
  <tr>
  	<td>S/No</td>
    <td>Admission_No</td>
    <td>Name</td>
    <td width="50px" valign="middle"><?php echo $subject?></td>

  </tr>
             <?php
			 $count=1;
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Subjc=$rowPopAll[$subject];
				 ?>
                 <tr>
					<td><?php echo $count?></td>	
                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Subjc?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 $count++;
				 }//end of while loop for populating one subject
				 
				 ?>
                 </table>
                 <?php
				
				}//end of if a given subject is selected
			
	
		}//end of form three selected
	
		else if($frm==4){
		//check the subjects selected..if all all then populate marks for each subject
			if($subject==1){
			$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_four_marks.101,tblform_four_marks.102,tblform_four_marks.121,tblform_four_marks.231,tblform_four_marks.232,tblform_four_marks.233,tblform_four_marks.311,tblform_four_marks.312,tblform_four_marks.313,tblform_four_marks.443,tblform_four_marks.565 FROM add_student,tblform_four_marks
			 WHERE tblform_four_marks.Term='".$term."' AND tblform_four_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_four_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			 ?>
             <table border="1" cellpadding="1">
  <tr>
    <td>Admission_No</td>
    <td>Name</td>
    <td>101</td>
    <td>102</td>
    <td>121</td>
    <td>231</td>
    <td>232</td>
    <td>233</td>
    <td>311</td>
    <td>312</td>
    <td>313</td>
    <td>443</td>
    <td>565</td>
  </tr>
             <?php
			 
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Eng=$rowPopAll['101'];
				 $Kis=$rowPopAll['102'];
				 $Maths=$rowPopAll['121'];
				 $Bio=$rowPopAll['231'];
				 $Phy=$rowPopAll['232'];
				 $Chem=$rowPopAll['233'];
				 $Hist=$rowPopAll['311'];
				 $Geog=$rowPopAll['312'];
				 $cre=$rowPopAll['313'];
				 $agric=$rowPopAll['443'];
				 $bs=$rowPopAll['565'];
				 ?>
                 <tr>

                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Eng?></td>
                    <td><?php echo $Kis?></td>
                    <td><?php echo $Maths?></td>
                    <td><?php echo $Bio?></td>
                    <td><?php echo $Phy?></td>
                    <td><?php echo $Chem?></td>
                    <td><?php echo $Hist?></td>
                    <td><?php echo $Geog?></td>
                    <td><?php echo $cre?></td>
                    <td><?php echo $agric?></td>
                    <td><?php echo $bs?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 
				 }//end of while loop for populating all subjects
				 
				 ?>
                 </table>
                 <?php
			
			}//end of if all subject selected
			
			else{
				$sql_Populate_All="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name,tblform_four_marks.$subject FROM add_student,tblform_four_marks
			 WHERE tblform_four_marks.Term='".$term."' AND tblform_four_marks.Exam_Id='".$Exam_Type."' AND add_student.Admission_No=tblform_four_marks.Admission_No ORDER BY add_student.Admission_No";
			 
			 $resultPopAll=mysqli_query($conn,$sql_Populate_All);
			

			 ?>
             <table border="1" cellpadding="1">
  <tr>
  	<td>S/No</td>
    <td>Admission_No</td>
    <td>Name</td>
    <td width="50px" valign="middle"><?php echo $subject?></td>

  </tr>
             <?php
			 $count=1;
			 while($rowPopAll=mysqli_fetch_assoc($resultPopAll)){
				 $admNo=$rowPopAll['Admission_No'];
				 $Name=$rowPopAll['Name'];
				 $Subjc=$rowPopAll[$subject];
				 ?>
                 <tr>
					<td><?php echo $count?></td>	
                    <td><?php echo $admNo?></td>
                    <td><?php echo $Name?></td>
                    <td><?php echo $Subjc?></td>
                    
 			 </tr>
                 <?php
				 
				 
				 $count++;
				 }//end of while loop for populating one subject
				 
				 ?>
                 </table>
                 <?php
				
				}//end of if a given subject is selected
			
	
		}//end of form four selected
		
		else{
			echo "<script>alert('Form is required')</script>";
			}//end of no subject is selected
		
		
	
	
	
}//end of if isset btn go
session_destroy();

?>
</div>
</body>
</html>

