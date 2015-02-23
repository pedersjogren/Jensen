<?php
session_start();

//LÄGG IN E_ALL om du vill se alla fel
error_reporting();
//included in any file that we are using more or less
require 'includes/test_connect.php';
require 'includes/test_functions.php';

//grabbing all the data that i might use on the site at any point
//init is included everywhere

if(logged_in()===true){
    //session from login
    $session_user_id= $_SESSION['id'];
    //OBS om du vill ändra nåt yp klass för in det här
    $user_data= user_data($session_user_id,'id','class_select','username','password','first_name','last_name','email','type');
  
  //like dis
 //echo $user_data['username']; 
    
    //kick out user by deactivating account
    if(user_active($user_data['username'])===false){
        
        session_destroy();
        header('Location: test_index.php');
        exit();
    }

}

$err=array();
global $location;
global $teacher_location;
$location =  'uploads/';
$teacher_location='teacher_uploads/';
?>