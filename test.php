<?php 
$host = "localhost";
$username = "root";
$pass = "";
$db = "lr";   //Min lokala databas heter test. byt namn till namet på din databas


$conn = new mysqli($host, $username, $pass, $db);

if( $conn -> connect_error){

    echo "Something went wrong";
}else{

    echo "Connected to server";
}


//*----------------------------------------------//


/* cleanInput -> Basic protection for XSS (http://en.wikipedia.org/wiki/Cross-site_scripting)
*----------------------------------------------
*/



//----------säkerhet in i db----------------------------------------------------------//


function clean_input($input) {

    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );

    $output = preg_replace($search, '', $input);
    echo mysql_real_escape_string($output); 
    return ($output);
}










//----------General functions----------------------------------------------------------//



function email($to, $subject, $body){
 mail($to, $subject, $body, 'From: Admin@jensen.se');
}

//mini för att inte hamna på register, incl. on any page i //wanna protect against
function logged_in_redirect(){
    if(logged_in() === true){
    header('Location: index.php');
    exit();    
    }
}


function protect_page(){
    if(logged_in() === false){
    header('Location: protected.php');
    exit();
}
}

function admin_protect(){
    global $user_data;
    //== becouse were grabbing data and returning as a string?
    if($user_data['type'] == 0){
    header('Location: index.php');
    exit();    
    }
}






//----------skriver ut ett fel-array----------------------------------------------------------//


function errors($err){
    global $conn;
    return '<ul><li>' .implode('</li><li>',$err). '</li></ul>';
}





//----------kontroll av användare i db----------------------------------------------------------//


function user_exists($username){
    global $conn;

    $username=clean_input($username);

    $sql = "SELECT COUNT(`id`) FROM `users` WHERE `username` = '".$username."';";

    $result = $conn->query($sql);
    $row = $result->fetch_row();

    if($row[0]) {
        return true;
    } else {

        return  false;
    }
}





//----------kontroll av email i db----------------------------------------------------------//


function email_exists($email){
    global $conn;

      $email=clean_input($email);
  
      
      $sql = "SELECT COUNT(`id`)FROM `users` WHERE `email` = '".$email."'; ";
      
      $result = $conn->query($sql);
      $row = $result->fetch_row();
      
      if($row[0]){
        return true;
      }else{
        return false;
      }
}




//----------Kollar id från användare----------------------------------------------------------//


function id_from_username($username){
    global $conn;

    $username=clean_input($username);
   
    $sql = "SELECT `id` FROM `users` WHERE `username` = '".$username."';";

    $result = $conn->query($sql);
    $row = $result->fetch_row();

    if($row[0]) {
        return $row[0];
    } else {

        return 0;
    }
}



//----------Registrerar användare i db----------------------------------------------------------//

