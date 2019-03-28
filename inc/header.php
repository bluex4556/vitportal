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


    <ul class='navbar' >
        <li><a href="index.php" class='active' >VITPORTAL</a></li>
        <li><a href="faculty.php">Faculty</a></li>
        <li><a href="events.php" >Events</a></li>
        <li><a href="courses.php">Courses</a></li>
        <?php 
        if (!isset($_SESSION['userid'])) {
            echo "
            <li style='float:right'><a href='facultylogin.php' >Faculty Login</a></li>
            <li style='float:right'><a href='login.php'>Login</a></li>
            <li style='float:right'><a href='signup.php'>Signup</a></li>" ;
        }
        else {
            echo "<li class='float-right'><a href='logout.php'>Logout</a></li>";           
        }
        ?>
    </ul>    
</div>
        <br>
    <div class="content">
