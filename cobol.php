<?php 
include "initialize.php";
page_protect();
include('includes/header.php');
?>
        <main>
              <div class="main-banner">
            <h2>COBOL</h2>
     </div>
        <div class="main-content">
            
        <h3>Klasslista</h3>  
            <br><br>
            <table><thead><tr><th scope='col'>Namn</th><th scope='col'>Efternamn</th><th scope='col'>Email</th></tr></thead><tbody><?php echo class_count_cob();?></tbody></table>
    
        </div>
   
        </div>
        
    </main>
</div>
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
            


</div>
<?php
include('includes/footer.php');
?>