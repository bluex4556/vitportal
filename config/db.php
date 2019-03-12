<?php
    $servername = "localhost";
    $DBusername = "root";
    $DBpassword = "";
    $dbname = "myDB";

    $conn = new mysqli($servername, $DBusername, $DBpassword,$dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>