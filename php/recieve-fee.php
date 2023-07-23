<?php
require "config/database.php";

// Getting input data

$receivefee = $_POST["recieveFee"];
$feeId = $_POST["feeId"];
$memberid = $_POST['memberid'];

// Getting Generated fee data

$sql = "SELECT * FROM `pending_payments` WHERE `id`='$feeId' AND `memberid`='$memberid'";
$sql_result = mysqli_query($connection, $sql);


while ($row = mysqli_fetch_assoc($sql_result)) {
    $memberid = $row['memberid'];
    $name = $row['name'];
    $month = $row['month'];
    $year = $row['year'];
    $amount = $row['amount'];
    $due_fee = $row['due_fee'];
    $created_at = $row['created_at'];
    // Checking if recieve fee is greater than due fee
    if ($receivefee > $due_fee) {
        echo "Fee should be less than or equal to due fee";
    } else {
        // If half payment is paid
        $sql2 = "SELECT * FROM `payments` WHERE `feeid`='$feeId'";
        $sql2_result = mysqli_query($connection, $sql2);

        if (mysqli_num_rows($sql2_result) > 0) {
            $row2 = mysqli_fetch_assoc($sql2_result);

            $oldfee = $row2['fee'];

            $newfee = $oldfee + $receivefee;
            $updated_at = date("Y-m-d");

            // Updating payments

            $sql3 = "UPDATE `payments` SET `fee`='$newfee', `updated_at`='$updated_at' WHERE `feeid`='$feeId'";
            $sql3_result = mysqli_query($connection, $sql3);

            $newduefee = $due_fee - $receivefee;

            // Updating Generated fee

            $sql4 = "UPDATE `pending_payments` SET `due_fee`='$newduefee' WHERE id=$feeId";
            $sql4_result = mysqli_query($connection, $sql4);

            if ($newduefee == 0) {
                $sql5 = "DELETE FROM `pending_payments` WHERE `due_fee`=0";
                $sql5_result = mysqli_query($connection, $sql5);
            }

            if (!mysqli_errno($connection)) {
                echo "Success";
            } else {
                echo "Could add fee";
            }
        } else {
            $sql6 = "INSERT INTO `payments` (`memberid`, `feeid`, `name`, `month`, `year`, `fee`, `created_at`) VALUES ('$memberid', '$feeId', '$name', '$month', '$year', '$receivefee', '$created_at')";
            $sql6_result = mysqli_query($connection, $sql6);

            $new_duefee = $due_fee - $receivefee;

            $sql7 = "UPDATE `pending_payments` SET `due_fee`='$new_duefee' WHERE `id`='$feeId'";
            $sql7_result = mysqli_query($connection, $sql7);

            if ($new_duefee == 0) {
                $sql8 = "DELETE FROM `pending_payments` WHERE `due_fee`='0'";
                $sql8_result = mysqli_query($connection, $sql8);
            }

            if (!mysqli_errno($connection)) {
                echo "Success";
            } else {
                echo "Could add fee";
            }
        }
    }
}
