<?php include 'inc/header.php'; ?>
<a href='coursecreate.php' style='font-size:20px;display:inline;margin: 10px;float:right;padding:10px' class='btn btn-success'>Add a course</a>
<div class="heading">
Courses
</div>
<?php
        
    require('config/db.php');
    $sql= "SELECT courseno,coursetitle,credits FROM courses ";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='posts'>";
        while($row = $result->fetch_assoc())
        {   
           $courseno= $row['courseno'];
           $coursetitle = $row['coursetitle'];
           $credits = $row['credits'];
           echo sprintf("
            <a href='coursedetail.php?courseno=%s'>
           <div class='container card'>
            <div class='card-title'>%s</div>
            <div class='card-body'>
            <h3>
            %s
            </h3>           
            </div>
            <div class = 'card-footer' style='padding:5px;'>Credits:  %s</div>
           </div>
            </a>
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

<?php include 'inc/footer.php'; ?>