<?php

include 'initialize.php';
logged_in_redirect();
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>Logga in</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/media.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>

<?php
if(isset($_POST['submit'])){
if(empty($_POST)===false){
    $username=$_POST['username'];
    $password=$_POST['password']; 
    
    if(empty($username)=== true||empty($password) === true){
      
        $err[]="Skriv ditt användarnamn och lösenord";
    }else if(user_exists($username) === false){
        $err[]="Vi kan inte hitta ditt användarnamn. Har du registrerat dig?";
    }else if(user_active($username) === false){
        $err[]="Du har inte blivit aktiverad än";
    }else{
        
        if(strlen($password) > 32){
          $err[] = "Lösenordet är för långt";  
        }
        
    //testing the login process
        $login = login($username, $password);
        
        if($login === false){
        $err[]= "Felaktig kombination av användarnamn/lösenord";
           }else{
     //ser the user session, which uniquely identifie us
    //redirect user wherever
    
    //=login becouse login returns the id    
       $_SESSION['id'] = $login;
        header("Location: main.php");
        exit();    
        }
     
    }
 
}else{
   $err[]="Ingen data mottagen";   
}
//logic at the top and the output here
 
 if(empty($err)===false){
 ?>
    
<?php
echo errors($err);     
 }
}
?>
   
    <div id="formWrapper">
        <div class="form">
            <form action="test_index.php" method="post">
                <ul>

                    <li>
                        <!--<label for="username">Användarnamn:</label>-->
                        <input type="text" id="username" name="username" placeholder="Användarnamn">
                    </li>

                    <li>
                        <!--<label for="password">Lösenord:</label>-->
                        <input type="password" id="password" name="password" placeholder="Lösenord">
                    </li>

                    <li>
                        <input type="submit" class="submit" name="submit" value="Logga in">
                        
                    </li>
                    
                    <li>
                       <a href="test_reg.php" class="reg_button">Registrera</a> 
                    </li>
                    

                </ul>
           </form>
        </div>
        
    </div>
    
<script src="script/jquery-1.7.1.min.js"></script>
<script src="script/effects.js"></script>
</body>  
</html>
