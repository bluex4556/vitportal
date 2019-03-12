<?php include 'inc/header.php'; ?>
<h1>Posts</h1>
<?php
    require('config/db.php');
    $sql= "SELECT * FROM posts ORDER BY dt DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc())
        {
            echo "id: " . $row['postid'] . "<br>userid: " .$row['userid'].  "<br>Title: " .$row['title'] . "<br>Content: " . $row['content'];
        }
    }
    else
    {
        echo "0 Results";
    }

?>

<?php include 'inc/footer.php'; ?>