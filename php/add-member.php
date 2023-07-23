<?php

require "config/database.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$email = $_POST['email'];
$fee = $_POST['fee'];

if (!empty($fname) && !empty($lname) && !empty($contact) && !empty($address) && !empty($email) && !empty($fee)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM `members` WHERE `email`='$email'";
        $sql_result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($sql_result) > 0) {
            echo "Email is already taken";
        } else {
            $sql2 = "INSERT INTO members (`fname`, `lname`, `contact`, `address`, `email`, `fee`, `status`) VALUES ('$fname', '$lname', '$contact', '$address', '$email', '$fee', 'present')";
            $sql2_result = mysqli_query($connection, $sql2);
            if (!mysqli_errno($connection)) {
                echo "Success";
            } else {
                echo "Could't add member";
            }
        }
    } else {
        echo $email . "- is not a valid email";
    }
} else {
    echo "Fill all fields";
}
