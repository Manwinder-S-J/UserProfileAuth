<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
};


if(isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('Query failed');

    $old_password = $_POST['old_password'];
    $update_password = mysqli_real_escape_string($conn, md5($_POST['update_password']));
    $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

    if(!empty($update_password) || !empty($new_password) || !empty($confirm_password)) {
        if($update_password != $old_password) {
            $message[] = 'Old password do not match!';
        }elseif($new_password != $confirm_password) {
            $message[] = 'Confirm password do not match!';
        } else {
            mysqli_query($conn, "UPDATE `user_form` SET password = '$new_password' WHERE id = '$user_id'") or die('Query failed');
            $message[] = 'Password updated successfully!';
        }
    }

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploads/'.$update_image;

    if(!empty($update_image)) {
        if($update_image_size > 2000000) {
            $message[] = 'Image is too large!';
        }else {
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('Query failed');
            if($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'Image updated successfully!';
        }
    }


}

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
    <div class="update-profile">
        <?php
            $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
            if(mysqli_num_rows($select)> 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <?php 
                if($fetch['image'] == '') {
                    echo '<img src="./images/default.png">';
                }else {
                    echo '<img src="./uploads/'.$fetch['image'].'">';
                }
                if(isset($message)) {
                    foreach($message as $message) {
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
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
                    <input type="hidden" name="old_password" value="<?php echo $fetch['password'] ?>">
                    <span>Old Password: </span>
                    <input type="password" name="update_password" placeholder="Enter previous password" class="box">
                    <span>New Password: </span>
                    <input type="password" name="new_password" placeholder="Enter new password" class="box">
                    <span>Confirm new Password: </span>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" class="box">
                </div>
            </div>
            <input type="submit" name="update_profile" value="Update Profile" class="btn">
            <a href="home.php" id="back-btn">Go Back</a>

        </form>
    </div>
</body>
</html>