<?php

 $time = $_SERVER['REQUEST_TIME'];
 $expireAfter = 600; //in seconds = 10 mins

 session_start();

 if(($time - $_SESSION['LAST_ACTIVITY']) > $expireAfter){
   $sToken = password_hash($_SESSION['csrfToken'], PASSWORD_DEFAULT);
    echo json_encode($sToken);
    exit;    
 }
exit;