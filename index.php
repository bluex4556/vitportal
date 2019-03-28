<?php include 'inc/header.php'; ?>
    <a href='postcreate.php' style='font-size:20px;display:inline;margin: 10px;float:right;padding:10px' class='btn btn-success'>Add post</a>
<div class="heading">
    Posts
</div>
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
$sql = "SELECT postid,title,content,dt,regno FROM posts INNER JOIN users on posts.userid = users.userid union SELECT postid, title, content,dt, fname FROM posts INNER JOIN faculty on posts.facultyid = faculty.facultyid ORDER BY dt DESC LIMIT 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
        echo "<div class='posts'>";
        while ($row = $result->fetch_assoc()) {
                $postid = $row['postid'];
                $regno = $row['regno'];
                $title = $row['title'];
                $content = $row['content'];
                $dt = $row['dt'];
                $convertdt = time_elapsed_string($dt);
                echo sprintf("
            <a href='postdetail.php?postid=%s'  > 
           <div class='container card' id ='%s'>
           <div class='card-title'>
           <h3> %s  </h3>
          
           </div>
           <div class = 'card-body'>
            %s
           </div>
           <div class='card-footer'>
           %s - %s
           </div> 
           </div>
           </a>
           ", $postid, $postid, $title, $content, $regno, $convertdt);
                $regno = "";
            }
        echo "</div>";
    } else {
        echo "0 Results";
    }
$conn->close();
?>



<?php include 'inc/footer.php'; ?> 