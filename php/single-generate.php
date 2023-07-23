<?php
require "config/database.php";

$month_id = $_POST['monthid'];
$year = $_POST['year'];
$id = $_POST['id'];
$name = $_POST['name'];

if (!empty($month_id) && !empty($year) && !empty($id) && !empty($name)) {
    if ($month_id == "Select Month") {
        echo "Please select a month";
    } elseif ($year == "Select Year") {
        echo "Please select a year";
    } else {
        $sql = "SELECT * FROM `pending_payments` WHERE `month`='$month_id' AND `year`='$year' HAVING `memberid`='$id'";
        $sql_result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($sql_result) > 0) {
            echo "Already Exists";
        } else {
            $sql2 = "SELECT * FROM `members` WHERE `id`='$id'";
            $sql2_result = mysqli_query($connection, $sql2);

            $row = mysqli_fetch_assoc($sql2_result);

            $fee = $row['fee'];

            $sql3 = "INSERT INTO `pending_payments` (`memberid`, `name`, `month`, `year`, `amount`, `due_fee`) VALUES ('$id', '$name', '$month_id', '$year', '$fee', '$fee')";
            $sql3_result = mysqli_query($connection, $sql3);
            if (!mysqli_errno($connection)) {
                echo "Success";
            } else {
                echo "Could't generate fee";
            }
        }
    }
} else {
    echo "Fill all fields";
}
