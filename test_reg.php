<?php

include "initialize.php";

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>Student registrering</title>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    
<?php
//=been submitted
if(empty($_POST) === false){
    
   $err = array();
    
   $req_fields = array('class_select','username','password','re_password','first_name','last_name','email');
    
    //in_array — Checks if a value exists in an array
    foreach($_POST as $key=>$value){
        if(empty($value) && in_array($key, $req_fields)=== true){
        $err[] = 'Fält med en asterix måste fyllas i';
            //break out of the loop and cont. with execution
            //if one error exists= break out
            break 1;
        }
            if(empty($err)=== true){
            if(user_exists ($_POST['username'])===true){
                $err[] = 'Användarnamnet \''. $_POST['username']. '\' är upptaget.';
            }
            //checking for SPACES /\\s/
            if(preg_match("/\\s/", $_POST['username'])== true){
                $err[] = "Användarnamnet får inte innehålla några mellanrum eller semikolon";
            }
            if(strlen($_POST['password']) < 6){
            
            $err[]= 'Lösenordet måste innehålla 6 karaktärer';
        } 
            if($_POST['password'] !== $_POST['re_password']){
            
                $err[]='Lösenorden matchar inte varandra';
            }
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
            
                $err[]= 'Ogiltig email';
            }
            if(email_exists($_POST['email']) === true){
                
            $err[] = 'E-mail adressen \''. $_POST['email']. '\' är upptagen.';
            }
        }
    }
}

if(isset($_GET['success']) && empty($_GET['success'])){
    
        echo "<strong>You have been registered!</strong><br>Please check your e-mail for activation <br><form method='post' action='test_index.php'><input type='submit' name='back' value='Tillbaka'>";
} else {

    if (empty($_POST) === false && empty($err) === true){
      
        $reg_data = array(
 
                 'class_select' => $_POST['class_select'],
                 'username'     => $_POST['username'],
                 'password'     => $_POST['password'],
                 'first_name'   => $_POST['first_name'],
                 'last_name'    => $_POST['last_name'],
                 'email'        => $_POST['email'],
                 'email_code'   => sha1($_POST['username'] + microtime())
                );

    
        reg_user($reg_data);

        echo "<meta http-equiv=\"refresh\" content=\"0;URL=test_reg.php?success\">";
        exit();

    }else if (empty($err) === false) {
         
       echo errors($err)."</br></br></br>";
    }


?>
    
<div id="formWrapper">     
<div class="form">   
    <form action="" method="post">
        <ul>
           
              <li>

            <select name="class_select">
            <option disabled selected>Välj klass</option>    
            <option value="1">Webbutvecklare</option>
            <option value="2">Projektledare</option>   
            <option value="3">Cobolprogrammerare</option> 
            <option value="4">IT-testare</option>   
            </select>
            </li> 
            <li>
            <input type="text" name="username" placeholder="Användarnamn*">    
            </li>  
            <li>
                <input type="password" name="password" placeholder="Lösenord*">
                </li> 
               <li>
                <input type="password" name="re_password" placeholder="Upprepa lösenord*">
            </li>
               <li>
                   <input type="text" name="first_name" placeholder="Förnamn*">
                </li>
            <li>
                   <input type="text" name="last_name" placeholder="Efternamn*">
                </li>
            <li>
                   <input type="text" name="email" placeholder="E-Mail*">
                </li>
            <li>
                   <input type="submit" class="submit" name="submit" value="Registera">
                     <a href="test_index.php" class="reg_button"> Tillbaka</a>
                </li>
                  
        </ul>
    </form>
    </div>
  

            
        <?php

}
?>
    
    </div>
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
</body>
</html>
