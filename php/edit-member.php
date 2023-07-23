<?php

require "config/database.php";

$memberid = $_POST['memberid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$email = $_POST['email'];
$fee = $_POST['fee'];

if (!empty($fname) && !empty($lname) && !empty($contact) && !empty($address) && !empty($email) && !empty($fee)) {
    // Email Validation
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE `members` SET `fname`='$fname', `lname`='$lname', `contact`='$contact', `address`='$address', `email`='$email', `fee`='$fee' WHERE `id`='$memberid'";
        $sql_result = mysqli_query($connection, $sql);
    } else {
        echo $email . "- is not a valid email";
    }

    if (!mysqli_errno($connection)) {
        echo "Success";
    } else {
        echo "Could't update member";
    }
} else {
    echo "Fill all fields";
}
