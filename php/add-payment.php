<?php

require "config/database.php";

$memberid = $_POST['memberid'];
$month = $_POST['month'];
$fee = $_POST['fee'];

// Validation

if (!empty($month) && !empty($fee)) {

    // Getting member from database

    $sql = "SELECT * FROM `members` WHERE `id`='$memberid'";
    $sql_result = mysqli_query($connection, $sql);

    $row = mysqli_fetch_assoc($sql_result);

    $total_fee = $row['fee'];
    $fname = $row['fname'];
    $lname = $row['lname'];

    $fullname = $fname . " " . $lname;
    $due_fee = $total_fee - $fee;

    // If member has already paid

    $sql2 = "SELECT * FROM `payments` WHERE `memberid`='$memberid' AND `date`='$month'";
    $sql2_result = mysqli_query($connection, $sql2);

    if (mysqli_num_rows($sql2_result) > 0) {
        $row2 = mysqli_fetch_assoc($sql2_result);
        $db_fee = $row2['fee'];

        $db_date = $row2['date'];

        // if full fee paid

        if ($db_fee == $fee) {
            echo "Payment already exists";
        } else {
            // if full fee not paid

            $update_date = date("Y-m-d");

            $sql4 = "UPDATE `payments` SET `fee`='$fee', `due_fee`='$due_fee', `updated_at`='$update_date' WHERE `memberid`='$memberid' AND `date`='$month'";
            $sql4_result = mysqli_query($connection, $sql4);

            if ($sql4_result) {
                echo "Success";
            }
        }
    } else {
        // if member has no payment
        $sql3 = "INSERT INTO `payments` (`memberid`, `name`, `date`, `fee`, `due_fee`) VALUES ('$memberid', '$fullname', '$month', '$fee', '$due_fee')";
        $sql3_result = mysqli_query($connection, $sql3);
        if (!mysqli_errno($connection)) {
            echo "Success";
        } else {
            echo "Could't add payment";
        }
    }
} else {
    echo "Fill all fields";
}
