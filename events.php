<?php include 'inc/header.php'; ?>
<h1>Events</h1>
<?php
    require('config/db.php');
    $sql= "SELECT eventid, eventname, eventdesc, duration,dt,eventtype,regno FROM events  INNER JOIN users on events.userid = users.userid WHERE dt>=CURDATE() UNION SELECT eventid, eventname, eventdesc, duration,dt,eventtype,fname FROM events  INNER JOIN faculty on events.userid = faculty.facultyid WHERE dt>=CURDATE() ORDER BY dt DESC LIMIT 10 " ;
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='events'>";
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
           <div class='event' id ='%s'>
           <div class='event-name'>
           <h3> %s </h3>
           <div class='event-details'>
            %s - %s
            </div> 
           </div>
           <div>
            On: %s
           </div>
           <div class = 'event-content'>
            %s
           </div>
           <div class=event-hrs>
            %s Hrs
           </div>
           <div>
            Type: %s 
           </div>
           </div>
           ",$eventid,$eventname,$regno,$dt,$dt,$eventdesc,$duration,$type);
        }
        echo "</div>";
    }
    else
    {
        echo "0 Results";
    }
    $conn->close();

?>
<br>
<a href="eventcreate.php">Add event</a>
<?php include 'inc/footer.php'; ?>