<?php
    require('inc/loginrequire.php');
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $content = $_POST['commentcontent'];
        $facultyid = $_POST['facultyid'];
        $userid = $_SESSION['userid'];

        require('config/db.php');
        $content  = mysqli_escape_string($conn, $content);
        $sql = "INSERT INTO facultycomments (userid,facultyid,content) VALUES ('$userid','$facultyid', '$content')";
        if($conn->query($sql)== TRUE)
        {    
            $conn->close();
            header('Location: facultydetail.php?facultyid='.$facultyid);
        }
        else
        {
            echo "Something went wrong. Please try again later";
            echo $conn->error;

        }
    }
?>