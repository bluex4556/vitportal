<?php include 'inc/header.php'; ?>
<h1>Posts</h1>
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
        
    require('config/db.php');
    $sql= "SELECT posts.postid, posts.title, posts.content, posts.dt, users.regno FROM posts INNER JOIN users on posts.userid = users.userid ORDER BY dt DESC LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='posts'>";
        while($row = $result->fetch_assoc())
        {   
           $postid= $row['postid'];
           $regno = $row['regno'];
           $title = $row['title'];
           $content = $row['content'];
           $dt = $row['dt'];           
           $convertdt = time_elapsed_string($dt);
           echo sprintf("
           <div class='post' id ='%s'>
           <div class='post-title'>
           <h3> %s </h3>
           <div class='post-details'>
            %s - %s
            </div> 
           </div>
           <div class = 'post-content'>
            %s
           </div>
           </div>
           ",$postid,$title,$regno,$convertdt, $content);
        }
        echo "</div>";
    }
    else
    {
        echo "0 Results";
    }

?>

<?php include 'inc/footer.php'; ?>