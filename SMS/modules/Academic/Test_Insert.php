<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
  <?php
    session_start();
    require dirname(__FILE__).'/../../config/dbConnect.php';
    require dirname(__FILE__).'/../../config/security.php';
    ?>

<body>
<form id="form1" name="form1" method="POST">
  <fieldset id="Result">
  <legend>Result Capture</legend>
    <table width="1110" border="0">
      <tr>
         <!--<td width="236">Session:<span id="spryselect1">
          <label for="SessionAss"></label>
          <?php
          
          $res3= mysqli_query($conn,"SELECT * FROM schsession ");
          ?>
          <select name="SessionAssigned" id="SessionAssigned" class="sess" />
          <option>Select</option>
          <?php while($row3=mysqli_fetch_array($res3)){?>
          <option value="<?php echo $row3["session"];?>"><?php echo $row3["session"];?></option>
          <?php };?>
          </select></td>-->
          

<!--        <td width="231">Term:<span id="spryselect4">
          <label for="Term"></label>
          <?php
          
          $res4= mysqli_query($conn,"SELECT * FROM term_tab ");
          ?>
          <select name="Term" id="Term" class="term" />
          <option>Select</option>
          <?php while($row4=mysqli_fetch_array($res4)){?>
          <option value="<?php echo $row4["name"];?>"><?php echo $row4["name"];?></option>
          <?php };?>
          </select></td>-->

        <td width="219">Form  <span id="spryselect1">
          <label for="class"></label>
          <?php
          
          $res= mysqli_query($conn,"SELECT DISTINCT add_student.Form FROM add_student");
          ?>

        <select name="class" id="class" class="class">
        <option>Select</option>
          <?php while($row2=mysqli_fetch_array($res)){?>
          <option value="<?php echo $row2["Form"];?>"><?php echo $row2["Form"];?></option>
          <?php };?>
        </select>
         </span></td>
       <!--<td width="220" class="sub" id="sub" name="sub">Subject:</td>-->

      <td width="182"><input type="submit" name="RetBtn" id="RetBtn" value="Retrieve Data" /></td>
       </tr>

    </table></fieldset>
   </form>
  <form id="form2" name="form2" method="post" action="">
  <fieldset><legend>Result Computation</legend>
  <table width="840" border="0">
  <tr>
    <td width="82" height="18">SN</td>
    <td width="245">Admission No</td>
    <td width="143">Name</td>
    <td width="87">Form</td>
    <td width="98">CA(Score)</td>
  </tr>
  <?php
  if(!isset($_POST["RetBtn"])){
     $class="";
  }else{
    $class=$_POST["class"];
    $get = "SELECT add_student.Admission_No,CONCAT(add_student.First_Name,' ',add_student.Last_Name) AS Name ,add_student.Form FROM add_student WHERE add_student.Form='".$class."'"; 
    $confirm = mysqli_query($conn,$get);
    $c=0;
while($fetch=mysqli_fetch_array($confirm)){
        $c++;
    echo "<tr>";
    echo "<td>".$c."</td>";
    echo"<td><input type='text' name='admNo[]' value='".$fetch["Admission_No"]."'></td>";
    echo"<td><input type='text' name='sname[]' value='".$fetch["Name"]."'></td>";
    echo"<td><input type='text' name='class[]' value='".$fetch["Form"]."'></td>";
    echo "<td><input type='text' name='score[]'></td>";
    echo "</tr>";   
    }
  //if score is  supplied , then click to save to database
     }
   if(isset($_POST["saveBtn"])){

       foreach($_POST["admNo"] as $rec=> $value){
         $cl = $_POST["class"][$rec];
         $ad = $_POST["admNo"][$rec];
         $sc = $_POST["score"][$rec];  

  $insert = "INSERT INTO result_tab(AdmNo,Class,score)VALUES('$ad','$cl','$sc')";
 $succ = mysqli_query($conn,$insert); 
 
       }
	   echo 'score inserted successfully';
  }


  ?>


   <tr>
        <td><input type="submit" name="saveBtn" id="saveBtn" value="Save Score" /></td><td> <input type="reset" name="cancel" id="cancel" value="Cancel" /></td>
      </tr>
</table>

  </fieldset>
  </form>

</body>
</html>