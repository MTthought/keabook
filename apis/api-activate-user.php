<?php

//validation - length of the key is minimum 60 chars and referrer is legit
if(empty($_POST['key'])||
!(strlen($_POST['key']) >= 60 && strlen($_POST['key']) <= 255)||
$_SERVER['HTTP_REFERER']!=='http://localhost:8888/security/Web%20Security%20Project/keabook/verify.php'){
  echo '{"status":0,"message":"Invalid key"}';
  exit;
}

require_once '../database.php';

try{

  $sQuery = $db->prepare('  UPDATE users
                            SET active = 1
                            WHERE activation_key = :sKey
                        '); 
  $sQuery->bindValue(':sKey', $_POST['key']);
  $sQuery->execute();

  if( $sQuery->rowCount() ){
    echo '{"status":1, "message":"You are activated"}';
    exit;
  }  

  echo '{"status":0, "message":"You could not be activated"}';
  
}catch(PDOException $ex){
  echo '{"status":0,"message":"Cannot activate user"}';
}