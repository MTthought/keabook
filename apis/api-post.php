<?php
session_start();
//if msg or file inputs are not empty and token is legit, post is inserted
if(isset($_POST['sToken']) && password_verify($_SESSION['csrfToken'], $_POST['sToken']) 
&& (!empty($_POST['txtMessage']) || $_FILES['imgFile']['size'] != 0)){

  //htmlentities prevent xss by converting all applicable characters to HTML entities
  $sMessage = htmlentities($_POST['txtMessage']);
  $sImage = $_FILES['imgFile']['name'];
  $sDate = date("Y-m-d H:i:s");
  $sUserId = $_SESSION['jUser']['id'];

  //If an image is uploaded, restrict the file size + extension and save in img folder
  if(isset($_FILES['imgFile']) && $_FILES['imgFile']['size'] != 0 && $_FILES['imgFile']['size'] < 4000000){
    // separate img name from extension
    $aImageName = explode( '.' , $sImage ); // logo.svg ['logo','svg']
    // get extension knowing that the last element is the extension
    $sExtension = $aImageName[count($aImageName)-1];
    // whitelist PNG JPG JPEG
    $bCorrectExtension = false;
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPG', 'JPEG', 'GIF'];
    for($j = 0; $j < sizeof($allowedExtensions)-1; $j++){
        if($allowedExtensions[$j] == $sExtension){
            $bCorrectExtension = true;
        }
    }
    if($bCorrectExtension == false){
      echo '{"status":0, "message":"Wrong file extension"}';
      exit;
    }
    //change the name to avoid name overlaps
    $sImage = uniqid().'.'.$sExtension;
    move_uploaded_file($_FILES['imgFile']['tmp_name'], '../img/'.$sImage);
  }else if($_FILES['imgFile']['size'] >= 4000000){
    echo '{"status":0, "message":"File size is too big"}';
    exit;
  }
  
    require_once '../database.php';
    try{
      $sQuery = $db->prepare('INSERT INTO posts
                              VALUES (null, :sMessage, :sImage, :sDate, 
                              :sUserId, :bActive)');
  
      $sQuery->bindValue(':sMessage', $sMessage);
      $sQuery->bindValue(':sImage', $sImage);
      $sQuery->bindValue(':sDate', $sDate);
      $sQuery->bindValue(':sUserId', $sUserId);
      $sQuery->bindValue(':bActive', 1);
      $sQuery->execute();
      if( $sQuery->rowCount() ){
        echo '{"status":1, "message":"success"}';
        exit;
      }
      echo '{"status":0, "message":"error"}';
    }catch( PDOException $e ){
        var_dump ($e);
      echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
    }
  
 }