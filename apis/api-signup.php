<?php

//validate
if( empty($_POST['txtName']) ||
      empty($_POST['txtLastName']) ||
      empty($_POST['txtEmail']) ||
      empty($_POST['txtPassword']) ||
      empty($_POST['txtPasswordConfirm']) ||
      !(strlen($_POST['txtName']) >= 2 && strlen($_POST['txtName']) <= 20) ||
      !(strlen($_POST['txtLastName']) >= 2 && strlen($_POST['txtLastName']) <= 20) ||
      !filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL) ||
      !(strlen($_POST['txtPassword']) >= 8 && strlen($_POST['txtPassword']) <= 20) ||
      !(preg_match('@[A-Z]@', $_POST['txtPassword'])) ||
      !(preg_match('@[a-z]@', $_POST['txtPassword'])) ||
      !(preg_match('@[0-9]@', $_POST['txtPassword'])) ||
      !($_POST['txtPassword'] == $_POST['txtPasswordConfirm'])
  ){
    echo '{"status":0, "message":"Invalid form"}';
    exit;
  }

  require_once '../database.php';
  try{
    //hashing pattern:
    $salt = rand(100000, 999999);
    $peber = "MySecret";
    $options = ['cost' => 12];
    //PASSWORD_DEFAULT - uses bcrypt algorithm - designed to change over time so the length of the result might change over time - DB column should have at least 60 characters
    $pw_hash = password_hash($_POST['txtPassword'].$peber.$salt, PASSWORD_DEFAULT, $options);

    $sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);

    $sQuery = $db->prepare('INSERT INTO users
                            VALUES (null, :sName, :sLastName, 
                            :sEmail, :sPassword, :sSalt, :sActivationKey, :bActive, :bRole)');

    $sQuery->bindValue(':sName', $_POST['txtName']);
    $sQuery->bindValue(':sLastName', $_POST['txtLastName']);
    $sQuery->bindValue(':sEmail', $_POST['txtEmail']);
    $sQuery->bindValue(':sPassword', $pw_hash);
    $sQuery->bindValue(':sSalt', $salt);
    $sQuery->bindValue(':bActive', 0);
    $sQuery->bindValue(':bRole', 0);
    $sQuery->bindValue(':sActivationKey', $sActivationKey);
    $sQuery->execute();
    if( $sQuery->rowCount() ){
      echo '{"status":1, "message":"success"}';
      exit;
    }
    echo '{"status":0, "message":"Cannot sign you up"}';
  }catch( PDOException $e ){
    echo '{"status":0, "message":"Existing e-mail", "code":"001", "line":'.__LINE__.'}';
  }