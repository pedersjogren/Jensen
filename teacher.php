<?php
include "initialize.php";
page_protect();
auth_protect();
include('includes/header.php');
if(isset($_FILES['file'])){
    $name = $_FILES['file']['name'];
    //$size = $_FILES['file']['size'];
    //$type = $_FILES['file']['type'];
    //when we upload, each file is sent to a temp location in ur server
    $tmp_name = $_FILES['file']['tmp_name'];
}
if(isset($_POST["studentid"])){
$studentid = $_POST["studentid"];

}
     if(isset($name)){
        if(!empty($name)){
            
            //move it from temporary file and append a place
          if(!is_dir($location.$studentid."/"))
          {
              mkdir($location.$studentid."/",777, true);
              chmod($location.$studentid."/", 0777);
          } if(move_uploaded_file($tmp_name,$location.$studentid."/".$name)){
            
               echo "<div class='main-content'>Uppladdad till: Student-id: ".$studentid." Fil: ".$name."</div>";
           }
            
        }else{
         echo "<div class='main-content' >Välj en fil</div>";
        }
    }
?>

    <main>
        <div class="main-banner">
            <h2>Lärare</h2>
            </div>
       <br><br>
  <div class="main-banner">
        <h3>Skicka betyg/schema/intyg/kursinformation till vald student:<br><br></h3>
<form action="teacher.php" method="POST" enctype="multipart/form-data">
    <select name="studentid">
        <?php student_list(); ?>
    </select>

    <input type='file' name='file'><br><br>
    
    <input type='submit' value='Skicka fil'>
    
</form> 
        </div>    
<?php

if ($handle = opendir($location)) {
    
echo "<br><br><ul><table><thead><tr><th scope='col'>Kontroll av skickade filer:</th></tr></thead>";
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
      if($entry!= '.' && $entry != '..')
        echo "<tbody><tr><th scope='row'><li> Id/fil: <a href='".$location.$entry. "' style='color:#3933DE;'> ".$entry."</a></li></th></tr></tbody>";
    }
echo "</table></ul>";
    closedir($handle);
}




?>

</main>
        
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
<?php
include('includes/footer.php');
?>
