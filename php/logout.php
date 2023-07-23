<?php

session_start();
include_once "config/database.php";
if (isset($_SESSION['unique_id'])) {
    $logout_id = mysqli_real_escape_string($connection, $_GET['logout_id']);
    if (isset($logout_id)) {
        session_unset();
        session_destroy();
        header('location: ../index.php');
    } else {
        header('location: ../dashboard.php');
    }
} else {
    header('location: ../login.php');
}
