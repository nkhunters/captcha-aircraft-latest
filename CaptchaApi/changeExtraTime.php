<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
include "db.php";

$time = $_POST['time'];
$earning = $_POST["earning"];
$extraTime = $_POST["extraTime"];
$plan = $_POST['plan'];
$offerString = "";

if (isset($plan)) {
    $offerString = " captcha_count = $plan and ";
    if ($plan == 0)
        $offerString = " captcha_count >= 500 and ";
}

$extraTimeString = "";
if ($extraTime > 0)
    $extraTimeString = "extra_time = $extraTime";
else
    $extraTimeString = "extra_time >= 0";

$stmt = "update users set extra_time = '$time' where " . $offerString . " total_earning >= $earning and " . $extraTimeString;

if ($conn->query($stmt)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    // $sql = "update current_terminal set terminal = '$terminal'";
    // if ($conn->query($sql)) {
    //     echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
    // }

}

$conn->close();
