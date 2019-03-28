<?php include 'inc/header.php'; ?>
<div class="heading">
Faculty SCSE chennai
</div>
<?php
        
    require('config/db.php');
    // where dept='SCSE' and campus='chennai'
    $sql= "SELECT facultyid,fname,frole,rating FROM faculty WHERE dept='SCSE' AND campus LIKE 'chennai%' ";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='posts'>";
        while($row = $result->fetch_assoc())
        {   
           $facultyid= $row['facultyid'];
           $name = $row['fname'];
           $role = $row['frole'];
           $rating = $row['rating'];           
           echo sprintf("
            <a href='facultydetail.php?facultyid=%s'> 
           <div class='container card' id ='%s'>
           <div class='card-title'>
           <h3> %s  </h3>           
           </div>
           <div class = 'card-body'>
            %s
           </div>
           </div>
           </a>
           ",$facultyid,$facultyid,$name,$role);
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