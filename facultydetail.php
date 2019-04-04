<?php include 'inc/header.php'?>
<?php 

    function getfree($week)
    {
        echo("
        <div class='container'>
            <table border=1px class='center' style='width:80%'>
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
        echo "</table></div>";

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
        <div class='container card' id ='%s' style='width:50%%;margin: auto'>
        <div class='card-title'>
        <h3>  %s</h3>
        </div>
        <div class='card-body'>
        Dept: %s
        <br>
        Location: %s
        <br>
        cabin: %s
        <br>
        </div>
        <div class='card-footer'>
        %s
        </div>
        </div>
        </div>
        <br>
        <br>
        <br>
        ",$facultyid,$fname,$dept,$campus,$cabin,$frole);
        echo "</div>";
    if(isset($_SESSION['userid']))
    {

        $userid = substr($_SESSION['userid'],3);
    if($facultyid == $userid)
    {
        echo "<br><form method='POST' action='facultyedit.php' >
        <div class='center' style='width:10%;margin-bottom: 30px;'>
            <input type='submit' value='Edit Venue and Time Table' >
        </div>
            <input type='hidden' name='facultyid' value='$facultyid'>
            </form>
            ";
    }
    }
        getfree($week);
    }
    else
    {
        echo "0 Results";
    }
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    // // Comments
    echo "<br><br><h2 class='heading'>Faculty Comment</h2>";
    if(isset($_SESSION['userid']))
    {
    if ($facultyid == $userid) 
    {
        echo "
        <form action='facultycommentcreate.php' method='post'>
        <div class='center'>
            <textarea name='commentcontent' cols='40' rows='2'></textarea>
            <input type='hidden' name='facultyid' value=$facultyid>
        <input type='submit' class='btn btn-success' style='float:right;'>
            </div>
        </form>";    
        // echo "$facultyid";

    }
}

    $sql= "SELECT commentid, content FROM facultycomments WHERE facultyid='$facultyid' LIMIT 10";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {   echo "<div class='container'>";
        while($row = $result->fetch_assoc())
        {   
           $commentid= $row['commentid'];
           $content = $row['content'];
           echo sprintf("
           <div class='comment' id ='%s'>
           <div class = 'comment-content'>
            %s
           </div>
           </div>
           ",$commentid,$content);
        }
        echo "</div>";
    }
    else{
        echo "
        <div class='center container' style='margin: 100px;text-align:center'>
         No comments yet.
         </div>
        ";
    }
    $conn->close();
?>

<?php include 'inc/footer.php' ?>