<?php

  // Check if user is logged
  session_start();
  if($_SESSION['jUser']){
    header('Location: home.php');
  }

  $sTitle = 'keabook : : login';
  $sCss = 'login.css';
  require_once './components/top.php';
?>

<div class="container">

  <div class="top">
    keabook
  </div>

  <div class="content">
    <form id="frmLogin">
      <h1>Log in</h1>

      <div class="boxInput">
        <div id="invalidEmail" class="invalid">invalid email</div>
        <input id="txtEmail" name="txtEmail" class="mt10" type="text" value="a@a.com" placeholder="e-mail">
      </div>
      
      <div class="boxInput">
      <div id="invalidPassword" class="invalid">invalid password</div>
        <input id="txtPassword" name="txtPassword" class="mt10" type="password" value="notApassw0rd" placeholder="password" maxlength="20">
      </div>
      
      <button id="btnLogin" type="submit" class="ok mt10">login</button>
      <p class="mt20"><a href="signup.php">Or sign up</a></p>
    </form>
    
  </div>

</div>

<?php
  $sScript = 'login.js';
  require_once './components/bottom.php';