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
    <link rel="stylesheet" href="login.css">
</head>
<body>
<form method="POST">        
    <div class="main-box">
            <h1>Faculty Login</h1>
            <div class="data-box">
                <label for="username:">Faculty Name: &nbsp;
                    <span class="error" style='color:#ff4500'><?php echo $regerr; ?></span>  
                </label>
                <input type="text" name='facultyname' id='facultyname' required>
                <label for="password">Password: &nbsp;
                    <span class="error" style ='color:#ff4500'> <?php echo $passworderr; ?> </span>
                </label>
                <input type="password" name='password' id='password'  required>
                <br>
                <br >
                <input type='button' onclick="window.location.href='login.php'" class='button' value='Student Login' style='float:left;'>
                <input class="button" type="submit" value="Login">
            </div>
        </div> 
    </form>
</body>
</html>