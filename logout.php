<?php
session_start();
//one time token used to prevent csrf
if (password_verify($_SESSION['csrfToken'], $_GET['token'])){
    session_destroy();
    header('Location: login.php');
}else{
    header('Location: home.php');
}