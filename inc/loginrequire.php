<?php
    session_start();
    if(!isset($_SESSION['userid']))
    {
        $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
    }
?>