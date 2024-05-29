<?php 

include '../domain/init.php';
require_once '../domain/database/model/Validator.php';

use model\Validator;

if (UserDBConnector::checkLogIn() === false)
header('location: index.php');  


$user =UserDBConnector::getData($_SESSION['user_id']);
$username =  UserDBConnector::getUserNameById($_SESSION['user_id']);



if (isset($_POST['submit'])) {

    $old_password =  UserDBConnector::checkInput($_POST['old_password']) ;
    $new_password =  UserDBConnector::checkInput($_POST['new_password']) ;
    $ver_password =  UserDBConnector::checkInput($_POST['ver_password']) ;
    
    $v = new Validator; 
    $v->rules('New Password' , $new_password , ['required' , 'string' , 'min:5']);
    $errors = $v->errors;
    $old_password = md5($old_password);
    if ($old_password == $user->password) {

        if ($errors != []) {
            $_SESSION['errors_password'] = $errors ;
            header('location: ../settings.php')  ;
        } else if ($new_password != $ver_password) {
            $_SESSION['errors_password'] = ['The two passwords are not the same'] ;
            header('location: ../settings.php')  ;
        } else {
            $new_password = md5($new_password);
            $data = [
                'password' => $new_password ,
            ];
    
            $sign= UserDBConnector::update('users' , $_SESSION['user_id'], $data);
            header('location: ../' . $username);

        }

    } else { $_SESSION['errors_password'] = ['The old password is wrong'] ;
        header('location: ../settings.php')  ;
    }


} else {
    header('location: ../settings.php');
}