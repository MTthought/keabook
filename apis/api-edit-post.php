<?php
//if input field is not empty and referer is legit, 
//database checks if it's the right user and updates message and date. Date updates on database
if(empty($_POST['sPostMsg']) 
|| $_SERVER['HTTP_REFERER']!=='http://localhost:8888/security/Web%20Security%20Project/keabook/home.php'){
  echo '{"status":0, "message":"Message could not be edited"}';
  exit;
}

session_start();

require_once '../database.php';

try{
  $sQuery = $db->prepare('  UPDATE posts
                            SET message = :sMessage
                            WHERE id = :sPostId
                            AND user_id = :sUserId
                        ');
  $sQuery->bindValue(':sMessage', $_POST['sPostMsg']);
  $sQuery->bindValue(':sPostId', $_POST['sPostId']);
  $sQuery->bindValue(':sUserId', $_SESSION['jUser']['id']);
  $sQuery->execute();

  if( $sQuery->rowCount() ){
    echo '{"status":1, "message":"Message edited"}';
    exit;
  }  

  echo '{"status":0, "message":"Message could not be edited"}';
  
}catch(PDOException $ex){
  echo '{"status":0,"message":"Message could not be edited","code":"1001"}';
}