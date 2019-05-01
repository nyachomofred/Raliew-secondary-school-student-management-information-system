<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
require dirname(__FILE__).'/../administration/Admin_dash.php';
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FDM | Search Result</title>
</head>

<body>
<?php 
//get student admission no
$stdAdmission=escape($_GET['txtSearchParent']);

//use it to get parent ID
$getParentID="SELECT add_student.Parent_ID FROM add_student WHERE add_student.Admission_No='".$stdAdmission."'";

$result=mysqli_query($conn,$getParentID);
while($row=mysqli_fetch_assoc($result)){
	$parentID=$row['Parent_ID'];
	}
	
	//use the ID to populate parents' contacts
	$sqlGetParentContact="SELECT CONCAT(add_gurdian.First_Name,'  ',add_gurdian.Last_Name) AS Name, add_gurdian.Phone_Number,add_gurdian.Email FROM add_gurdian WHERE add_gurdian.Id_No='".$parentID."'";
	
	$resultParent=mysqli_query($conn,$sqlGetParentContact);
	$rows=mysqli_num_rows($resultParent);
	
	if($rows==1){
		?>
        <div class="content">
        <table border="1">
        <tr>
        <th>Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        </tr>
        <?php
	while($rowParent=mysqli_fetch_assoc($resultParent)){
		?>
        <tr>
        <td><?php echo $rowParent['Name'];?></td>
        <td><?php echo $rowParent['Phone_Number'];?></td>
        <td><?php echo $rowParent['Email'];?></td>
        </tr>
        <?php
		
		}
		?>
        </table>
        </div>
        <?php
	}
	
?>
</body>
</html>