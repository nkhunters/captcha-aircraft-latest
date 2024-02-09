<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sqlTime = "SET time_zone = '+05:30'";
$conn->query($sqlTime);

$filename = "users-earning-wise";     //File Name

$plan = $_GET['plan'];
$earning = $_GET['earning'];
$extraTime = isset($_GET['time']) ? $_GET['time'] : 0;

$planString = "";
if (isset($plan)) {
    $planString = " captcha_count = $plan and on_hold = 0 and ";
    if ($plan == 0)
        $planString = " captcha_count > 500 and on_hold = 0 and ";
}

$extraTimeString = "";
if ($extraTime > 0)
    $extraTimeString = "extra_time = $extraTime";
else
    $extraTimeString = "extra_time >= 0";


$sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString";

$sort = 'date';
if (isset($_GET['sort']))
    $sort = $_GET['sort'];

if ($sort == 'earninghigh') {
    $earningSort = "desc";
}

if ($sort == 'earninglow') {
    $earningSort = "asc";
}

if ($sort == "extra-asc")
    $sortTime = "asc";
if ($sort == "extra-desc")
    $sortTime = "desc";

if (isset($earningSort)) {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString order by total_earning " . $earningSort;
}

if (isset($sortTime)) {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString order by extra_time " . $sortTime;
}

if ($sort == "5dollar") {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString and total_earning > 10 order by total_earning desc";
}

if ($sort == "web") {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString and platform = 'web'";
}

if ($sort == "app") {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString and platform = 'app'";
}

if ($sort == "both") {
    $sql = "SELECT * FROM users WHERE " . $planString . " total_earning >= $earning and $extraTimeString and platform = 'both'";
}

if ($sort == "date") {
    $sql = "SELECT *, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users  WHERE " . $planString . " total_earning >= $earning and $extraTimeString order by created_on desc";
}



$result = $conn->query($sql);
$file_ending = "xls";
//header info for browser
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=$filename.csv");
header("Pragma: no-cache");
header("Expires: 0");
/*******Start of Formatting for Excel*******/
//define separator (defines columns in excel & tabs in word)
$sep = ","; //tabbed character
//start of printing column names as names of MySQL fields

echo "User Id" . $sep;
echo "Terminal" . $sep;
echo "Platform" . $sep;
echo "Captcha Time" . $sep;
echo "Extra Time" . $sep;
echo "Created On" . $sep;
echo "Right Captcha Count" . $sep;
echo "Wrong Captcha Count" . $sep;
echo "Skip Captcha Count" . $sep;
echo "Rate" . $sep;
echo "Total Earning" . $sep;
echo "Current Earning" . $sep;

print("\n");
//end of printing column names  
//start while loop to get data
while ($row = $result->fetch_assoc()) {
    $schema_insert = "";

    $userId  = $row["user_id"];
    $terminal = $row['terminal'] == 0 ? "Mix" : $row['terminal'];
    $platform  = $row['platform'];
    $captchaTime  = $row['captcha_time'];
    $extraTime  = $row['extra_time'];
    $createdOn = date_format(date_create($row["date_time"]), "d-M-Y h:i:sa");
    $rightCount = $row['right_count'];
    $wrongCount = $row['wrong_count'];
    $skipCount = $row['skip_count'];
    $rate = $row['captcha_count'] . " " . $row['captcha_rate'] . " $";
    $totalEarning = $row['total_earning'];
    $currentEarning = number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', '') . " $";

    $schema_insert .= "$userId" . $sep;
    $schema_insert .= "$terminal" . $sep;
    $schema_insert .= "$platform" . $sep;
    $schema_insert .= "$captchaTime" . $sep;
    $schema_insert .= "$extraTime" . $sep;
    $schema_insert .= "$createdOn" . $sep;
    $schema_insert .= "$rightCount" . $sep;
    $schema_insert .= "$wrongCount" . $sep;
    $schema_insert .= "$skipCount" . $sep;
    $schema_insert .= "$rate" . $sep;
    $schema_insert .= "$totalEarning" . $sep;
    $schema_insert .= "$currentEarning" . $sep;

    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= $sep;
    print(trim($schema_insert));
    print "\n";
}

$conn->close();
