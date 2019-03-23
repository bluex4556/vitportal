<?php 
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $week = array('monday'=>$_POST['monday'],'tuesday'=>$_POST['tuesday'],'wednesday'=>$_POST['wednesday'],'thursday'=>$_POST['thursday'],'friday'=>$_POST['friday']);
        $cabin = $_POST['cabin'];
        $facultyid = $_POST['facultyid'];
        foreach ($week as $day => $value) 
        {
            $value = implode($value);
            $week[$day] = $value;
        }
        require('config/db.php');
        if ($cabin!='') 
        {
            $sql = "UPDATE faculty SET cabin = '$cabin' where facultyid = $facultyid";
        }
        else 
        {
            $sql = "UPDATE faculty SET cabin = NULL where facultyid = $facultyid";            
        }
        echo $sql;
        if($conn->query($sql)!=TRUE)
        {
            echo "error creating post ".$sql."<br>" . $conn->error;
        }
        $sql = "UPDATE facultytimetable SET "; 
        foreach ($week as $day => $value) 
        {
            $dayshort = substr($day,0,3);
            $sql .= "$dayshort = '$value', ";
        }
        $sql = substr($sql,0,-2);
        echo $sql;
        if($conn->query($sql)==TRUE)
        {
            header('Location: facultydetail.php?facultyid='.$facultyid);
        }
        else
        {
            echo "error creating post ".$sql."<br>" . $conn->error;
        }
        $conn->close();
        
    }   
?> 