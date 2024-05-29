<?php 

include '../domain/init.php';
require_once '../domain/database/model/Validator.php';

use model\Validator;

if (UserDBConnector::checkLogIn() === false)
header('location: index.php');  


$user =UserDBConnector::getData($_SESSION['user_id']);

if (isset($_POST['submit'])) {

    $email =  UserDBConnector::checkInput($_POST['email']) ;
    $username =   UserDBConnector::checkInput($_POST['username']);

    $v = new Validator; 
    $v->rules('username' , $username , ['required' , 'string' , 'max:20']);
    $v->rules('email' , $email , ['required' , 'email']);
    $errors = $v->errors;

    if ($errors == []) {
        
        if(UserDBConnector::checkEmail($email) === true && $email != $user->email) {
            $_SESSION['errors_account'] = ['This email is already use'];
            header('location: ../settings.php')  ;
        } else if (UserDBConnector::checkUserName($username) === true && $username != $user->username) {
            $_SESSION['errors_account'] = ['This username is already use'];
            header('location: ../settings.php')  ;
        } else if (preg_match("/[^a-zA-Z0-9\!]/" , $username)) {
            $_SESSION['errors_account'] = ['Only Chars and Numbers allowed in username'];
            header('location: ../settings.php')  ;
        } else {
        $data = [
            'email' => $email ,
            'username' => $username
        ];

        $sign= UserDBConnector::update('users' , $_SESSION['user_id'], $data);
        header('location: ../settings.php')  ;
    }

    } else {
       
        $_SESSION['errors_account'] = $errors;  
        header('location: ../settings.php');

    }
    

} else header('location: ../home.php');

?>