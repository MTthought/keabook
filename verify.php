<?php
  $sTitle = 'keabook : : verify account';
  $sCss = 'verify.css';
  require_once './components/top.php';
?>

<div class="container">

  <div class="top">
    keabook
  </div>

  <div class="content">
  <div class="msgbox">
  <h2>Thanks for signing up</h2>
  <p class="mt10">We sent you an e-mail with a key to activate your account.</p>
  </div>

    <form id="frmVerify">
      <h1>Verify your account</h1>
      <input name="key" class="mt20" type="text" placeholder="Type the key here">
      <button id="btnVerify" type="submit" class="ok mt10">verify</button>
    </form>
  </div>

</div>

<?php
  $sScript = 'verify.js';
  require_once './components/bottom.php';