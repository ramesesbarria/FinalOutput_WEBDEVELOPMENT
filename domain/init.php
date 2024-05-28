<?php

include 'classes/DBConnector.php';
include 'classes/UserDBConnector.php';
include 'classes/FollowDBConnector.php';
include 'classes/PostDBConnector.php';

session_start();
 
global $pdo;

define("BASE_URL" , "http://localhost/twitter/");



