<?php session_start()?>

<!DOCTYPE html>
<html>
<head>
    <?php
   
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Student Attendance</title>
</head>

<body>

<form action="" method="post" name="frmStudent_Attednace">
<table width="528" cellpadding="5">
  <tr>
    <td width="179"><label for="cmbForm">Form</label>&nbsp;&nbsp;
      <select name="cmbForm" id="cmbForm" tabindex="-1">
        <option>Please Select</option>
        <option value="1">Form One</option>
        <option value="2">Form Two</option>
        <option value="3">Form Three</option>
        <option value="4">Form Four</option>
      </select></td>
    <td width="321"><label for="cmbStream">Stream</label>&nbsp;&nbsp;
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
        
      </select>&nbsp;&nbsp;
      <input type="submit" tabindex="-8" name="btnGo" id="btnGo" value="Load" /></td>
    
  
  </tr>
</table>

</form><hr />
<form action="" method="post" name="attendance">
<?php 
if(isset($_POST['btnGo'])){
	$_SESSION['form']=$_POST['cmbForm'];
	$_SESSION['stream']=$_POST['cmbStream'];
	
	//declare var to hold for sessions
	$form=$_SESSION['form'];
	$strm=$_SESSION['stream'];
	
	?>
    
  <table border="0">
<tr>
    <td>S/No</td>
    <td>Admission No</td>
    <td>Full Name</td>
    <td>Attendance Status</td>
  </tr>
    <?php
	
	//define sql to filter data based of form and strean
	
		$sql_classList="SELECT add_student.Admission_No,CONCAT(add_student.First_Name,'  ',add_student.Last_Name)AS Name 
	FROM add_student 
	WHERE add_student.Form='".$form."' AND add_student.Stream='".$strm."' ORDER BY add_student.Admission_No";
	$result = mysqli_query($conn,$sql_classList);
    $count=0;
	$tabIndex=1;
	
	//start the counter variable
	
	$counter=1;
		while($row=mysqli_fetch_array($result)){
		$count++;
		 $AdmNo=$row['Admission_No'];
		
		echo "<tr>";
    echo "<td>".$count."</td>";
    echo"<td><input type='text' readonly tabindex='-6' name='admNo[]' value='".$row["Admission_No"]."'></td>";
    echo"<td><input type='text' readonly tabindex='-7' name='fname[]' value='".$row["Name"]."'></td>";
	
    //echo "<td><input type='number' tabindex='".$tabIndex."' name='score[]' required value='".$row["Name"]."'></td>";
			
	echo "<td class='tdhead2' valign='top'>";

    //echo each radio with the counter for this row
	
    echo "<label><input type='radio' name='ch_{$counter}[]' value='0' checked />Present</label>&nbsp;";
    echo "<label><input type='radio' name='ch_{$counter}[]' value='1' />Absent</label>";

    echo "</td>";
    echo "<td class='tdhead2' valign='top'>&nbsp;</td>";
	echo "</tr>";

    //add one to the counter
   	$counter++;
	$tabIndex++; 
	$btntabInd= $tabIndex+1;
	
		
	
		
		}//end of while loop
		?>
        <tr>
        <td><input type="submit" name="btnSubmit" tabindex="<?php $btntabInd?>" id="btnSubmit" value="Save Marks" /></td><td> <input type="reset" name="cancel" id="cancel" value="Cancel" /></td>
      </tr>
        <?php

	
	}//end of if btn go  is set
	

	
	if(isset($_POST['btnSubmit'])){
		$frm=$_SESSION['form'];
	    $strm=$_SESSION['stream'];
		
		
		
		 foreach($_POST["admNo"] as $rec=> $value){
			 echo $ad = $_POST["admNo"][$rec];
			 
			 
			
			
			
			
		/* prepare to insert the attendance as checked
		 $sql="INSERT INTO `sms`.`tblattendace` (`Admission_No`, `Status`) 
		 VALUES ('".$ad."', '".$sc."')";
		 mysqli_query($conn,$sql);*/
		 
		 }//end of foreach loop
		 echo "<script>alert('Attendance is saved successfully')</script>";

		}//end of if save attendance is clicked

?>


</table>

</form>


</body>
</html>