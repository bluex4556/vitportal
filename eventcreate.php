<?php require('inc/loginrequire.php'); ?>
<?php
    if ($_SERVER['REQUEST_METHOD']=="POST") 
    {
        $name = $_POST['eventname'];
        $desc = $_POST['eventdesc'];
        $venue = $_POST['venue'];
        $dur = $_POST['duration'];
        $date = $_POST['eventdate'];
        $type = $_POST['type'];
        $userid = $_SESSION['userid'];
        //echo $name . $desc .$dur .$date . $type;
        require('config/db.php');
        $name = mysqli_real_escape_string($conn,$name);
        $desc = mysqli_real_escape_string($conn,$desc);
        $dur = mysqli_real_escape_string($conn,$dur);
        $date = mysqli_real_escape_string($conn,$date);
        $type = mysqli_real_escape_string($conn,$type);

        if(substr($userid,0,3)=="fac")
        {
            $userid = substr($userid,3);
            $sql = "INSERT INTO events(facultyid,eventname,eventdesc,venue,duration,dt,eventtype) VALUES($userid,'$name','$desc','$venue',$dur,'$date','$type')";
        }
        else
        {
            $sql = "INSERT INTO events(userid,eventname,eventdesc,venue,duration,dt,eventtype) VALUES('$userid','$name','$desc','$venue',$dur,'$date','$type')";
        }
        if($conn->query($sql)==TRUE)
        {
            header('Location: events.php');
        }
        else
        {
            echo "error creating post ".$sql."<br>" . $conn->error;
        }
        $conn->close();
    }
    
?>


<?php include 'inc/header.php'; ?>
    <form method="POST">
        <input type="text" name="eventname" placeholder="event name">
        <br>
        <textarea name="eventdesc" rows="10" placeholder="event description"></textarea>
        <br>
        <input type="text" name="venue" placeholder="venue">
        <br>
        <input type="text" name="duration" placeholder="duration">
        <br>
        <input type="date" name="eventdate" placeholder="event date">
        <br>
        <label for="formal">
        <input type="radio" name="type" id="formal" value="formal">Formal
        </label>
        <label for="informal">
        <input type="radio" name="type" id="informal" value="informal">Informal
        </label>
        <input type="submit">        
    </form>
<?php include 'inc/footer.php'; ?>