<?php include 'inc/header.php'; ?>
<a href='eventcreate.php' style='font-size:20px;display:inline;margin: 10px;float:right;padding:10px' class='btn btn-success'>Add a Event</a>
<div class="heading">
Events
</div>
<?php
    require('config/db.php');
    $sql= "SELECT eventid, eventname, eventdesc, duration,dt,eventtype,regno FROM events  INNER JOIN users on events.userid = users.userid WHERE dt>=CURDATE() UNION SELECT eventid, eventname, eventdesc, duration,dt,eventtype,fname FROM events  INNER JOIN faculty on events.userid = faculty.facultyid WHERE dt>=CURDATE() ORDER BY dt DESC LIMIT 10 " ;
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='posts'>";
        while($row = $result->fetch_assoc())
        {   
           $eventid= $row['eventid'];
           $regno = $row['regno'];
           $eventname = $row['eventname'];
           $eventdesc = $row['eventdesc'];
           $duration = $row['duration'];
           $dt = $row['dt'];
           $type = $row['eventtype'];

          echo sprintf("
           <div class='container card' id ='%s'>
           <div class='card-title'>
           <h3> %s </h3>
            </div> 
           <div class='card-body'>
            %s - %s
            <br>
            On: %s
            <br>
            %s
           </div>
           <div class='card-footer'>
            %s Hrs
            Type: %s 
           </div>
           </div>
           ",$eventid,$eventname,$regno,$dt,$dt,$eventdesc,$duration,$type);
        }
        echo "</div>";
    }
    else
    {
        echo "<div class='container  center' style='margin-top: 35px;width:50%;'> No Events Yet</div> ";
    }
    $conn->close();

?>
<br>
<?php include 'inc/footer.php'; ?>