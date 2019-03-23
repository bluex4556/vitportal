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
        echo "<div class='course'>";
        $row = $result->fetch_assoc();
        $courseno= $row['courseno'];
        $coursetitle = $row['coursetitle'];
        $credits = $row['credits'];
        echo sprintf("
        <div class='course'>
            <div class='course-no'>%s</div>
            <div class='course-title'>
            <h3>  %s </h3>
            </div> 
            <div class='course-credits'>
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
    echo "<br><br><h2>Comments</h2>";
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
        echo "no comments";
    }
    $conn->close();
?>


<form action="coursecommentcreate.php" method="post">
    <textarea name="commentcontent" cols="40" rows="10"></textarea>
    <input type="hidden" name="courseno" value="<?php echo $courseno; ?>">
    <input type="submit">
</form>
<?php include 'inc/footer.php' ?>