<?php require('inc/loginrequire.php'); ?>
<?php 
    function test_input($data)
    {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }    

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $coursetitle = test_input($_POST["coursetitle"]);
        $courseno = test_input($_POST["courseno"]);
        $credits = $_POST['credits'];
        require('config/db.php');
        echo "course no  $courseno";
        $coursetitle = mysqli_real_escape_string($conn,$coursetitle);
        $courseno = mysqli_real_escape_string($conn,$courseno);
        $sql = "INSERT INTO courses(courseno,coursetitle,credits) VALUES('$courseno','$coursetitle','$credits')";

        if($conn->query($sql)==TRUE)
        {
            header('Location: courses.php');
        }
        else
        {
            echo "error creating post ".$sql."<br>" . $conn->error;
        }
        $conn->close();
    }
?>
<?php include 'inc/header.php'; ?>
<form method="POST">
    <input type="text" name="courseno" placeholder="Course No">
    <br>
    <input type="text" name="coursetitle" placeholder="Course Title">
    <br>
    <input type="number" name="credits" placeholder="credits">
    <br>
    <input type="submit">
</form>
<?php include 'inc/footer.php'; ?>