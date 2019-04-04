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
    
    $courseno = $_GET['courseno'];
    require ('config/db.php');
    $sql = "SELECT courseno,coursetitle,credits FROM courses where courseno = '$courseno'";
    $result = $conn->query($sql);
    if($result->num_rows==1)
    {      
        echo "<div class='posts'>";
        $row = $result->fetch_assoc();
        $courseno= $row['courseno'];
        $coursetitle = $row['coursetitle'];
        $credits = $row['credits'];
        echo sprintf("
        <div class='container card center'>
            <div class='card-title'>%s</div>
            <div class='card-body'>
            <h3>  %s </h3>
            </div> 
            <div class='card-footer'>
            Credits: 
            %s
            </div>
        </div>
        ",$courseno,$coursetitle,$credits);
        echo "</div>";
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];

    // Comments
    echo " 
    <h3 class='heading' style='font-size: 18px;'>
    Comments
    </h3>
";
?>
<form action="postcommentcreate.php" method="post">
    <div class="center">
    <textarea name="commentcontent" cols="40" rows="2" ></textarea>
    <input type="submit" class='btn btn-success' style='float:right;'>
    </div>
    <input type="hidden" name="postid" value="<?php echo $postid; ?>">
</form>
<?php
    require('config/db.php');
    $sql= "SELECT commentid, content, regno FROM coursecomments INNER JOIN users on coursecomments.userid = users.userid WHERE courseno='$courseno' union SELECT commentid, content, fname FROM coursecomments INNER JOIN faculty on coursecomments.facultyid = faculty.facultyid WHERE courseno='$courseno' LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='comments'>";
        while($row = $result->fetch_assoc())
        {   
           $commentid= $row['commentid'];
           $regno = $row['regno'];
           $content = $row['content'];
           echo sprintf("
           <div class='comment' id ='%s'>
           <div class = 'comment-content'>
            %s
           </div>
           <div class='comment-details'>
           made by: %s 
           </div> 
           </div>
           ",$commentid,$content,$regno);
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