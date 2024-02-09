<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sqlTime = "SET time_zone = '+05:30'";
$conn->query($sqlTime);

$filename = "today-users";     //File Name

$curr_date = date("Y-m-d");

$whereCondition = "STR_TO_DATE(date_time, '%d-%b-%Y') = '$curr_date'";

if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

    $startDate = $_GET['start-date'];
    $endDate = $_GET['end-date'];
    $whereCondition = "STR_TO_DATE(date_time, '%d-%b-%Y') >= '$startDate' and STR_TO_DATE(date_time, '%d-%b-%Y') <= '$endDate'";
}

$sql = "SELECT * FROM users WHERE " . $whereCondition;

$sort = "date";
if (isset($_GET['sort']))
    $sort = $_GET['sort'];


if ($sort == "earninghigh")

    $sql = "SELECT * FROM users where " . $whereCondition . " order by total_earning desc";

if ($sort == "earninglow")

    $sql = "SELECT * FROM users where " . $whereCondition . " order by total_earning asc";

if ($sort == "extra-desc")

    $sql = "SELECT * FROM users where " . $whereCondition . " order by extra_time desc";

if ($sort == "extra-asc")

    $sql = "SELECT * FROM users where " . $whereCondition . " order by extra_time asc";

if ($sort == "5dollar") {
    $_SESSION['5dollar'] = "5dollar";
    $sql = "SELECT * FROM users where total_earning > 10 and " . $whereCondition . " order by total_earning desc";
}

if ($sort == "web") {
    $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'web'";
}

if ($sort == "app") {
    $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'app'";
}

if ($sort == "both") {
    $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'both'";
}

if ($sort == "date") {
    $sql = "SELECT *, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users where " . $whereCondition . " order by created_on desc";
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

echo "USER ID" . $sep;
echo "TERMINAL" . $sep;
echo "PLATFORM" . $sep;
echo "CREATED ON" . $sep;
echo "RIGHT CAPTCHA COUNT" . $sep;
echo "WRONG CAPTCHA COUNT" . $sep;
echo "SKIP COUNT" . $sep;
echo "RATE" . $sep;
echo "TOTAL EARNING ($)" . $sep;
echo "CURRENT EARNING ($)" . $sep;

print("\n");
//end of printing column names  
//start while loop to get data
while ($row = $result->fetch_assoc()) {
    $schema_insert = "";

    $userId  = $row['user_id'];
    $terminal = $row["terminal"];
    $platform = $row['platform'];
    $createdOn = $row["date_time"];
    $rightCount = $row["right_count"];
    $wrongCount = $row["wrong_count"];
    $skipCount = $row["skip_count"];
    $rate =  $row["captcha_count"] . " / " . $row["captcha_rate"] . "$";
    $totalEarning = $row["total_earning"];
    $currentEarning = number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', '') .  "$";


    $schema_insert .= "$userId" . $sep;
    $schema_insert .= "$terminal" . $sep;
    $schema_insert .= "$platform" . $sep;
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
