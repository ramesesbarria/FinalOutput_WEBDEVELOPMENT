<?php 
include '../domain/init.php';
require_once '../domain/classes/model/Validator.php';
use model\Validator;


    
    

   if (isset($_POST['login']) && !empty($_POST['login'])) {
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(!empty($email) && !empty($password)) {
        $email = UserDBConnector::checkInput($email);
        $password = UserDBConnector::checkInput($password);
       } 
       
          

        $v = new Validator; 
        $v->rules('email' , $email , ['required' , 'email']);
        $v->rules('password' , $password , ['required' , 'string']);
        $errors = $v->errors;
        if($errors == []) {
            UserDBConnector::login($email , $password);
         if(UserDBConnector::login($email , $password) === false ) {
          // $errors = 'the email or password is not correct';/
           $_SESSION['errors'] = ['the email or password is not correct'];
           header('location: ../index.php')  ;
         }

        } else {
          $_SESSION['errors'] = $errors;
          header('location: ../index.php')  ;
        }


        
            

   } else  header('location: ../index.php')  ;




?>