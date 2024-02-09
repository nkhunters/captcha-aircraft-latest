<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sqlTime = "SET time_zone = '+05:30'";
$conn->query($sqlTime);

$filename = "history";     //File Name


$sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";

if (isset($_GET['date'])) {

    $date = $_GET['date'];
    $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
}


if (isset($_GET['sort']) && $_GET['sort'] == 'earninghigh') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'extra-asc') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'extra-desc') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time desc";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time desc";
}


if (isset($_GET['sort']) && $_GET['sort'] == 'date') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)= '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}


if (isset($_GET['sort']) && $_GET['sort'] == 'earninglow') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'totalearninghigh') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning desc";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning desc";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'totalearninglow') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'wordshigh') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count desc";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count desc";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'wordslow') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'more107') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning >= 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning >= 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'less107') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning < 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning < 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'app') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'app') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'web') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'web' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'web' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
}

if (isset($_GET['sort']) && $_GET['sort'] == 'both') {
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'both' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
    } else
        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'both' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
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
echo "PLATFORM" . $sep;
echo "WORDS" . $sep;
echo "CREATED ON" . $sep;
echo "APPROVED ON" . $sep;
echo "TOTAL EARNING ($)" . $sep;
echo "DAILY EARNING ($)" . $sep;
echo "CAPTCHA TIME" . $sep;
echo "TERMINAL" . $sep;

print("\n");
//end of printing column names  
//start while loop to get data
while ($row = $result->fetch_assoc()) {
    $schema_insert = "";

    $userId  = $row['user_id'];
    $platform = $row['platform'];
    $words = $row["captcha_count"];
    $createdOn = date_format(date_create($row["date_time"]), "d-M-Y h:i:sa");
    $approvedOn = date_format(date_create($row["approval_date"]), "d-M-Y h:i:sa");
    $totalEarning = $row["total_earning"];
    $dailyEarning = $row['daily_earning'];
    $captchaTime = $row["captcha_time"] . " sec / "
        . $row['extra_time'] . " sec";
    $terminal = $row["terminal"];

    $schema_insert .= "$userId" . $sep;
    $schema_insert .= "$platform" . $sep;
    $schema_insert .= "$words" . $sep;
    $schema_insert .= "$createdOn" . $sep;
    $schema_insert .= "$approvedOn" . $sep;
    $schema_insert .= "$totalEarning" . $sep;
    $schema_insert .= "$dailyEarning" . $sep;
    $schema_insert .= "$captchaTime" . $sep;
    $schema_insert .= "$terminal" . $sep;


    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= $sep;
    print(trim($schema_insert));
    print "\n";
}
