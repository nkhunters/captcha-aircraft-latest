<?php
session_start();
include "db.php";

$terminal = $_GET['terminal'];
$plan = $_GET['plan'];
$offerString = "";

if (isset($plan) && $plan != "") {
    $offerString = " captcha_count = $plan";
    if ($plan == 0)
        $offerString = " captcha_count > 500";
} else  $offerString = " captcha_count > 0";

$stmt = "update users set terminal = '$terminal' where " . $offerString;
if (isset($_GET["earning"])) {
    $earning = $_GET["earning"];
    if ($offerString != "")
        $stmt = "update users set terminal = '$terminal' where " . $offerString . " and total_earning >= $earning";
    else $stmt = "update users set terminal = '$terminal' where total_earning >= $earning";
}

if ($conn->query($stmt)) {
    $sql = "update current_terminal set terminal = '$terminal'";
    if ($conn->query($sql)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}

$conn->close();