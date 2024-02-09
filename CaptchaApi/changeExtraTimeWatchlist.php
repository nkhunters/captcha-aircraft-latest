<?php
session_start();
include "db.php";

$time = $_POST['time'];
$userIds = $_SESSION['userIds'];

$stmt = "update users set extra_time = '$time' WHERE user_id in ($userIds)";

if ($conn->query($stmt)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    // $sql = "update current_terminal set terminal = '$terminal'";
    // if ($conn->query($sql)) {
    //     echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
    // }

}

$conn->close();