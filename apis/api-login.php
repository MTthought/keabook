<?php

//validate that input fields are not empty + email is valid + right password length containing upper, lower case and numbers
if( empty($_POST['txtEmail']) ||
    empty($_POST['txtPassword']) ||  
    !filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL) ||
    !(strlen($_POST['txtPassword']) >= 8 && strlen($_POST['txtPassword']) <= 20 ||
    !(preg_match('@[A-Z]@', $_POST['txtPassword'])) ||
    !(preg_match('@[a-z]@', $_POST['txtPassword'])) ||
    !(preg_match('@[0-9]@', $_POST['txtPassword'])) )
){
  echo '{"status":0, "message":"Invalid form"}';
  exit;
}

$peber = "MySecret";
//get the IP
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $currentIp = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $currentIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $currentIp = $_SERVER['REMOTE_ADDR'];
}

//connect to the database
require_once '../database.php';

//stop here if ip or user are blocked
try{
    $sQuery = $db->prepare('SELECT * FROM ips 
                            WHERE active = 0');
    $sQuery->bindValue(':sIp', $currentIp);
    $sQuery->execute();
    $aIps = $sQuery->fetchAll();
    if( count($aIps) ){
        foreach($aIps as $index){
            if($index['ip']==$currentIp || $index['email']==$_POST['txtEmail']){
                echo '{"status":2, "message":"Blocked user"}';
                exit;
            }
        }
    }
    //echo '{"status":0, "message":"user is not blocked"}';
  
  }catch(PDOException $exception){
    echo '{"status":0, "message":"ex"}';
  }

//check if user and password are correct
try{
  $sQuery = $db->prepare('SELECT * FROM users 
                          WHERE email = :txtEmail 
                          LIMIT 1');
  $sQuery->bindValue(':txtEmail', $_POST['txtEmail']);
  $sQuery->execute();
  $aUsers = $sQuery->fetchAll();

  //stop here if the account hasn't been verified
  if($aUsers[0]['active']==0){
    echo '{"status":2, "message":"Verify your account"}';
    exit;
  }
  
  if( count($aUsers) && password_verify($_POST['txtPassword'].$peber.$aUsers[0]['salt'], $aUsers[0]['password'])){
    ini_set("session.cookie_httponly", 1);
    //ini_set("session.gc_maxlifetime", '1');
    session_start();
    session_regenerate_id(1);
    $_SESSION['csrfToken'] = uniqid();
    $_SESSION['jUser'] = $aUsers[0];
  
        //If right credentials check if ip has attempts
        try{
            $sQuery = $db->prepare('SELECT attempts FROM ips 
                                    WHERE ip = :sIp 
                                    AND active = 1
                                    LIMIT 1');
            $sQuery->bindValue(':sIp', $currentIp);
            $sQuery->execute();
            $aAttempts = $sQuery->fetchAll();
  
            //Clear user attempts if any
            if( $aAttempts[0]['attempts']>=1 ){
                try{
                    $sQuery = $db->prepare('UPDATE ips SET attempts=:attempts 
                                            WHERE ip = :sIp 
                                            AND active = 1 
                                            LIMIT 1');
                    $sQuery->bindValue(':attempts', 0);
                    $sQuery->bindValue(':sIp', $currentIp);
                    $sQuery->execute();
                    //echo '{"status":0, "message":"updated attempts"}';
                    //exit;
                  }catch(PDOException $exception){
                    echo '{"status":0, "message":"cannot login"}';
                  }
          //exit;
            }
        }catch(PDOException $exception){
            echo '{"status":0, "message":"cannot login"}';
        }
        //End - If right credentials check if ip has attempts

      echo '{"status":1, "message":"login success"}';

      exit;
  }

  //echo '{"status":0, "message":"Incorrect user name or password"}';

}catch(PDOException $exception){
  echo '{"status":0, "message":"cannot login"}';
}

//If wrong credentials but ip is active, check if ip has attempts
  try{
      $sQuery = $db->prepare('SELECT attempts FROM ips 
                            WHERE ip = :sIp 
                            AND active = 1 LIMIT 1');
    $sQuery->bindValue(':sIp', $currentIp);
      $sQuery->execute();
      $aAttempts = $sQuery->fetchAll();
      if( count($aAttempts) ){
        session_start();
        $_SESSION['jFailedUser'] = $aAttempts[0];
        $iAttempts=$_SESSION['jFailedUser']['attempts'];
        echo '{"status":2, "message":"You have '.(3-$iAttempts).' tries left"}';

        //if 3 attempts, block ip
        if($iAttempts*1 >= 3){
            try{
              $sQuery = $db->prepare('UPDATE ips SET active=:blocked 
                                      WHERE ip = :sIp 
                                      AND active = 1 LIMIT 1');
              $sQuery->bindValue(':blocked', 0);
              $sQuery->bindValue(':sIp', $currentIp);
              $sQuery->execute();
              //echo '{"status":0, "message":"user blocked"}';
              exit;

            }catch(PDOException $exception){
              echo '{"status":0, "message":"cannot login"}';
            }
        }

      //If less than 3, add 1 attempt
              try{
                  $sQuery = $db->prepare('UPDATE ips SET attempts=:attempts 
                                          WHERE ip = :sIp 
                                          AND active = 1 LIMIT 1');
                  $sQuery->bindValue(':attempts', ($iAttempts*1)+1);
                  $sQuery->bindValue(':sIp', $currentIp);
                  $sQuery->execute();
                  //echo '{"status":0, "message":"updated attempts"}';
                  //exit;

                }catch(PDOException $exception){
                  echo '{"status":0, "message":"cannot login"}';
                }
        //exit;
      }else{
        //if the ip of the failed login is unknown, insert it in ips
        try{
          $sQuery = $db->prepare('INSERT INTO ips
                                  VALUES (null, :sIp, :sEmail, :iAttempts, :bActive)');
      
          $sQuery->bindValue(':sIp', $currentIp);
          $sQuery->bindValue(':sEmail', $_POST['txtEmail']);
          $sQuery->bindValue(':iAttempts', 1);
          $sQuery->bindValue(':bActive', 1);
          $sQuery->execute();
          if( $sQuery->rowCount() ){
            echo '{"status":2, "message":"You have 3 tries left"}';
            exit;
          }
          echo '{"status":0, "message":"error"}';
        }catch( PDOException $e ){
            var_dump ($e);
          echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
        }
      }
      //echo '{"status":0, "message":"user does not exist"}';
    
    }catch(PDOException $exception){
      echo '{"status":0, "message":"cannot login"}';
    }