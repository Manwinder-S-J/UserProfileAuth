<?php

include 'config.php'

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['confirmPassword']));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register</h3>
        <input type="text" name="name" placeholder="Enter Username" class="box" required>
        <input type="email" name="email" placeholder="Enter Email Address" class="box" required>
        <input type="password" name="password" placeholder="Enter Email Password" class="box" required>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" class="box" required>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="submit" value="Register" class="btn">
        <p>Already have an account?<a href="./login.php">Sign in now!!</a></p>
    </form>
</div>
    
</body>
</html>