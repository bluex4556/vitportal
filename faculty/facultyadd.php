<?php
    $file = fopen('facultyscsechennai.txt','r');
    $faculty = array();
    $sqlinput = "";
    $txt = fgets($file);
    $filedetails = explode(",",$txt);
    $dept = $filedetails[0];
    $campus = $filedetails[1];
    while(!feof($file))
    {
        $txt = fgets($file);
        array_push($faculty,explode(",",$txt));
    }
    for ($i=0; $i < count($faculty); $i++) 
    { 
        $facultyname = $faculty[$i][0];
        $facultyrole = $faculty[$i][1];
        $sqlinput .= "('".$facultyname."','".$facultyrole."','".$dept."','".$campus."'), ";
    }
    $sqlinput = substr($sqlinput,0,-2);
    //echo $sqlinput. "<br>";     
    require ('config/db.php');
    $sql = "INSERT INTO faculty(fname,frole,dept,campus) VALUES " . $sqlinput;
    if($conn->query($sql)==TRUE)
    {
        header('Location: index.php');
    }
    else
    {
        echo "error creating post ".$sql."<br>" . $conn->error;
    }

?> 