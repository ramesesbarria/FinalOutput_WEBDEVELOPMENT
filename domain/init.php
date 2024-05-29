<?php

include 'database/DBConnector.php';
include 'database/UserDBConnector.php';
include 'database/FollowDBConnector.php';
include 'database/PostDBConnector.php';

session_start();
 
global $pdo;

define("BASE_URL" , "http://localhost/twitter/");



