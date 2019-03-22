<?php    
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "myDB";
    $conn = new mysqli($servername, $dbusername, $dbpassword,$dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "CREATE TABLE facultylogin(
        facultyid int(6) unsigned auto_increment primary key,
        facultyname varchar(25) not null,
        password varchar(25) not null,
        FOREIGN KEY (facultyid) REFERENCES faculty(facultyid) ON DELETE CASCADE ON UPDATE CASCADE,
        UNIQUE KEY (facultyname)
    )";

if ($conn->query($sql) === TRUE) 
{
    echo "Table events created successfully <br>";
} 
else 
{
    echo "Error creating table POSTCOMMENTS: " . $conn->error ."<br>";
}

$conn->close();


?>