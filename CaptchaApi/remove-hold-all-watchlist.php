<?php
session_start();
include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];

$plan = $_GET['plan'];
$earning = $_GET['earning'];
$time = $_GET['time'];
$password = $_GET['password'];

$userIds = $_SESSION['userIds'];

if ($password == $savedPassword) {
    $stmt = "update users set on_hold = 0 WHERE user_id in ($userIds)";
   
    if ($conn->query($stmt)) {
        echo "<script>alert('All users un holded')</script>";
            echo "<script>window.location = 'watchlist.php?n=' + new Date().getTime();</script>";
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'watchlist.php?n=' + new Date().getTime();</script>";
}



$conn->close();