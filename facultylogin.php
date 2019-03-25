<?php
        //Checks if user is already logged in
        session_start();
        if (isset($_SESSION['userid'])) {
            header('Location: index.php');
        } 
        $passworderr = $regerr = "";  //strings to display errors

        //function to remove unnecessary characters
        function test_input($data)
        {
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if($_SERVER['REQUEST_METHOD']=="POST")
        {

            $password= test_input($_POST['password']);
            $facultyname= strtolower(trim(test_input($_POST['facultyname'])));   //remove spaces and makes lower case characters to upper
            
            require('config/db.php');  //establishes connection to the DB with $conn
            $password = mysqli_real_escape_string($conn,$password);  //escapes special characters 
            $facultyname = mysqli_real_escape_string($conn,$facultyname);

            $sql= "SELECT facultyid, facultyname FROM facultylogin WHERE facultyname = '$facultyname' and password = '$password'";  //gets all rows with same facultyname
            
            $result= $conn->query($sql);
            if($result->num_rows==1)
            {
                $row = $result->fetch_assoc();
                //set session variable
                $_SESSION['userid'] = 'fac'. $row['facultyid'];
                if(isset($_SESSION['redirect']))
                {
                    header('Location: ' . $_SESSION['redirect']);
                }
                else
                {
                    header('Location: index.php');
                }
            }
            else
            {
                echo "error";
                echo $result->num_rows;
            }
            $conn->close();
        }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        input::placeholder{
            text-transform :none;
        }
    </style>
</head>
<body>
<h1>Faculty login</h1>
    <form method="POST">        
        <input type="text" name="facultyname" id="facultyname" placeholder="Faculty name" style="text-transform: lowercase;"> <!-- transforms the input into uppercase -->
        <span class="error">*<?php echo $regerr; ?></span>  
        <br>
        <br>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="error">* <?php echo $passworderr; ?> </span>
        <br>
        <input type="submit">
    </form>
<a href="login.php">Student Login</a>
</body>
</html>