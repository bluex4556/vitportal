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
        $facultyname = trim(str_replace(' ','',$faculty[$i][0]));
        $facultyname = str_ireplace('dr.', '', $facultyname);
        $facultyname = str_ireplace('prof.','',$facultyname);
        $facultyname = strtolower($facultyname); 
        $facultyid = $i + 1;
        $sqlinput .="($facultyid,'$facultyname','password'),";
    }
    $sqlinput = substr($sqlinput,0,-1);
    $sql = "INSERT INTO facultylogin(facultyid,facultyname,password) VALUES $sqlinput";
    require ('config/db.php');
    if($conn->query($sql)==TRUE)
    {
        header('Location: index.php');
    }
    else
    {
        echo "error creating post ".$sql."<br>" . $conn->error;
    }

?> 