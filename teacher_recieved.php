<?php
include "initialize.php";
page_protect();
auth_protect();
include('includes/header.php');
?><br><br>
            <div class="main-banner">
        <h3>Mottagna elevuppladningar:</h3>
            
        </div>

<?php

$teacherid = $user_data["id"];
 
if(is_dir($location.$teacherid."/")){
    
if ($handle = opendir($location.$teacherid."/")) {
 
echo "<br><br><ul><table><thead><tr><th scope='col'>Mottagna filer:</th></tr>";
   
    while (false !== ($entry = readdir($handle))) {
      if($entry!= '.' && $entry != '..')
        echo "</thead><tfoot><tr><td colspan='3' style='color:#7879A1;'>Skickat från student</td></tr></tfoot><tbody><tr><th scope='row'><li><a href='".$location.$teacherid."/".$entry."'style='color:#3933DE;' target='_blank'>".$entry."</a></li></th></tr></tbody>";
    }
echo "</table></ul>";
    closedir($handle);
}

}

?>

</main>
        
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
<?php
include('includes/footer.php');
?>