function reg_user($reg_data){
    
 global $conn;
//walk trough every element of an array and apply something //(sanitize) to it and return it if required
    array_walk($reg_data, 'clean_input');  
    
    $reg_data['password'] =  sha1($reg_data['password']);
    
    //fields is surounded by backticks, array keys gives us the keys
    $data_fields = '`' . implode('`, `', array_keys($reg_data)) . '`';
    //data is surrounded by single quotes
    $data = '\'' . implode('\', \'', $reg_data) . '\'';
  
    //create user
    
    $sql="INSERT INTO `users` ($data_fields) VALUES ($data)";
    
        $conn->query($sql);
        

    
    // send an email to users written email 
    // ""=format a new line \n\n= new line
   
    mail($reg_data['email'],' Aktivering av konto', "Hej ".$reg_data['first_name']. "!\n\nDu har registrerat dig som student hos Jensen. Om du har behörighet kommer du inom kort att bli auktoriserad av en admin. Använd länken nedanför för att följa din utveckling:\n\nhttp://localhost/jensen/activate.php?email=" .$reg_data['email']. "&email_code=" .$reg_data['email_code']. "\n\n - noreply@jensen
    ");
    
}


//----------User active i db----------------------------------------------------------//


function user_active($username){
    
    global $conn;
    
    $username = clean_input($username);

    
    $sql= "SELECT COUNT(`id`)FROM `users` WHERE `username` = '".$username."' AND `active`= 1";
    
    $result = $conn->query($sql);
    $row = $result->fetch_row();
       
       if($row[0]) {
           
        return $row[0];
        return true;
    } else {

        return  false;
    }
}


//----------USERDATA----------------------------------------------------------//

function user_data($id) {
    
    global $conn;
    $data = array();
    $id = (int)$id;
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    if ($func_num_args > 1) {
        unset($func_get_args[0]);
        $fields = '' . implode(', ', $func_get_args) . '';
        $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT $fields FROM users WHERE id = $id"));
        return $data;
    }
}
  
/*
function user_data($id) {
    
    global $conn;
    $data = array();
    $user_id = (int)$id;
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    if ($func_num_args > 1) {
        unset($func_get_args[0]);
        $fields = '' . implode(', ', $func_get_args) . '';
        
   $sql = "SELECT $fields FROM users WHERE id = $id";
       
    $result = $conn->query($sql);
    
        return $result;
}
}
*/
//----------TEST-DEL----------------------------------------------------------//


echo "<br/>TEST USERNAME 'admin' that EXISTS in db:";
echo user_exists('admin') ? "Yepp" : "Nope";
echo "<br/>TEST USERNAME ID:";
echo id_from_username('admin') ? id_from_username('admin') : "USER NOT FOUND";

echo "<br/>TEST USERNAME 'grisen' that NOT EXIST in db:";
echo user_exists('grisen') ? "Yepp" : "Nope";
echo "<br/>TEST USERNAME ID:";
echo id_from_username('grisen') ? id_from_username('grisen') : "USER NOT FOUND";
    
    
echo "<br/>TEST EMAIL_EXISTS 'admin' that EXISTS in db:";
echo user_exists('admin') ? "Yepp" : "Nope";    
echo "<br/>TEST EMAIL_EXISTS 'grisen' that NOT EXIST in db:";
echo email_exists('pedurrr.sjogren@gmail.com') ? "Yepp" : "Nope";  
    
echo "<br/>TEST USER_ACTIVE 'admin' that is ACTIVE in db:";
echo user_active('admin') ? "Yepp" : "Nope";    
echo "<br/>TEST USER_ACTIVE 'fgsfgfgfsgsgd' that IS NOT ACTIVE in db:";
echo user_active('fgsfgfgfsgsgd') ? "Yepp" : "Nope"; 


echo "<br/>TEST USER_DATA  that is  in db:";
echo user_data('first_name');  
echo "<br/>TEST USER_data '100' that IS NOT in db:";
echo  user_data('username');


echo "<br/>TEST FOR register(data)";
echo "<br/>".$_POST['class_select'];
echo "<br/>".$_POST['username'];
echo "<br/>".$_POST['password'];
echo "<br/>".$_POST['first_name'];
echo "<br/>".$_POST['last_name'];
echo "<br/>".$_POST['email'];



//--------------------------------------------------------------------//





//----------registrering----------------------------------------------------------//





//=been submitted
if(empty($_POST) === false){
    
   $err = array();
    
   $req_fields = array('class_select','username','password','password_again','firstname','email');
    
    //in_array — Checks if a value exists in an array
    foreach($_POST as $key=>$value){
        if(empty($value) && in_array($key, $req_fields)=== true){
        $err[] = 'Fields with an asterix must be filled are required';
            //break out of the loop and cont. with execution
            //if one error exists= break out
            break 1;
        }
            if(empty($errors)=== true){
            if(user_exists ($_POST['username'])===true){
                $err[] = 'Sorry, the username \''. $_POST['username']. '\' is already taken.';
            }
            //checking for SPACES /\\s/
            if(preg_match("/\\s/", $_POST['username'])== true){
                $err[] = "The username must not contain any spaces";
            }
            if(strlen($_POST['password']) < 6){
            
            $err[]= 'The password must be at least 6 characters';
        } 
            if($_POST['password'] !== $_POST['password_again']){
            
                $err[]='Your passwords do not match';
            }
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
            
                $err[]= 'Ogiltig e-postaddress';
            }
            if(email_exists($_POST['email']) === true){
                
            $err[] = 'Sorry, the email \''. $_POST['email']. '\' is already taken.';
            }
        }
    }
}

?>
    <h1>Registrera dig som student</h1>

<?php
//reg form(part 5)         
                            //? not necessary
if(isset($_GET['success']) && empty($_GET['success'])){
    
        echo '<strong>You have been registered!</strong><br>Please check your e-mail for activation ';
} else {

    if (empty($_POST) === false && empty($errors) === true){
      
        $reg_data = array(
 
                 'class_select' => $_POST['class_select'],
                 'username'     => $_POST['username'],
                 'password'     => $_POST['password'],
                 'first_name'   => $_POST['first_name'],
                 'last_name'    => $_POST['last_name'],
                 'email'        => $_POST['email'],
            //for email activation , it will take username and append it to microtime()
                 'email_code'   => sha1($_POST['username'] + microtime())
                );

    
        reg_user($reg_data);

        //echo "<meta http-equiv=\"refresh\" content=\"0;URL=register.php?success\">";
        //exit();

    }else if (empty($err) === false) {
         
        echo errors($err);
    }


?>

<!DOCTYPE html>
<html lang="">
<head></head>
  
<body>
    <form action="" method="post">
        <ul>
              <li>Klass*:<br>

            <select name="class_select">
            <option value="" disabled selected>Välj klass:</option>    
            <option value="0">Webbutvecklare</option>
            <option value="1">Projektledare</option>   
            <option value="2">Cobolprogrammerare</option> 
            <option value="3">IT-testare</option>   
            </select>
            </li> 
            <li>Användarnamn*:<br>
            <input type="text" name="username">    
            </li>  
            <li>Lösenord*:<br>
                <input type="password" name="password">
                </li> 
               <li>Lösenord*:<br>
                <input type="password" name="password_again">
            </li>
               <li>Förnamn*:<br>
                   <input type="text" name="first_name">
                </li>
            <li>Efternamn:<br>
                   <input type="text" name="last_name">
                </li>
            <li>Email*:<br>
                   <input type="text" name="email">
                </li>
            <li>
                   <input type="submit" value="Registera">
                </li>
        </ul>
    </form>

    </body>
        
    </html>
<?php 
}

?>