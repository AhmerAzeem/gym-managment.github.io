<?php

require "config/database.php";

$month_id = $_POST['monthid'];
$year = $_POST['year'];

if (!empty($month_id) && !empty($year)) {
    if ($month_id == "Select Month") {
        echo "Please select a month";
    } elseif ($year == "Select Year") {
        echo "Please select a year";
    } else {
        $sql = "SELECT * FROM `members` WHERE `status`='present'";
        $sql_result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($sql_result) > 0) {
            $sql2 = "SELECT * FROM `pending_payments` WHERE `month`='$month_id' AND `year`='$year'";
            $sql2_result = mysqli_query($connection, $sql2);

            $sql3 = "SELECT * FROM `payments` WHERE `month`='$month_id' AND `year`='$year'";
            $sql3_result = mysqli_query($connection, $sql3);

            if (mysqli_num_rows($sql2_result) > 0) {
                echo "Already Generated";
            } elseif (mysqli_num_rows($sql3_result) > 0) {
                echo "Already Generated";
            } else {
                while ($row = mysqli_fetch_assoc($sql_result)) {
                    $memberid = $row['id'];
                    $name = $row['fname'] . " " . $row['lname'];
                    $amount = $row['fee'];

                    $sql4 = "INSERT INTO `pending_payments` (`memberid`, `name`, `month`, `year`, `amount`, `due_fee`) VALUES ('$memberid', '$name', '$month_id', '$year', '$amount', '$amount')";
                    $sql4_result = mysqli_query($connection, $sql4);
                }

                if (!mysqli_errno($connection)) {
                    echo "Success";
                } else {
                    echo "Could Generate";
                }
            }
        } else {
            echo "No Member found";
        }
    }
} else {
    echo "Fill all fields";
}
