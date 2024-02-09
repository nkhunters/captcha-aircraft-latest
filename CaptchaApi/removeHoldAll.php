<?php

include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];

$password = $_GET['password'];
$plan = $_GET['plan'];
$earning = $_GET['earning'];
$time = $_GET['time'];

if ($password == $savedPassword) {
    $stmt = "update users set on_hold = 0";
    if (isset($plan))
        $stmt = "update users set on_hold = 0 where captcha_count = $plan and total_earning >= $earning and extra_time = $time";
    if ($conn->query($stmt)) {
        $sql = "update hold set on_hold = 0";
        if ($conn->query($sql))
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();