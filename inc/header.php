<?php
      if ( !isset($_SESSION) ) session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vit Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <ul class='navbar'>
        <li><a href="index.php" class='btn btn-success'>Home</a></li>
        <li><a href="faculty.php">Faculty</a></li>
        <li><a href="events.php">Events</a></li>
        <?php 
        if (!isset($_SESSION['userid'])) {
            echo "<li><a href='login.php'>Login</a></li>
            <li><a href='signup.php'>Signup</a></li>" ;
        }
        else {
            echo "<li><a href='logout.php'>Logout</a></li>";           
        }
        ?>
    </ul>    
        <br>
    <div class="content">
