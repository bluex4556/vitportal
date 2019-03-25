<?php
    require('inc/loginrequire.php');
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $content = $_POST['commentcontent'];
        $courseno = $_POST['courseno'];
        $userid = $_SESSION['userid'];

        require('config/db.php');
        $content  = mysqli_escape_string($conn, $content);
        if(substr($userid,0,3)=="fac")
        {
            $userid = substr($userid,3);
            $sql = "INSERT INTO coursecomments(facultyid,courseno,content) VALUES($userid,'$courseno','$content')";
        }
        else
        {
            $sql = "INSERT INTO postcomments(userid,courseno,content) VALUES('$userid','$courseno','$content')";
        }
        if($conn->query($sql)== TRUE)
        {
            $conn->close();
            header('Location: coursedetail.php?courseno='.$courseno);
        }
        else
            echo "Something went wrong. Please try again later";
    }
?>