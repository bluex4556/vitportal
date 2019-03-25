<?php    
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "myDB";
    $conn = new mysqli($servername, $dbusername, $dbpassword,$dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "CREATE TABLE facultytimetable(
        facultyid int(6) unsigned auto_increment primary key,
        mon varchar(15) DEFAULT NULL,
        tue varchar(15) DEFAULT NULL,
        wed varchar(15) DEFAULT NULL,
        thu varchar(15) DEFAULT NULL,
        fri varchar(15) DEFAULT NULL,
        FOREIGN KEY (facultyid) REFERENCES faculty(facultyid) ON DELETE CASCADE ON UPDATE CASCADE
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