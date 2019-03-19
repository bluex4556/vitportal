<?php
    session_start();
    if(!isset($_SESSION['userid']))
    {
        if(!isset($_SESSION['redirect'])) $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
    }
?>