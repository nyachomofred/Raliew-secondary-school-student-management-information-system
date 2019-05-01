<!DOCTYPE html>
<html>
<head>
<?php
    
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    require dirname(__FILE__).'/../administration/Admin_dash.php';
    ?>


<title>FRM | Generate Result</title>
</head>
<body>
<div class="content">
<form action="" method="post" name="frmGenerateResult">
<table width="449" cellpadding="5">
  <tr>
    <td width="116"><label for="cmbForm">Form
      <select name="cmbForm" id="cmbForm">
        <option>Please Select</option>
        <option value="1">Form One</option>
        <option value="2">Form Two</option>
        <option value="3">Form Three</option>
        <option value="4">Form Four</option>
      </select>
    </label></td>
    <td width="115">Term
      <select name="cmbTerm" id="cmbTerm">
        <option>Please Select</option>
        <option value="1">Term One</option>
        <option value="2">Term Two</option>
        <option value="3">Term Three</option>
      </select></td>
    <td width="115">Exam Type
      <select name="cmbExam" id="cmbExam">
        <option>Please Select</option>
        <option value="1">Exam One</option>
        <option value="2">Exam Two</option>
        <option value="3">Final Result</option>
      </select></td>
    <td width="154"><input type="submit" name="btnLoad" id="btnLoad" value="Load"></td>
  </tr>
</table>

</form>
<?php 
if(isset($_POST['btnLoad'])){
	mysqli_autocommit($conn,false);
	 $_SESSION['form']=$_POST['cmbForm'];
	$_SESSION['Term']=$_POST['cmbTerm'];
	$_SESSION['Exam_ID']=$_POST['cmbExam'];
	
	//store the session var in variables
	$form=$_SESSION['form'];
	$term=$_SESSION['Term'];
	$Exam_Id=$_SESSION['Exam_ID'];
	
	if($form==1){
		if($term==1){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term1_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term1_cat1 SELECT * FROM form1_term1_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm1_term1_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term1_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term1_cat2 SELECT * FROM form1_term1_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm1_term1_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term1_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm1_term1_results SELECT * FROM form1_term1_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm1_term1_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form One Term One block***********************************************************
			
			if($term==2){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term2_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term2_cat1 SELECT * FROM form1_term2_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm1_term2_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term2_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term2_cat2 SELECT * FROM form1_term2_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm1_term2_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term2_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm1_term2_results SELECT * FROM form1_term2_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm1_term2_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form One Term Two block***********************************************************

if($term==3){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term3_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term3_cat1 SELECT * FROM form1_term3_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm1_term3_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term3_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm1_term3_cat2 SELECT * FROM form1_term3_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm1_term3_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm1_term3_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm1_term3_results SELECT * FROM form1_term3_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm1_term3_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form One Term Three block***********************************************************
			
						
			
			
		}
//--------------------------------------end of if form is equal to one----------------------------------------------------------------


	if($form==2){
		if($term==1){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term1_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term1_cat1 SELECT * FROM form2_term1_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm2_term1_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term1_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term1_cat2 SELECT * FROM form2_term1_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm2_term1_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term1_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm2_term1_results SELECT * FROM form2_term1_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm2_term1_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form two Term One block***********************************************************
			
			if($term==2){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term2_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term2_cat1 SELECT * FROM form2_term2_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm2_term2_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term2_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term2_cat2 SELECT * FROM form2_term2_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm2_term2_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term2_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm2_term2_results SELECT * FROM form2_term2_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm2_term2_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form two Term Two block***********************************************************

if($term==3){
			if($Exam_Id==1){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term3_cat1";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term3_cat1 SELECT * FROM form2_term3_cat1";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL, @curRank := IF(@prevRank = EXAM_ONE_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_ONE_TOTAL
						 FROM tbl_frm2_term3_cat1 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_ONE_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is one
				
							if($Exam_Id==2){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term3_cat2";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE if NOT EXISTS tbl_frm2_term3_cat2 SELECT * FROM form2_term3_cat2";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, Rank  FROM 
						(SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_TWO_TOTAL, @curRank := IF(@prevRank = EXAM_TWO_TOTAL, @curRank, @incRank)
						 AS rank, @incRank := @incRank + 1, @prevRank := EXAM_TWO_TOTAL
						 FROM tbl_frm2_term3_cat2 p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY EXAM_TWO_TOTAL DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT TWO</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_TWO_TOTAL'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is two
				
											if($Exam_Id==3){
				$sql="DROP TABLE IF EXISTS tbl_frm2_term3_results";
				if(mysqli_query($conn,$sql)){
					$sql="CREATE TABLE IF NOT EXISTS tbl_frm2_term3_results SELECT * FROM form2_term3_results";
					if(mysqli_query($conn,$sql)){
						$sql="SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE, Rank 
						FROM (SELECT ADMISSION_No, FULL_NAME,STREAM,EXAM_ONE_TOTAL,EXAM_TWO_TOTAL,TOTAL_SCORE,
						 @curRank := IF(@prevRank = TOTAL_SCORE, @curRank, @incRank) AS Rank, @incRank := @incRank + 1, @prevRank := TOTAL_SCORE
						 FROM tbl_frm2_term3_results p, ( SELECT @curRank :=0, @prevRank := NULL, @incRank := 1 ) r ORDER BY TOTAL_SCORE DESC) s";
						  
						  $result=mysqli_query($conn,$sql);
						  ?>
                          <form>
                          <table border="1" cellpadding="1">
                              <tr>
                                <td>ADMISSION_No</td>
                                <td>FULL_NAME</td>
                                <td>STREAM</td>
                                <td>CAT ONE</td>
                                <td>CAT TWO</td>
                                <td>TOTAL</td>
                                <td>Rank</td>
                              </tr>
                          <?php
						  while($row=mysqli_fetch_assoc($result)){
							  $AdmNo=$row['ADMISSION_No'];
							  $FullName=$row['FULL_NAME'];
							  $Stream=$row['STREAM'];
							  $Cat1Mark=$row['EXAM_ONE_TOTAL'];
							  $Cat2Mark=$row['EXAM_TWO_TOTAL'];
							  $total=$row['TOTAL_SCORE'];
							  $Rank=$row['Rank'];
							  
							  ?>
                              <tr>
                              	<td><?php echo $AdmNo?></td>
                                <td><?php echo $FullName?></td>
                                <td><?php echo $Stream?></td>
                                <td><?php echo $Cat1Mark?></td>
                                <td><?php echo $Cat2Mark?></td>
                                <td><?php echo $total?></td>
                                <td><input type="text" readonly value="<?php echo $Rank?>"></td>
                              </tr>
                              <?php
							  
							  }//end of fetch assoc 
						?>
                        </table>
                        </form>
                        <?php
						}//end of if table is created successfully
					
					}//end of if drop is successfull
				
				}//end of if exam type is three
				
				
			}
//***************************************End of Form two Term Three block***********************************************************
			
						
			
			
		}
//--------------------------------------end of if form is equal to two----------------------------------------------------------------
	
	}//end of if thee load button is set
	
?>
</div>
</body>
</html>