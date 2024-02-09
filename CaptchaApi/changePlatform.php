<?php

include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];

$platform = $_GET['platform'];
$plan = $_GET['plan'];
$earning = $_GET['earning'];
$time = $_GET['time'];
$password = $_POST['password'];

if ($password == $savedPassword) {
    $offerString = "";

    if (isset($plan) && $plan != "") {
        $offerString = " captcha_count = $plan";
        if ($plan == 0)
            $offerString = " captcha_count > 500";
    } else  $offerString = " captcha_count > 0";

    $stmt = "update users set platform = '$platform' where " . $offerString;
    if (isset($_GET["earning"])) {
        $earning = $_GET["earning"];
        if ($offerString != "")
            $stmt = "update users set platform = '$platform' where " . $offerString . " and total_earning >= $earning";
        else $stmt = "update users set platform = '$platform' where total_earning >= $earning";
    }

    if ($conn->query($stmt)) {
        $sql = "update current_platform set platform = '$platform'";
        // if ($offerString != "") {
        //     $sql = "update current_platform_plan_wise set platform = '$platform' where " . $offerString;
        // }

        if ($conn->query($sql))
            header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>history.back()</script>";
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$conn->close();