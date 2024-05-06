<?php

include 'config.php';

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['confirmPassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/'.$image;

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email='$email' AND password='$password'") or die("query failed");

    if(mysqli_num_rows($select) >0) {
        $message[] = 'User already exist!';
    }else {
        if($password != $cpassword) {
            $message[] = 'Passwords do not match!';
        }elseif($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        }else{
            $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$password', '$image')") or die("query failed!");
            
            if($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'registered successfully';
                header('location:login.php');
            } else{
                $message[] = 'registration failed';
            }
        
        }
    }


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
        <?php
        if(isset($message)) {
            foreach($message as $message) {
                echo '<div class="message">'.$message.'</div>';
            }
        }
        
        ?>
        <h3>Register</h3>
        <input type="text" name="name" placeholder="Enter Username" class="box" required>
        <input type="email" name="email" placeholder="Enter Email Address" class="box" required>
        <input type="password" name="password" placeholder="Enter Password" class="box" required>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" class="box" required>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="submit" value="Register" class="btn">
        <p>Already have an account?<a href="./login.php">Sign in now!!</a></p>
    </form>
</div>
    
</body>
</html>