<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Edit Marks Allocation</title>
</head>

<body>
<?php
//view exam allocation for exam one
$sql="SELECT tblexam_types.Marks_Allocation FROM tblexam_types where tblexam_types.Id=1";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$exam1=$row['Marks_Allocation'];
	}
	
	//view exam allocation for exam two
$sql2="SELECT tblexam_types.Marks_Allocation FROM tblexam_types where tblexam_types.Id=2";
$result2=mysqli_query($conn,$sql2);
while($row2=mysqli_fetch_assoc($result2)){
	$exam2=$row2['Marks_Allocation'];
	}
	if(isset($_POST['btnUpdate'])){
		 $examOne=escape($_POST['txtExam1']);
		 $examTwo=escape($_POST['txtExam2']);
		
		
		//check the sum of the two fields if they sum up to 100
		$sum=$examOne+$examTwo;
		if($sum===100){
			//define sql to update the new entryies
			//disable autocommit
			mysqli_autocommit($conn,false);
			$sql1="UPDATE tblexam_types SET tblexam_types.Marks_Allocation='".$examOne."' WHERE tblexam_types.Id=1";
			mysqli_query($conn,$sql1);
			mysqli_commit($conn);
			
			$sql2="UPDATE tblexam_types SET tblexam_types.Marks_Allocation='".$examTwo."' WHERE tblexam_types.Id=2";
			mysqli_query($conn,$sql2);
			mysqli_commit($conn);
			echo "<script>alert('Exam marks allocation changed successfully')</script>";
			?>
            <script type="text/javascript">
            window.location.assign("View_Exam_Type.php");
            </script>
            <?php
			
			}else{
				echo "<script>alert('failed...Total marks must add up to 100%')</script>";
				}
		}

?>
<div class="content">
<form action="" method="post" name="frmEdit_Exam_Allocation">
<table width="500" cellpadding="5">
  <tr>
    <td><label for="txtExam1">Exam One</label></td>
    <td><input type="number" name="txtExam1" id="txtExam1" placeholder="<?php echo $exam1?>" required max="100" min="0" /></td>
  </tr>
  <tr>
    <td><label for="txtExam2">Exam Two</label></td>
    <td><input type="number" name="txtExam2" id="txtExam2" placeholder="<?php echo $exam2?>" required max="100" min="0" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnUpdate" id="btnUpdate" value="Update" />
      <input type="reset" name="btnCancel" id="btnCancel" value="Cancel" /></td>
  </tr>
</table>

</form>
</div>

</body>
</html>