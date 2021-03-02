<?php
//userLevel only has select, update and insert access rights to protect against some sql injections + PDO
//other protection: prepared statements on every query - no need for mysql_real_escape_string(), stored procedures - try + catch, not showing DBMS error msgs, input validation with PHP and js
try{
  $sUserName = ''; //write your db username here
  $sPassword = ''; //write your db password here
  $sConnection = "mysql:host=localhost; dbname=keabook-security; charset=utf8";

  $aOptions = array(
    PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  );
  $db = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );

}catch( PDOException $e){
   var_dump($e);
  echo '{"status":"err","message":"cannot connect to database"}';
  exit();
}