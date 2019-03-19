<?php
    require('inc/loginrequire.php');
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $content = $_POST['commentcontent'];
        $postid = $_POST['postid'];
        $userid = $_SESSION['userid'];

        require('config/db.php');
        $content  = mysqli_escape_string($conn, $content);
        $sql = "INSERT INTO postcomments (userid,postid,content) VALUES ('$userid','$postid', '$content')";
        if($conn->query($sql)== TRUE)
            header('Location: postdetail.php?postid='.$postid);
        else
            echo "Something went wrong. Please try again later";
    }
?>