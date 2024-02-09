<?php
session_start();
include "db.php";

$time = $_GET['time'];
$isOffer = $_GET['offer'];
$offerString = "";

if (isset($plan)) {
    $offerString = " captcha_count = $plan and ";
    if ($plan == 0)
        $offerString = " captcha_count > 500 and ";
}

$stmt = "update users set captcha_time = '$time' where ".$offerString." total_earning > 5";
if(isset($_GET["earning"]))
{
    $earning = $_GET["earning"];
    $stmt = "update users set captcha_time = '$time' where ".$offerString." total_earning >= $earning";
}
if ($conn->query($stmt)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    // $sql = "update current_terminal set terminal = '$terminal'";
    // if ($conn->query($sql)) {
    //     echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
    // }

}

$conn->close();