<?php include 'inc/header.php'; ?>
<h1>Courses</h1>
<?php
        
    require('config/db.php');
    $sql= "SELECT courseno,coursetitle,credits FROM courses ";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='courses'>";
        while($row = $result->fetch_assoc())
        {   
           $courseno= $row['courseno'];
           $coursetitle = $row['coursetitle'];
           $credits = $row['credits'];
           echo sprintf("
           <div class='course'>
            <div class='course-no'>%s</div>
            <div class='course-title'>
            <h3><a href='coursedetail.php?courseno=%s'>%s</a></h3>           
            </div>
            <div class = 'course-credits'>%s</div>
           </div><br>
           ",$courseno,$courseno,$coursetitle,$credits);
        }
        echo "</div>";
    }
    else
    {
        echo "0 Results";
    }
    $conn->close();

?>
<a href="coursecreate.php">Add a course</a>
<?php include 'inc/footer.php'; ?>