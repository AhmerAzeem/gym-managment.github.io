<?php
$connection = new mysqli("localhost", "root", "", "gym_managment");

if (mysqli_errno($connection)) {
    die(mysqli_error($connection));
}
