<?php
require "config/database.php";

$memberid = $_POST['memberid'];

$sql = "SELECT * FROM `pending_payments` WHERE `memberid`='$memberid'";
$sql_result = mysqli_query($connection, $sql);



$output = "";

if (mysqli_num_rows($sql_result) > 0) {
    while (($row = mysqli_fetch_assoc($sql_result))) {
        $monthNum  = $row['month'];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $month = $monthName . " " . $row['year'];
        $output .= "<tr class='recieve__tr'>
                        <td>" . $row['memberid'] . "<input type='hidden' name='memberid' id='memberid' value='" . $row['memberid'] . "'></td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $month . "<input type='hidden' name='feemonth' id='feemonth' value='" . $row['month'] . "'></td>
                        <td>" . $row['amount'] . "<input type='hidden' class='totalamount' value='" . $row['amount'] . "'></td>
                        <td>" . $row['due_fee'] . "<input type='hidden' class='due_fee' value='" . $row['due_fee'] . "'></td>
                        <td>
                            <input type='number' name='receivefee[]' class='form-control txt-edit' data-id='" . $row['id'] . "' data-memberid='" . $row['memberid'] . "' style='max-width: 250px;margin: 5px auto;' />
                        </td>
                    </tr>";
    }
} else {
    $output .= "<tr>
                    <td colspan='6'>
                        <p class='error__message text-center bg-danger text-white w-50' style='margin:0 auto'>No Fee Exists</p>
                    </td>
                </tr>";
}

echo $output;
