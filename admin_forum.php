<?php 

include('initialize.php');
page_protect();
auth_protect();
include('includes/header.php');
?>
    
    <main>
        <div class="main-banner">
            <h2>Forum</h2>
        </div>
         <br><br>   
<?php 

if(empty($_POST['submit'])){


} 
else
{
//make function
    global $conn;
    $cat_name = clean_input($_POST['cat_name']);
    $cat_descript = clean_input($_POST['cat_descript']);
    $posted_by = $user_data['username'];
    $sql = "INSERT INTO `categories`(`cat_name`, `cat_descript`,`posted_by`)VALUES('$cat_name','$cat_descript','$posted_by')";

    $result = $conn->query($sql);
    
    if(!$result)
    {
        
        echo "<div class='main-content' ' style='color:red;'>Ej postad! ofullständigt ifylld</div>";
    }
    else
    {
        echo "<div class='main-content'>Ny post tillagd!</div>";

 
    }
}
?>
                </div>
        
<table><thead>
        <tr><th scope='col'>Ämne:</th><th scope='col'>Innehåll:</th></tr>
            
        </thead>  
        
           <tbody><form method='post' action=''>
                <td><input type='text' name='cat_name'/></td>
            <td><textarea name='cat_descript'></textarea></td>
            <tr><th scope='row'><input type='submit' name='submit' value="Lägg till"/></th><th scope="row"></th></tr>
            </form>
                
            </tbody></table>
    </main>

<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
            

           
<div>

<?php include('includes/footer.php');?>
