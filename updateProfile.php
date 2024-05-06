<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpdateProfile</title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class="update profile">
        <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
            if(mysqli_num_rows($select)> 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['image'] == '') {
                echo '<img src="./images/default.png">';
            }else {
                echo '<img src="./uploads/'.$fetch['image'].'">';
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Username: </span>
                    <input type="text" name="update_name" value="<?php echo $fetch['name'] ?>" class="box">
                    <span>Email Address: </span>
                    <input type="email" name="update_email" value="<?php echo $fetch['email'] ?>" class="box">
                    <span>Profile Picture: </span>
                    <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_name" value="<?php echo $fetch['password'] ?>">
                    <span>Old Password</span>
                    <input type="password" name="update_password" placeholder="enter previous password" class="box">
                    <span>Old Password</span>
                    <input type="password" name="update_password" placeholder="enter previous password" class="box">
                    <span>Old Password</span>
                    <input type="password" name="update_password" placeholder="enter previous password" class="box">
                </div>
            </div>

        </form>
    </div>
</body>
</html>