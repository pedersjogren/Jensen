<?php
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
    return ($output);
}










//----------General functions----------------------------------------------------------//



function email($to, $subject, $body){
 mail($to, $subject, $body, 'From: Admin@jensen.se');
}

//mini för att inte hamna på register, incl. on any page i //wanna protect against
function logged_in_redirect(){
    if(logged_in() === true){
    header('Location: main.php');
    exit();    
    }
}


function page_protect(){
    if(logged_in() === false){
    header('Location: test_index.php');
    exit();
}
}

function auth_protect(){
    global $user_data;
    //== becouse were grabbing data and returning as a string?
    if($user_data['type'] == 0){
    header('Location: main.php');
    exit();    
    }
}

//----------skriver ut ett fel-array----------------------------------------------------------//


function errors($err){
    global $conn;
    return "<div class='main-content' style='color:red;'><ul><li>".implode('</li><li>',$err). "</li></ul></div>";
}





//----------kontroll av användare i db----------------------------------------------------------//
function change_password($id, $password){
    
    global $conn;
    $id = (int)$id;
    $password= sha1($password);
    //no single quotes around numbers
    $sql = "UPDATE `users` SET `password` = '".$password."' WHERE `id`= '".$id."';";
        
   $conn->query($sql);
   
}

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
//----------ADMIN----------------------------------------------------------//
/*se till att den berörda personen får ett mail
*/


function delete_user($id){
   global $conn;

    $sql = "UPDATE `users` SET `active` = 0 WHERE `id`= ".$id;
    
    $conn->query($sql);
}

function activate_user($id){
    global $conn;
    
    $sql = "UPDATE `users` SET `active` = 1 WHERE `id`= ".$id;
    
    $conn->query($sql);
}


function activate_class_count(){
    global $conn;    
    
$sql = "select * from `users` WHERE `active` = 0";
   
$result = $conn->query($sql);    
while ($row = mysqli_fetch_object($result)) {
    
echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email. "' style='color:#A17890;'>" .$row ->email. "</a></td></tr><tr><th scope='row'><form method='post' action='admin.php'><input type='submit'name='submit'value='aktivera student'><input type='hidden' name='uid' value='".$row->id."'/><input type='hidden' name='activateuser' value='true'/></form></th></tr>"; 
 /*   
mail($row->email,' Aktivering av konto', "Hej ".$row->first_name. "!\n\nDu har registrerat dig som student hos Jensen. Du har blivit auktoriserad av en admin och kan nu logga in Använd länken nedanför för att fullfölja registreringen:\n\nhttp://localhost/jensen/activate.php?email=" .$row->email. "&email_code=" .$row->email_code. "\n\n - noreply@jensen
    ");
    */
    
}
mysqli_free_result($result);    #FA5064
}


function delete_class_count(){
    global $conn; 
    
    $sql = "select * from `users` WHERE `active` = 1";
    $result = $conn->query($sql);
while ($row = mysqli_fetch_object($result)) {
     
echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email. "' style='color:#78A189;'>" .$row ->email. "</a></td></tr><tr><th scope='row'><form method='post' action='admin.php'><input type='submit'name='submit'value='Deaktivera student'><input type='hidden' name='uid' value='".$row->id."'/><input type='hidden' name='deleteuser' value='true'/></form></th></tr>"; 
  
}
mysqli_free_result($result);
    
}
/*
<table><thead><tr><th scope='col'>Mottagna filer:</th></tr></thead><tfoot><tr><td colspan='3' style='color:#7879A1;'>Från: Lärare</td></tr></tfoot>    <tbody><tr><th scope='row'><li><a href='".$location.$studentid."/".$entry."'style='color:#3933DE;' target='_blank'>".$entry."</a></li></th></tr></tbody></table>"
*/
//----------class count----------------------------------------------------------//

function class_count_wuk(){
   global $conn;    

$sql = "select * from `users` WHERE `class_select` = 1 AND `active` = 1";
    
    $result = $conn->query($sql);
    
    while($row = mysqli_fetch_object($result)){
    echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email."' style='color:#78A189;'>".$row ->email."</a></td></tr>"; 

    }
}

function class_count_pro(){
   global $conn;    
    $sql = "select * from `users` WHERE `class_select` = 2 AND `active` = 1";
    $result = $conn->query($sql);
  
     while($row = mysqli_fetch_object($result)){
    echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email."' style='color:#78A189;'>".$row ->email."</a></td></tr>";   
    }
}

function class_count_cob(){
   global $conn;    
$sql = "select * from `users` WHERE `class_select` = 3 AND `active` = 1";
    $result = $conn->query($sql);
 
    while($row = mysqli_fetch_object($result)){
    echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email."' style='color:#78A189;'>".$row ->email."</a></td></tr>";   
    }
}

function class_count_it(){
   global $conn;    
$sql = "select * from `users` WHERE `class_select` = 4 AND `active` = 1";
    $result = $conn->query($sql);
    
    while($row = mysqli_fetch_object($result)){
    echo "<tr><th scope='row'>".$row->first_name."</th><td> ".$row->last_name."</td><td><a href=mailto:".$row ->email."' style='color:#78A189;'>".$row ->email."</a></td></tr>";    
    }
}
function student_list(){
   global $conn;    
$sql = "select * from `users` WHERE `active` = 1";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_object($result)){
    echo "<option value='".$row->id."'>".$row->first_name." ".$row->last_name."</option>";    
    }
}

