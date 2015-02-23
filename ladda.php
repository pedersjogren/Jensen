<?php
include "initialize.php";
page_protect();
include('includes/header.php');

if(isset($_FILES['file'])){
    $name = $_FILES['file']['name'];
    //$size = $_FILES['file']['size'];
    //$type = $_FILES['file']['type'];
    //when we upload, each file is sent to a temp location in ur server
    $tmp_name = $_FILES['file']['tmp_name'];
}
if(isset($_POST["teacherid"])){
$teacherid = $_POST["teacherid"];

}
     if(isset($name)){
        if(!empty($name)){
            
            //move it from temporary file and append a place
          if(!is_dir($location.$teacherid."/"))
          {
              mkdir($location.$teacherid."/",777, true);
              chmod($location.$teacherid."/", 0777);
          } if(move_uploaded_file($tmp_name,$location.$teacherid."/".$name)){
            
               echo "<div class='main-content'>Uppladdad till Lärar-id: ".$teacherid." Filnamn: ".$name."</div>";
           }
            
        }else{
         echo "<div class='main-content' ' style='color: red;'>Du måste välja en fil</div>";
        }
    }
?>


  <div class="main-banner">
        <h3>Skicka filer</h3>
        <p>Välj lärare och märk filen med ditt namn</p><br>      
<form action="ladda.php" method="POST" enctype="multipart/form-data">
    <select name="teacherid">
        <?php teacher_list(); ?>
    </select>
     <br><br>
    <input type='file' name='file'><br><br>
    
    <input type='submit' value='Skicka fil'>
    
</form> 
      
        </div>    


</main>
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
<?php
include('includes/footer.php');
?>
