<?php include 'inc/header.php'; ?>
<h1>Posts</h1>
<?php
    require('config/db.php');
    $sql= "SELECT posts.postid, posts.title, posts.content, posts.dt, users.regno FROM posts INNER JOIN users on posts.userid = users.userid ORDER BY dt DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc())
        {   
           $postid= $row['postid'];
           $regno = $row['regno'];
           $title = $row['title'];
           $content = $row['content'];
           $dt = $row['dt'];

          echo sprintf("
           <div class='post' id ='%s'>
           <div class='post-title'>
           <h3> %s </h3>
           <sub> %s - %s </sub>
           </div>
           <div class = 'post-content'>
            %s
           </div>
           ",$postid,$title,$regno,$dt, $content);
        }
    }
    else
    {
        echo "0 Results";
    }

?>

<?php include 'inc/footer.php'; ?>