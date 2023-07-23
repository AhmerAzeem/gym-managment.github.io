<?php
session_start();
require "./config/database.php";

$username_or_email = $_POST['emailOrUsername'];
$password = $_POST['password'];

if (!empty($username_or_email) && !empty($password)) {
    $fetch_user_query = "SELECT * FROM `user_admin` WHERE `email`='$username_or_email' OR `username`='$username_or_email' AND `password`='$password'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);
    if (mysqli_num_rows($fetch_user_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_user_result);


        $_SESSION['unique_id'] = $row['unique_id'];
        echo "Success";
    } else {
        echo "No user found";
    }
} else {
    echo "Fill out all fields";
}
