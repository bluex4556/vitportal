<?php include 'inc/header.php' ?>

<?php 
    function time_elapsed_string($datetime, $full = false) 
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
            );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    
    $postid = $_GET['postid'];
    require ('config/db.php');
    $sql = "SELECT postid,regno,title,dt,content,posts.userid FROM posts INNER JOIN users on posts.userid = users.userid where postid = '$postid' union SELECT postid,fname,title,dt,content,posts.facultyid FROM posts INNER JOIN faculty on posts.facultyid = faculty.facultyid where postid = '$postid'";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {      
        echo "<div class='posts'>";
        $row = $result->fetch_assoc();
        $postid= $row['postid'];
        $regno = $row['regno'];
        $title = $row['title'];
        $userid = $row['userid'];
        $content = $row['content'];
        $dt = $row['dt'];           
        $convertdt = time_elapsed_string($dt);
        echo sprintf("
        <div class='post' id ='%s'>
        <div class='post-title'>
        <h3>  %s </h3>
        <div class='post-details'>
        %s - %s
        </div> 
        </div>
        <div class = 'post-content'>
        %s
        </div>
        </div>
        ",$postid,$title,$regno,$convertdt, $content);
        echo "</div>";

        if(isset($_SESSION['userid']) && $userid==$_SESSION['userid'])
        {
            echo "<a href='postupdate.php?postid=".$postid."'>Update Post</a> ";
        }
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];

    // Comments

    require('config/db.php');
    $sql= "SELECT commentid, content, dt, regno FROM postcomments INNER JOIN users on postcomments.userid = users.userid WHERE postid='$postid' ORDER BY dt DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='comments'>";
        while($row = $result->fetch_assoc())
        {   
           $commentid= $row['commentid'];
           $regno = $row['regno'];
           $content = $row['content'];
           $dt = $row['dt'];           
           $convertdt = time_elapsed_string($dt);
           echo sprintf("
           <div class='comment' id ='%s'>
           <div class = 'comment-content'>
            %s
           </div>
           <div class='comment-details'>
           made by: %s - %s
           </div> 
           </div>
           ",$commentid,$content,$regno, $convertdt);
        }
        echo "</div>";
    }
    else
    {
        echo "no comments";
    }
    $conn->close();
?>


<form action="postcommentcreate.php" method="post">
    <textarea name="commentcontent" cols="40" rows="10"></textarea>
    <input type="hidden" name="postid" value="<?php echo $postid; ?>">
    <input type="submit">
</form>
<?php include 'inc/footer.php' ?>