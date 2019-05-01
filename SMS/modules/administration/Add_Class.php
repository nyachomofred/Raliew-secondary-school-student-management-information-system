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
	 require_once dirname(__FILE__).'/Admin_dash.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>FDM | Add Clas</title>
        <link rel="stylesheet" href="../../styles/form_template.css">
            <script>
            function ValidatefrmAdd_Class(theForm)
            {
               var regexp;
               if (theForm.Combobox1.selectedIndex < 0)
               {
                  alert("Invalid input for level");
                  theForm.Combobox1.focus();
                  return false;
               }
               if (theForm.Combobox1.selectedIndex == 0)
               {
                  alert("Invalid input for level");
                  theForm.Combobox1.focus();
                  return false;
               }
               return true;
            }
            </script>
        
    </head>
    <body>
        <?php
        // put your code here
        if(isset($_POST['btnSubmit_Class'])){
            $class_level=  $_POST['cmbLevel'];
            $class_name=  escape(strtoupper($_POST['txtClassName']));
            $class_capacity=  escape($_POST['txtCapacity']);
            
            //prepare sql 
            $sql="INSERT INTO `sms`.`add_class` "
                    . "(`Class_Id`, `Form`, `Name`, `Capacity`) "
                    . "VALUES (NULL,?,?,?)";
            $pstm=  mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($pstm, 'isi', $level,$name,$capacity);
            $level=$class_level;
            $name=$class_name;
            $capacity=$class_capacity;
            
            //execute
            if(mysqli_stmt_execute($pstm)){
                echo 'Class is added successfully';
				?>
                <script type="text/javascript">
                window.location.assign("Class_View.php");
                </script>
                <?php
            }  else {
                echo mysqli_error($conn);    
            }
            
            
            
            
        }
        
        ?>
 		<div class="content">
        <form name="frmAdd_Class" method="post" action="" id="Form1" onsubmit="return ValidatefrmAdd_Class(this)" class="form-container">
        <div class="form-title"><h2>Class Registration Form</h2></div>
        
       <div class="form-title">Level</div>
        <select name="cmbLevel" size="1" id="Combobox1" class="form-field">
        <option selected class="form-field">[Please Select Level]</option>
        <option value="1">Form One</option>
        <option value="2">Form Two</option>
        <option value="3">Form Three</option>
        <option value="4">Form Four</option>
        </select>
        
        <div class="form-title">Name</div>
        <input type="text" id="Editbox1" name="txtClassName" required value="" maxlength="15" placeholder="e.g West" class="form-field">
        <div class="form-title">Capacity</div>
        <input type="text" id="Editbox2" name="txtCapacity" required class="form-field" value="" maxlength="3" placeholder="e.g 45">
        <div class="submit-container">
        <input type="submit" id="Button1" name="btnSubmit_Class" value="Add" class="submit-button">
        <input type="reset" id="Button2" name="btnCancel" value="Cancel" onClick="window.location.assign('Admin_Dashboard.php')" class="submit-button">
        </div>
        </form>
		</div>
        
    </body>
</html>
