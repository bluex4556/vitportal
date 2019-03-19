<?php include 'inc/header.php'; ?>
<h1>Faculty SCSE chennai</h1>
<?php
        
    require('config/db.php');
    // where dept='SCSE' and campus='chennai'
    $sql= "SELECT facultyid,fname,frole,rating FROM faculty WHERE dept='SCSE' AND campus LIKE 'chennai%' ";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='faculties'>";
        while($row = $result->fetch_assoc())
        {   
           $facultyid= $row['facultyid'];
           $name = $row['fname'];
           $role = $row['frole'];
           $rating = $row['rating'];           
           echo sprintf("
           <div class='faculty' id ='%s'>
           <div class='faculty-name'>
           <h3><a href='facultydetail.php?facultyid=%s'>  %s </a> </h3>           <div class='faculty-rating'>
            Rating: %s
            </div> 
           </div>
           <div class = 'faculty-role'>
            %s
           </div>
           </div>
           ",$facultyid,$facultyid,$name,$rating,$role);
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