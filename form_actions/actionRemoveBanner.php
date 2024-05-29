<?php

include '../domain/init.php';

if (UserDBConnector::checkLogIn() === false)
    header('location: index.php');

$username = UserDBConnector::getUserNameById($_SESSION['user_id']);

$user = UserDBConnector::getData($_SESSION['user_id']);

$currentCover = $user->imgCover;

if ($currentCover !== 'cover.png')
    unlink('../resources/images/users/' . $currentCover);


$data = [
    'imgCover' => 'cover.png',
];

$sign = UserDBConnector::update('users', $_SESSION['user_id'], $data);


if ($sign == true) {
    header('location: ../' . $username);
} else header('location: ../' . $username);


?>