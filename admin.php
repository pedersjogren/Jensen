<?php
include "initialize.php";
page_protect();
auth_protect();
include('includes/header.php');


?>


<main>
        <div class="main-banner">
            <h2>Admin</h2>
            </div>

<?php
if(isset($_POST['uid'])){
    $uid = $_POST['uid'];
    if(isset($_POST['activateuser'])){
        activate_user($uid);
       echo "<div class='main-content'>".'Användaren har blivit aktiverad'."<br><br></div>";
    }
    else if(isset($_POST['deleteuser'])){
        delete_user($uid);

        echo "<div class='main-content' ' style='color: red;'>".'Användaren har blivit avaktiverad'."<br><br></div>";
    }
    }

?>
 
    
        
        
         <div class="grid-container">
        
        <div class="grid-6">
             
            <table><caption>Inaktiva studenter:</caption><thead><tr><th scope='col'>Namn</th><th scope='col'>Efternamn</th><th scope='col'>Email</th></tr></thead><tbody><?php echo activate_class_count();?></tbody></table> 
          
        </div>
        <div class="grid-6">
           
<table><caption>Aktiva studenter:</caption><thead><tr><th scope='col'>Namn</th><th scope='col'>Efternamn</th><th scope='col'>Email</th></tr></thead><tbody><?php echo delete_class_count();?></tbody></table>    
     
            
            </div>
          </div>
        <div class="main-content">
            <h1></h1>    
           <p></p>
            </div>
        </div>
        
    </main>
</div>
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
<?php
include('includes/footer.php');
?>
