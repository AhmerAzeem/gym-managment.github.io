<?php

require "config/database.php";

$id = $_POST['id'];

$sql = "UPDATE `members` SET `status`='present' WHERE `id`='$id'";
$sql_result = mysqli_query($connection, $sql);

if(!mysqli_errno($connection)){
    echo "Success";
}else{
    echo "Could't activate member";
}