function teacher_list(){
   global $conn;    
$sql = "select * from `users` WHERE `active` = 1 AND `type` = 2";
    $result = $conn->query($sql);
    while($row = mysqli_fetch_object($result)){
    echo "<option value='".$row->id."'>".$row->first_name." ".$row->last_name."</option>";    
    }
}


/*
function user_exists($username){
	//Make $con work in the function
	global $conn;
	
	//Sanitize $nick
	$username = clean_input($username);
	
	//Perform query
	$result = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` = '{$username}'");
	
	//Does it show anything? Then the user exists, else return false
	return (mysqli_num_rows($result) > 0 ? true : false);
}
*/

    //everything in()=if statement. anything after ? will //be returned if true and anything after: = reuturned if //false
    //passing the query and the row. Is the result equal to 1

//----------kontroll av om user är satt till active i db0 ----------------------------------------------------------//

function user_active($username){
    
    global $conn;
    
    $username = clean_input($username);

    
    $sql= "SELECT COUNT(`id`)FROM `users` WHERE `username` = '".$username."' AND `active`= 1";
    
    $result = $conn->query($sql);
    $row = $result->fetch_row();
       
       if($row[0]) {
           
        return $row[0];
        //return true;
    } else {

        return  false;
    }
}
/*
function user_active($username){
    
    global $conn;
    
    $username = clean_input($username);

    
    $sql= "SELECT COUNT(`id`)FROM `users` WHERE `username` = '".$username."' AND `active`= 1";
    
    $result = $conn->query($sql);
    $row = $result->fetch_array();
       
       if($row['username']==$username && $row['active'] == 1) {
        
        echo "Welcome. $username!";      
        //return $row[0];
        return true;
    } else {
         echo " Your username and password could not be verified. ";
        return  false;
    }
}
*/
//----------Login-fel----------------------------------------------------------//
/*
function login($username,$password){
    
    global $conn;
    
    $id= id_from_username($username);

    $username = clean_input($username);
    $password = sha1($password);
    
   
    
   
        $sql= "SELECT COUNT(`id`) FROM `users` WHERE `username` = '".$username."' AND `password`='".$password."';";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
       
       if($row['username']==$username && $row['password'] == $password) {
            
        return $id;
        
    } else {

        return  false;
    }
  
    
}
 */
function login($username, $password) { //Hämtar användareID från databas
        global $conn;
    
        $id= id_from_username($username);
    //encrypt password
        $username = clean_input($username);
        $password = sha1($password);
        
        $sql= "SELECT `id` FROM `users` WHERE `username` = '".$username."' AND `password`='".$password."';";
        
        $result = $conn->query($sql);
        $row = $result->fetch_row();//ASSOC
        
        if ($row) {
      
            return $id;
            
        } else {
            
        
            return false;
        
        }
   
    }

//-----------------------------fel---------------------------------------//

   
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
        
   $data = "SELECT $fields FROM users WHERE id = $id";
 
      $result = $conn->query($data);
     $row = $result->fetch_assoc();    
    
        return $data;
}
}
/*
//original
function user_data($id){
    $data=array();
  //creating an integer from that input so no sql injection
    $id= (int) $id;
    
    //definierar två var som får argument från funktionen
    //räknar de inpassade argumenten
    $func_num_args = func_num_args();
   
    $func_get_args= func_get_args();
    //returnerar ett array of de argument som är inpassade i funktionen //function
   
    if($func_num_args > 1){
        unset($func_get_args[0]);
        
        //array koverterad till sträng
        $fields = '`' . implode('`, `', $func_get_args) . '`';
        
      $data = mysql_fetch_assoc( mysql_query("SELECT $fields FROM `users` WHERE `id`= $id"));
      
       return $data;
  }
     }
*/
//----------Logged in----------------------------------------------------------//

function logged_in(){
    
    
    return (isset($_SESSION['id'])) ? true : false;
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
/*

function id_from_username($username){
    global $conn;

    $username=clean_input($username);
   
    $sql = "SELECT `id` FROM `users` WHERE `username` = '".$username."';";

    $result = $conn->query($sql);
    $row = $result->fetch_row();

    if($row[0]) {
   
        return $id;
    } else {

        return 0;
    }
}
*/

//----orginal----//
/*
function id_from_username($username){
    $username=sanitize($username);
//false if the login is false otherwise if it is successfull we //return the id. we store it in a session
    return mysql_result(mysql_query("SELECT `id` FROM `users` WHERE `username` = '$username'"),0,'id'); 
}
*/
//----från test.php----//
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
   
    mail($reg_data['email'],' Aktivering av konto', "Hej ".$reg_data['first_name']. "!\n\nDu har registrerat dig som student hos Jensen. Om du har behörighet kommer du inom kort att bli auktoriserad av en admin. Logga in här:\n\nhttp://localhost/jensen/activate.php?email=" .$reg_data['email']. "&email_code=" .$reg_data['email_code']. "\n\n - noreply@jensen
    ");
    
}

?>