<?php

include 'config.php';

session_start();

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die("query failed");

    if(mysqli_num_rows($select) >0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    } else {
        $message[] = "Incorrect Email or Password!";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if(isset($message)) {
            foreach($message as $message) {
                echo '<div class="message">'.$message.'</div>';
            }
        }
        
        ?>
        <h3>Login</h3>
        <input type="email" name="email" placeholder="Enter Email Address" class="box" required>
        <input type="password" name="password" placeholder="Enter Password" class="box" required>
        <input type="submit" name="submit" value="Login" class="btn">
        <p>Don't have an account?<a href="./register.php">Register now!!</a></p>
    </form>
</div>
    
</body>
</html>