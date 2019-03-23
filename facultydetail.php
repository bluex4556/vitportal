<?php include 'inc/header.php'?>
<?php 

    function getfree($week)
    {
        echo("
            <table border=1px>
            <tr>
                <th>Days</th>
                <th>8:00 - 8:50</th>
                <th>8:50 - 9:40</th>
                <th>9:50 - 10:40</th>
                <th>10:40 - 11:30</th>
                <th>11:40 - 12:30</th>
                <th>12:30 - 1:20</th>
                <th>2:00 - 2:50</th>
                <th>2:50 - 3:40</th>
                <th>3:50 - 4:40</th>
                <th>4:40 - 5:30</th>
                <th>5:40 - 6:30</th>
                <th>6:30 - 7:20</th>
                <th>7:30 - 8:20</th>
                <th>8:20 - 9:10</th>
            </tr>"
        );
        foreach ($week as $day => $value) {
            echo "<tr><td>$day</td>";
            $strvar = (string)$value;
            for ($i=0; $i < strlen($strvar); $i++) { 
                if ($strvar[$i] == '1') {
                    echo "<td>free</td> ";
                }
                else echo "<td>busy</td>";
            }
            echo "</td>";
        }
        echo "</table>";

    }
    $facultyid = $_GET['facultyid'];

    require ('config/db.php');
    $sql = "SELECT faculty.facultyid,fname,frole,dept,campus,cabin,mon,tue,wed,thu,fri FROM faculty inner join facultytimetable WHERE faculty.facultyid ='$facultyid' and faculty.facultyid = facultytimetable.facultyid";
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
        $cabin = $row['cabin'];  
        $week = array('monday'=>$row['mon'],'tuesday'=>$row['tue'],'wednesday'=>$row['wed'],'thursday'=>$row['thu'],'friday'=>$row['fri']); 

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
        cabin: %s
        </div>
        </div>
        </div>
        ",$facultyid,$fname,$frole,$dept,$campus,$cabin);
        echo "</div>";
        getfree($week);
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    $userid = substr($_SESSION['userid'],3);
    if($facultyid == $userid)
    {
        echo "<br><form method='POST' action='facultyedit.php'>
            <input type='submit' value='Edit Venue and Time Table'>
            <input type='hidden' name='facultyid' value='$facultyid'>
            </form>
            ";
    }
    // // Comments
    echo "<br><br><h2>Faculty Comment</h2>";

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
    $conn->close();
    if ($facultyid == $userid) 
    {
        echo '
        <form action="facultycommentcreate.php" method="post">
            <textarea name="commentcontent" cols="40" rows="10"></textarea>
            <input type="hidden" name="facultyid" value="<?php echo $facultyid; ?>">
            <input type="submit">
        </form>';    
    }



?>

<?php include 'inc/footer.php' ?>