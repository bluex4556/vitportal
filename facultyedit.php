<?php include'inc/header.php'?>
<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') 
    {
        $facultyid = $_POST['facultyid'];

        require ('config/db.php');
        $sql = "SELECT faculty.facultyid,fname,frole,dept,campus,cabin,mon,tue,wed,thu,fri FROM faculty inner join facultytimetable WHERE faculty.facultyid ='$facultyid' and faculty.facultyid = facultytimetable.facultyid";
        $result = $conn->query($sql);    
        $row = $result->fetch_assoc();
        $cabin = $row['cabin'];
        $week = array('monday'=>$row['mon'],'tuesday'=>$row['tue'],'wednesday'=>$row['wed'],'thursday'=>$row['thu'],'friday'=>$row['fri']); 

        echo("
            <form method='POST' action='timetableupdate.php'>
            
            Cabin: <input type='text' name='cabin' value='$cabin' placeholer='cabin'>
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
        foreach ($week as $day => $value) 
        {
            echo "<tr><td>$day</td>";
            $strvar = (string)$value;
            for ($i=0; $i < strlen($strvar); $i++) 
            { 
                if ($strvar[$i] == '1') 
                {
                    echo "<input type='hidden' name=".$day."[$i]' value='0'>";
                    echo "<td><input type='checkbox' name=".$day."[$i]' value='1' checked></td>";
                }
                else
                {
                    echo "<input type='hidden' name=".$day."[$i]' value='0'>";
                    echo "<td><input type='checkbox' name=".$day."[$i]' value='1'></td>";
                }
        }
            echo "</td>";
        }
        echo "</table><input type='hidden' name='facultyid' value='$facultyid'><input type='submit'></form>";
    }

?>

<?php include'inc/footer.php';?>