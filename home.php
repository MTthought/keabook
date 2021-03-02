<?php
// check if the user is logged
// not logged, take the user to the login page
session_start();
if( !$_SESSION['jUser'] ){
  header('Location: login.php');
  exit;
}

//set session timeout and hash token
$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
$sToken = password_hash($_SESSION['csrfToken'], PASSWORD_DEFAULT);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Security-Policy" content="script-src 'self' ajax.googleapis.com">
  <title>keabook : : home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" href="css/home.css">
</head>
<body>

<div class="container">

  <div class="top">
    <div id="logo">keabook</div>
    <div><a href="logout.php?token=<?php echo $sToken ?>">logout</a></div>
  </div>

  <div class="postbox">
    <form id="formMakePost" method="post" enctype="multipart/form-data">
    <input name="sToken" type="hidden" value="<?php echo $sToken ?>">
    <input name="imgFile" type="file">
    <input name="txtMessage" type="text" placeholder="what's on your mind">
    <button>post</button>
    </form>
  </div>

  <div id="allPostsBox" class="mt20"></div>
  
</div>

<?php
  if($_SESSION['jUser']['role']==1){
    $sScript = 'admin.js';
  }else{
    $sScript = 'home.js';
  }

  require_once './components/bottom.php';