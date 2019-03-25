<?php       
        //Checks if user is already logged in        
        session_start();
        if (isset($_SESSION['userid'])) {
            header('Location: index.php');
        }        
        //function to remove unnecessary characters
        function test_input($data)
        {
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $passworderr = $regerr = $confirmpasserr = "";  //strings to display errors
        $flag= 0; //to check if the forms are valid

        if($_SERVER["REQUEST_METHOD"]=="POST")
        { 
            $password= test_input($_POST['password']);
            $confirmpass = test_input($_POST['confirmpass']);          
            $regno= strtoupper(trim(test_input($_POST['regno'])));   //remove spaces and makes lower case characters to upper
            if(!preg_match('/^[1-9]{2}[A-Z]{3}[0-9]{4}$/',$regno)) //checks if regno matches the register number format
            {
                $regerr= "Enter valid register no";
            }
            else 
            {
                 ++$flag;               
            }
            if(strlen($password)<5)
            {
                $passworderr = "password should be atleast 5 chars";                
            }
            else 
            {
                if($confirmpass != $password)
                {
                    $confirmpasserr = "Password does not match";
                }
                else
                {
                    ++$flag;
                }
            }
            if($flag==2)  //both conditions pass
            {
                require('config/db.php');  //establishes connection to the DB with $conn

                $password = mysqli_real_escape_string($conn,$password);  //escapes special characters 
                $regno = mysqli_real_escape_string($conn,$regno);
                
                $sql= "SELECT regno FROM users WHERE regno = '$regno'";  //gets all rows with same regno

                $result= $conn->query($sql);
                //regno has property unique we can maybe remove this if and put the error code in the next else
                if($result->num_rows>0)  //checks if regno is unique
                {
                    $regerr="Register no already exists";
                }
                else
                {
                    $sql = "INSERT INTO users (regno,password) values ('$regno','$password')"; //inserts data
                    if($conn->query($sql)==TRUE)
                    {
                        //login user and redirect to post; use session
                        echo "user created";                        
                    }
                    else
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error; 
                    }
                }
                $conn->close();
            }
        }


    ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SignUp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    /* the text transform to upper in the input makes the placeholder transform to uppercase too. This reverses that */
        input::placeholder{
            text-transform:none;  
        }
    </style>

</head>

<body>

<h1>Signup</h1>
    <form method="POST">        
        <input type="text" name="regno" id="regno" placeholder="Register no" style="text-transform: uppercase;"> <!-- transforms the input into uppercase -->
        <!-- displays the error -->
        <span class="error">*<?php echo $regerr; ?></span>  
        <br>
        <br>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="error">* <?php echo $passworderr; ?> </span>
        <br>
        <br>
        <input type="password" name="confirmpass" placeholder="Confirm Password" required>
        <span class="error"><?php echo $confirmpasserr; ?></span>
        <br>
        <input type="submit">
    </form>

</body>
</html>