<?php
//Check that user is an admin and referer is legit before hiding posts --pls change string if url changes
session_start();

if($_SESSION['jUser']['role']!=1
|| $_SERVER['HTTP_REFERER']!=='http://localhost:8888/security/Web%20Security%20Project/keabook/home.php'){
  echo '{"status":0, "message":"Message could not be deleted"}';
  exit;
}

require_once '../database.php';

try{

  $sQuery = $db->prepare('  UPDATE posts
                            SET active = 0
                            WHERE id = :sPostId
                        '); 
  $sQuery->bindValue(':sPostId', $_POST['sPostId']);
  $sQuery->execute();

  if( $sQuery->rowCount() ){
    echo '{"status":1, "message":"Message deleted"}';
    exit;
  }  

  echo '{"status":0, "message":"Message could not be deleted"}';
  
}catch(PDOException $ex){
  echo '{"status":0,"message":"Message could not be deleted","code":"1001"}';
}