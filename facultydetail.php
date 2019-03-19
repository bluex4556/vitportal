<?php include 'inc/header.php'?>
<?php 
    $facultyid = $_GET['facultyid'];

    require ('config/db.php');
    $sql = "SELECT * FROM faculty WHERE facultyid ='$facultyid'";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {      
        echo "<div class='faculty'>";
        $row = $result->fetch_assoc();
        $facultyid= $row['facultyid'];
        $fname = $row['fname'];
        $frole = $row['frole'];
        $dept = $row['dept'];
        $campus = $row['campus'];
        $rating = $row['rating'];           

        echo sprintf("
        <div class='faculty' id ='%s'>
        <div class='faculty-name'>
        <h3>  %s</h3>
        <div class='faculty-role'>
        %s
        </div>
        <div class='faculty-location'>
        Dept: %s
        Location: %s
        </div>
        </div>
        <div class = 'faculty-rating'>
        %s
        </div>
        </div>
        ",$facultyid,$fname,$frole,$dept,$campus, $rating);
        echo "</div>";
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];

    // // Comments

    $sql= "SELECT commentid, content, regno FROM facultycomments INNER JOIN users on facultycomments.userid = users.userid WHERE facultyid='$facultyid' LIMIT 10";
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

<form action="facultycommentcreate.php" method="post">
    <textarea name="commentcontent" cols="40" rows="10"></textarea>
    <input type="hidden" name="facultyid" value="<?php echo $facultyid; ?>">
    <input type="submit">
</form>

<?php include 'inc/footer.php' ?>