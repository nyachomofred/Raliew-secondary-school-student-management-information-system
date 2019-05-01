<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
	require_once('Admin_dash.php');
    ?>
    <head>
        <meta charset="UTF-8">
        <title>FDM | School Particulars</title>
        <link rel="stylesheet" href="../../styles/form_template.css">
    </head>
    <body>
        <?php
        $sql="SELECT "
                . "`code`, `name`, `motto`,  `email`, `website`, `postal_address`, `postal_code`, `town`"
                . " FROM `school_details`";
        $result=  mysqli_query($conn,$sql);
        while($rows=mysqli_fetch_assoc($result)){
            $code=$rows['code'];
            $name=$rows['name'];
            $motto=$rows['motto'];
            $email=$rows['email'];
            $website=$rows['website'];
            $postal_add=$rows['postal_address'];
            $postal_code=$rows['postal_code'];
            $tow=$rows['town'];
            
            
        }
        ?>
        
        <?php
        // put your code here
        if(isset($_POST['btnUpdate'])){
            $Scl_Code=  escape($_POST['txtSchl_Code']);
            $Schl_Name=  escape(strtoupper($_POST['txtSchl_Name']));
            $Schl_Email=  escape(strtolower($_POST['txtSchl_Email']));
            $Schl_Motto=  escape(strtolower($_POST['txtSchl_Motto']));
            $Schl_Url=  escape(strtolower($_POST['txtWeb_Url']));
            $Schl_Address=  escape($_POST['txtPostal_Add']);
            $Sch_Postal_Code=  escape($_POST['txtPostal_Code']);
            $Town=  escape(strtoupper($_POST['txtTown']));
            $Logo=  escape($_POST['imgMotto']);
            
            //update school details
            $sql="UPDATE `sms`.`school_details` "
                    . "SET `code` =?, `name` =?, `motto` =?, `email` =?, `website` =?, `postal_address` =?, `postal_code` =?, `town` =?";
            $pstm=  mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($pstm, 'isssssis', $code,$name,$motto,$email,$web,$address,$postal_code,$town);
            $code=$Scl_Code;
            $name=$Schl_Name;
            $motto=$Schl_Motto;
            $email=$Schl_Email;
            $web=$Schl_Url;
            $address=$Schl_Address;
            $postal_code=$Sch_Postal_Code;
            $town=$Town;
            
            //execute the pstm
            if(mysqli_stmt_execute($pstm)){
                echo "Update Successful...Redirecting";
                ?>
                <script type="text/javascript">
                window.location.assign('View_School.php');
                </script>
                <?php
                
            }  else {
                echo 'error inserting'.  mysqli_error($conn);
                
            }
            
            
            
            
            
            
            
        }
        
        ?>
        <div class="content">
            <form name="frmadd_school" method="post" action="" id="Form1" class="form-container">
            <div class="form-title"><h2>Update School Details</h2></div>
            
            <div class="form-title">Name</div>
            <input type="text" id="Editbox1"  name="txtSchl_Name" required="" maxlength="50" value="<?php echo $name;?>" class="form-field">
            
            <div class="form-title">Code</div>
            <input type="number" id="Editbox2"  name="txtSchl_Code" value="<?php echo $code;?>" required="" maxlength="11" class="form-field">
            
            <div class="form-title">Motto</div>
            <input type="text" id="Editbox3"  name="txtSchl_Motto" value="<?php echo $motto;?>" required="" maxlength="30" class="form-field">
            
            <div class="form-title">Logo</div>
            <input type="file" id="FileUpload1"  name="imgMotto" class="form-field">
            
            <div class="form-title">Email</div>
            <input type="email" id="Editbox4"  name="txtSchl_Email" value="<?php echo $email;?>" required="" maxlength="30" class="form-field" />
            
            <div class="form-title">Website URL</div>
             <input type="url" id="Editbox5" name="txtWeb_Url" value="<?php echo $website;?>" required="" maxlength="30" class="form-field">
             
            
            <div class="form-title">Postal Address</div>
            <input type="text" id="Editbox6" name="txtPostal_Add" value="<?php echo $postal_add;?>" required="" maxlength="10" class="form-field">
            
            <div class="form-title">Postal Code</div>
           <input type="text" id="Editbox7" name="txtPostal_Code" value="<?php echo $postal_code;?>" required="" maxlength="10" class="form-field">
           
           <div class="form-title">Town/City</div>
           <input type="text" id="Editbox8" name="txtTown" value="<?php echo $tow;?>" required="" maxlength="25" class="form-field">
           
           <div class="submit-container">
            <input type="submit" id="Button1" name="btnUpdate" value="Update" class="submit-button">
            <input type="reset" id="Button2" name="btnCance" value="Cancel" tabindex="10" onClick="window.location.assign('View_School.php')" class="submit-button">
            </div>
            </form>   
            </div>
    </body>
</html>

