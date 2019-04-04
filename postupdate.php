<?php require'inc/loginrequire.php'?>
<?php include'inc/header.php'?>

<?php
    if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['postid'])) {
        $postid =  $_GET['postid'];
        require 'config/db.php';
        $sql = "select postid,title,content from posts where postid=$postid";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
            die();
        }
        else{
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $content=$row['content'];
            echo "
            <div class='center container '>
            <form method='post'>
            <input type='text' name='title' id='title' value='$title'>
            <textarea  name='content' id='content'>$content</textarea>
            <input type='submit'>
            </form>
             </div>";

        }

    }
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $postid = $_GET['postid'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        require('config/db.php');
        $content = trim($content);
        $content= mysqli_escape_string($conn,$content);
        $sql = "UPDATE posts set title='$title', content='$content' where postid=$postid";
        if ($conn->query($sql) === TRUE) 
        {
            header("Location: postdetail.php?postid=" .$postid);
            echo "Post updated successfully <br>";

        } 
        else 
        {
            echo "Error creating table POSTCOMMENTS: " . $conn->error ."<br>";
        }
        $conn->close();
        
    }

?>


<?php include'inc/footer.php'?>

