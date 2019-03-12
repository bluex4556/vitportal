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
            $regno= strtoupper(trim(test_input($_POST['regno'])));   //remove spaces and makes lower case characters to upper
            
            require('config/db.php');  //establishes connection to the DB with $conn
            $password = mysqli_real_escape_string($conn,$password);  //escapes special characters 
            $regno = mysqli_real_escape_string($conn,$regno);

            $sql= "SELECT userid, regno FROM users WHERE regno = '$regno' and password = '$password'";  //gets all rows with same regno
            
            $result= $conn->query($sql);
            if($result->num_rows==1)
            {
                $row = $result->fetch_assoc();
                //set session variable
                $_SESSION['userid'] = $row['userid'];
                //Checks if user was redirected to login from another page
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
        /* the text transform to upper in the input makes the placeholder transform to uppercase too. This reverses that */
        input::placeholder{
            text-transform :none;
        }
    </style>
</head>
<body>
<h1>Login</h1>
    <form method="POST">        
        <input type="text" name="regno" id="regno" placeholder="Register no" style="text-transform: uppercase;"> <!-- transforms the input into uppercase -->
        <!-- displays the error -->
        <span class="error">*<?php echo $regerr; ?></span>  
        <br>
        <br>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="error">* <?php echo $passworderr; ?> </span>
        <br>
        <input type="submit">
    </form>

</body>
</html>