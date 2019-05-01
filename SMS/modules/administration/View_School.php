<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
     <?php
            session_start();
            require dirname(__FILE__).'/../../config/dbConnect.php';           require_once('Admin_dash.php');
            require dirname(__FILE__).'/../../config/security.php';
    ?>
        
        <meta charset="UTF-8">
        <title></title>
       
    </head>
    <body>
        <?php
        // put your code here
        $sql="SELECT "
                . "`code`, `name`, `motto`,  `email`, `website`, `postal_address`, `postal_code`, `town`"
                . " FROM `school_details`";
        $result=  mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            ?>
            <div class="content">
        <table border="2px" align="center">
          <tr>
            <th>CODE</th><th>NAME</th><th>MOTTO</th><th>EMAIL</th>
            <th>WEBSITE</th><th>POSTAL ADDRESS</th><th>POSTAL CODE</th><th>TOWN</th><th>OPERATION</th>
        </tr>
        
        <?php
        while($row=  mysqli_fetch_assoc($result)){
            ?>
        <tr>
            <td><?php echo $row['code'];?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['motto'];?></td>
            <td><?php echo $row['email'];?></td>
            <td><?php echo $row['website'];?></td>
            <td><?php echo $row['postal_address'];?></td>
            <td><?php echo $row['postal_code'];?></td>
            <td><?php echo $row['town'];?></td>
            <td><a href="Edit_School.php"  data-toggle="tooltip" data-placement="bottom" title="Edit School"><img src="../../img/edit.png" alt="Edit"></a></td>
            
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
