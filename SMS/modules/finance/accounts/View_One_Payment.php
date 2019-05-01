<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<?php
    require dirname(__FILE__).'/../../../config/dbConnect.php';
	require dirname(__FILE__).'/../../../config/security.php';
	require dirname(__FILE__).'/accountant_dash.php';
    ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | View One Payment</title>
</head>

<body>
<?php 
 $_SESSION['admNo']=$_POST['txtSearchPayment'];
 $admNo=$_SESSION['admNo'];
//get the student's details
$sql="SELECT CONCAT(add_student.First_Name,'  ',add_student.Last_Name) as Name, add_student.Form,tblstudent_acc.Debit,tblstudent_acc.Credit,tblstudent_acc.Debit-tblstudent_acc.Credit as Balance
FROM add_student,tblstudent_acc
WHERE add_student.Admission_No='".$admNo."' AND tblstudent_acc.Admission_No='".$admNo."'";

$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$Name=$row['Name'];
	$form=$row['Form'];
	$debit=$row['Debit'];
	$credit=$row['Credit'];
	$bal=$row['Balance'];
	//define markup for the table
	}
	if(mysqli_num_rows($result)==1){
	?>
  <div class="content">
  <div class="table_views">
    <table border="1" cellpadding="1">
  <tr>
    <td>Name</td>
    <td>Form</td>
    <td>Debit</td>
    <td>Credit</td>
    <td>Balance</td>
  </tr>
  
    <tr>
      <td><?php echo $Name ?></td>
      <td><?php echo $form ?></td>
      <td><?php echo $debit?></td>
      <td><?php echo $credit ?></td>
      <td><?php echo $bal?></td>
     </tr>
    <?php
	}else{
		echo "<script>alert('No record found')</script>";
		}
session_destroy();
?>
</table>
</div>
</div>
</body>
</html>