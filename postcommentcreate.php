<?php
    require('inc/loginrequire.php');
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $content = $_POST['commentcontent'];
        $postid = $_POST['postid'];
        $userid = $_SESSION['userid'];

        require('config/db.php');
        $content  = mysqli_escape_string($conn, $content);
        if(substr($userid,0,3)=="fac")
        {
            $userid = substr($userid,3);
            $sql = "INSERT INTO postcomments(facultyid,postid,content) VALUES($userid,'$postid','$content')";
        }
        else
        {
            $sql = "INSERT INTO postcomments(userid,postid,content) VALUES('$userid','$postid','$content')";
        }
        if($conn->query($sql)== TRUE)
        {
            $conn->close();
            header('Location: postdetail.php?postid='.$postid);
        }
        else
            echo "Something went wrong. Please try again later";
    }
?>