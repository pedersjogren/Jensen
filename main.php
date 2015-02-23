<?php

include "initialize.php";
page_protect();
include('includes/header.php');
?>
            
            <main>
        <div class="main-banner">
            <h2>Allmän information</h2>
        </div>

 <?php

global $conn;
$sql = "select * from `categories` ORDER BY cat_id DESC";
$result = $conn->query($sql);

if(!$result)
{
    echo 'Kategorierna kan tyvärr inte visas';
}
else{
    
while ($row = mysqli_fetch_object($result)) {
    
echo "<div class='main-content'><table ' style='min-width: 200px; max-width:600px'><thead><tr><th scope='col'>".$row->cat_name."</th></tr></thead><tfoot><tr><td colspan='3'  style=color:#7879A1;>".$row->timestamp."</td></tr></tfoot><tbody><tr><th scope='row'>".$row->cat_descript."</th></tr><tr><th scope='row' ' style='color:#78A189;'>".$row->posted_by."</th></tr></tbody></table></div>";
   
  
}
mysqli_free_result($result);
}
?>

    </main>

<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
            

           
<div>

<?php include('includes/footer.php');?>