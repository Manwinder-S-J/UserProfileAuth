<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
<div class="container">

    <div class="profile">
        <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
            if(mysqli_num_rows($select)> 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
        ?>
        <h3>Welcome back <?php echo $fetch['name']; ?>!!</h3>
    </div>
</div> 
</body>
</html>