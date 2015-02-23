<?php 

include('initialize.php');
//protect against user who is not logged in
page_protect();


//has data been posted, if aaa we know that the form is submitting
if(empty($_POST)===false){
      $req_fields = array('current_password','password','password_again');
//in_array — Checks if a value exists in an array
//key= ex. current_password value the written value
foreach($_POST as $key=>$value){
            //if the value is empt and if its in the array that is required
        if(empty($value) && in_array($key, $req_fields)=== true){
        $err[] = 'Fält med en asterix * måste fyllas i';
            //break out of the loop and cont. with execution
            //if one error exists= break out, the first instance wher something happens we //need to throw an error
        break 1;
        }
}
    //errors is defined in init.php
    //we encrypt the password that they type in and compare it to the password in db
     // $user_data['password']; // [] because it is in an array
if(isset($_POST['current_password']) && (sha1($_POST['current_password']) === $user_data['password'])){
     
      if(trim($_POST['password']) !== trim($_POST['password_again'])){
         
         $err[] = 'Ditt nya lösenord passar inte';
     
     }else if(strlen($_POST['password']) < 6 ){
         $err[]= 'Ditt lösenord måste ha minst 6 tecken';
     }
  
  }else{
    
    if(isset($_POST['current_password']) &&(sha1($_POST['current_password']) !== $user_data['password'])){
        $err[] = 'Ditt nya lösenord passar inte eller är tomt...';
    
    }
    else if(isset($_GET['done']) && empty($_GET['done'])){
            $err[]= "Ditt lösenord är nu ändrat";
        }else{
           $err[]= "Ditt nuvarande lösenord inkorrekt";
        }
        
     }
   
}

include('includes/header.php');
?>
 <main>
        <div class="main-banner">
           <h2>Ändra inställningar</h2>
        </div>
     <?php
if(isset($_GET['success']) && empty($_GET['success'])){
    
        echo "<div class='main-content'><strong>Ditt lösenord har bytts!</strong><br><form method='post' action='profile.php?done'><input type='submit' name='back' value='Tillbaka'></div>";

}else{
        if(empty($_POST) === false && empty($err)=== true){
           //posted the form and no errors
            change_password($session_user_id, $_POST['password']);
           
        header('Location: profile.php?success');
            
        }else if (empty($err) === false){

            echo "<div class='main-content'>".errors($err)."</div>";
        }


    ?>

   

          
        <div class="main-content">
            
        <table><thead>
        <tr><th scope='col'>Byt lösenord:</th></tr>
            
        </thead> 
            <tbody>
                
               <form method='post' action=''>
               <tr><th scope='row'><input type='password' name='current_password' placeholder='Nuvarande lösenord*'/></th></tr>
               <tr><th scope='row'><input type='password' name='password' placeholder='Nytt lösenord*'/></th></tr>
               <tr><th scope='row'><input type='password' name='password_again' placeholder='Nytt lösenord igen*'/></th></tr>
               <tr><th scope='row'><input type='submit' name='submit' value='Byt lösenord'/></th></tr>
            </form>
                
            </tbody>
                
            </table>
                
            </div>;
   
        </div>

    </main>
</div>
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
<?php
}
include('includes/footer.php');
?>
   