<?php 
session_start();
echo  $_SESSION['userid'];
// require('config/db.php');
// $sqlinput = "";
// for ($i=1; $i <=95 ; $i++) { 
//     $sqlinput .= "('$i'),";
// }
// $sqlinput = substr($sqlinput,0,-1);
// $sql = "INSERT INTO facultytimetable(facultyid) values $sqlinput";
// echo $sql;
// if($conn->query($sql)==TRUE)
// {
//     header('Location: index.php');
// }
// else
// {
//     echo "error creating post ".$sql."<br>" . $conn->error;
// }

?>