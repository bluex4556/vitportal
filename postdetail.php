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
        <div class='container card center' id ='%s'>
        <div class='card-title'>
        <h3>  %s </h3>
        </div>
        <div class = 'card-body'>
        %s
        </div>
        <div class='card-footer'>
            %s - %s
        </div> 
        </div>
        ",$postid,$title,$content, $regno,$convertdt);
        echo "</div>";

        if(isset($_SESSION['userid']) && $userid==$_SESSION['userid'])
        {
            echo "";
        echo "<div class='center' style='width:10%;margin-bottom: 30px;'>
        <a class='btn btn-success' href='postupdate.php?postid=".$postid."'>Update Post</a> 
                </div>
        ";
        }
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];

    // Comments
    ?>

<h3 class="heading" style='font-size: 18px;'>
Comments
</h3>

<form action="postcommentcreate.php" method="post">
    <div class="center">
    <textarea name="commentcontent" cols="40" rows="2" ></textarea>
    <input type="submit" class='btn btn-success' style='float:right;'>
    </div>
    <input type="hidden" name="postid" value="<?php echo $postid; ?>">
</form>
<?php
    require('config/db.php');
    $sql= "SELECT commentid, content, dt, regno FROM postcomments INNER JOIN users on postcomments.userid = users.userid WHERE postid='$postid' union SELECT commentid, content, dt, fname FROM postcomments INNER JOIN faculty on postcomments.facultyid = faculty.facultyid WHERE postid='$postid' ORDER BY dt DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='container'>";
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
        echo "<div class='container  center' style='margin-top: 35px;width:50%;'> No Comments Yet</div> ";
    }
    $conn->close();
?>

<?php include 'inc/footer.php' ?>