
<?php require('inc/loginrequire.php'); ?>
<?php 
    function test_input($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }    

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $title = test_input($_POST["title"]);
        $content = test_input($_POST["content"]);
        $userid = $_SESSION["userid"];
        require('config/db.php');

        $title = mysqli_real_escape_string($conn,$title);
        $content = mysqli_real_escape_string($conn,$content);
        if(substr($userid,0,3)=="fac")
        {
            $userid = substr($userid,3);
            $sql = "INSERT INTO posts(facultyid,title,content) VALUES($userid,'$title','$content')";
        }
        else
        {
            $sql = "INSERT INTO posts(userid,title,content) VALUES('$userid','$title','$content')";
        }
        if($conn->query($sql)==TRUE)
        {
            header('Location: index.php');
        }
        else
        {
            echo "error creating post ".$sql."<br>" . $conn->error;
        }
        $conn->close();
    }
?>
<?php include 'inc/header.php'; ?>
<form method="POST">
    <input type="text" name="title">
    <br>
    <textarea name="content" rows="10"></textarea>
    <br>
    <input type="submit">
</form>
<?php include 'inc/footer.php'; ?>