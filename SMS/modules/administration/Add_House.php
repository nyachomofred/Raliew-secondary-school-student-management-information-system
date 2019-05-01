<!DOCTYPE html>
<html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

    
    <?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require_once dirname(__FILE__).'/Admin_dash.php';
	$houseSuccess="";
    ?>
    <head>
        <meta charset="UTF-8">
        <title>FDM | Add House</title>
        <link rel="stylesheet" href="../../styles/form_template.css">

    </head>
    <body>
        <?php
        // put your code here
        if(isset($_POST['btnSubmit'])){
            $house_name=  escape(strtoupper($_POST['txtHouse_Name']));
            $bed_capacity= escape($_POST['txtBed_Capacity']);
            
            //query
            $sql="INSERT INTO `sms`.`add_house` "
                    . "(`House_ID`, `House_Name`, `Bed_Capacity`) "
                    . "VALUES (NULL,?,?)";
            $pstm=  mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($pstm, 'si', $name,$capacity);
            $name=$house_name;
            $capacity=$bed_capacity;
            if(mysqli_stmt_execute($pstm)){
                $houseSuccess= 'House added successfully';
				?>
                <script type="text/javascript">
                window.location.assign("View_House.php");
                </script>
                <?php
                
            }  else {
                echo mysqli_error($conn);
            }
            
            
        }
        
        ?>
        <div class="content">
            <form name="frnAdd_House" method="post" action="" id="Form1" onsubmit="return ValidatefrnAdd_House(this)" class="form-container">
            <div class="form-title"><h2>House Registration Form</h2></div>
            
            <div class="form-title">House Name</div>
            <input type="text" id="Editbox1"  name="txtHouse_Name" required value="" maxlength="25" class="form-field">
            
            <div class="form-title">Bed Capacity</div>
            <input type="number" id="Editbox2"  name="txtBed_Capacity" required="" min="1" max="1000" value="" maxlength="4" class="form-field">
            
            <div class="submit-container">
            <input type="submit" id="Button1" name="btnSubmit" value="Add" class="submit-button">
            <input type="reset" id="Button2" name="btnCancel" value="Cancel" onClick="window.location.assign('Admin_Dashboard.php')" class="submit-button">
            </div>
            <p style="color:green;text-align:center;width:600px;"><?php echo $houseSuccess;?></p>
            </form>
            </div>
        
</body>
        
    </body>
</html>
