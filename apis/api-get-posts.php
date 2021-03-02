<?php

session_start();

require_once '../database.php';

try{
    $sQuery = $db->prepare('SELECT posts.id, posts.message, posts.image, posts.date, posts.user_id, users.name 
                            FROM posts INNER JOIN users ON posts.user_id = users.id
                            WHERE posts.active = 1');
    $sQuery->execute();
    $all = $sQuery->fetchAll();
    if( $sQuery->rowCount() ){

      foreach($all as $index => $post){
        if($_SESSION['jUser']['id'] == $all[$index]['user_id']){
          $all[$index]['user_id']='ok';
        }else{
          $all[$index]['user_id'] = 0;
        }
      }
 
      echo json_encode($all);
      exit;
    }
    echo '{"status":0, "message":"error"}';
  }catch( PDOException $e ){
    echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
  }