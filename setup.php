<?php
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "myDB";

    date_default_timezone_set("Asia/Kolkata");
    echo "Timezone is: ". date_default_timezone_get();
    
    // starting a connection for creating a database 
    $conn = new mysqli($servername,$dbusername, $dbpassword);
    
    //If error abort
    if($conn->connect_error)
    {
        die('connection failed'. $conn->connect_error);
    }

    $sql = "CREATE DATABASE " . $dbname;
    if($conn->query($sql) == TRUE)
    {
        echo "Database ".$dbname." Created succesfully";
    }
    else
    {
        echo "error creating database: ".$conn->error;
    }

    // //connection for creating tables in database
    $conn = new mysqli($servername, $dbusername, $dbpassword,$dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //creates table users
    $sql = "CREATE TABLE users(
        userid int(6) unsigned auto_increment primary key,
        regno varchar(10) not null,
        password varchar(15) not null
     )";

    if ($conn->query($sql) === TRUE) {
        echo "Table users created successfully <br>";
    } else {
        echo "Error creating table: " . $conn->error ."<br>";
    }

    $sql = "CREATE TABLE posts(
        postid int(6) auto_increment primary key,
        userid int(6) unsigned DEFAULT NULL,
        facultyid int(6) unsigned DEFAULT NULL,
        title varchar(100) NOT NULL,
        content text,
        dt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        campus varchar(30) DEFAULT NULL,        
        FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (facultyid) REFERENCES faculty(facultyid) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    if($conn->query($sql) == TRUE)
    {
        echo "Table post created sucessfully";
    }
    else
    {
        echo "Error Creating table " . $conn->error;
    }
    
    //creates table users
    $sql = "CREATE TABLE events(
        eventid int(6) unsigned auto_increment primary key,
        userid int(6) unsigned DEFAULT NULL,
        facultyid int(6) unsigned DEFAULT NULL,
        eventname varchar(30) not null,
        eventdesc text,
        venue varchar(10) not null,
        duration float(3,1),
        dt date,
        eventtype ENUM('formal','informal'),
        FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (facultyid) REFERENCES faculty(facultyid) ON DELETE CASCADE ON UPDATE CASCADE
        )";

    if ($conn->query($sql) === TRUE) {
        echo "Table events created successfully <br>";
    } else {
        echo "Error creating table: " . $conn->error ."<br>";
    }

    $sql = "CREATE TABLE faculty(
        facultyid int(6) unsigned auto_increment primary key,
        fname varchar(30) not null,
        frole varchar(30) not null,
        dept varhar(10) not null,
        campus varchar(15) not null,
        rating int default 0 not null
        )";
    
    if ($conn->query($sql) === TRUE) 
    {
        echo "Table events created successfully <br>";
    } 
    else 
    {
        echo "Error creating table: " . $conn->error ."<br>";
    }

    $sql = "CREATE TABLE postcomments(
        commentid int(6) unsigned auto_increment primary key,
        userid int(6) unsigned DEFAULT NULL,
        facultyid int(6) unsigned DEFAULT NULL,
        content text,
        dt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,        
        FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (postid) REFERENCES posts(postid) ON DELETE CASCADE ON UPDATE CASCADE,
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

    $sql= "CREATE TABLE facultycomments(
        commentid int(6) unsigned auto_increment primary key,
        userid int(6) unsigned not null,
        facultyid int(6) unsigned not null,
        content text,
        FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE ON UPDATE CASCADE,
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
    

    $sql = "CREATE TABLE courses(
        courseno varchar(10) primary key,
        coursetitle varchar(40) not null,
        credits int(1) not null
    )";

    if ($conn->query($sql) === TRUE) 
    {
        echo "Table events created successfully <br>";
    } 
    else 
    {
        echo "Error creating table POSTCOMMENTS: " . $conn->error ."<br>";
    }
    $sql= "CREATE TABLE coursecomments(
        commentid int(6) unsigned auto_increment primary key,
        userid int(6) unsigned DEFAULT NULL,
        facultyid int(6) unsigned DEFAULT NULL,
        courseno varchar(10) not null,
        content text,
        FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (courseno) REFERENCES courses(courseno) ON DELETE CASCADE ON UPDATE CASCADE,
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



