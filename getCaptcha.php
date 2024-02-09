<?php
session_start();
include "db.php";

$user_id = $_SESSION['user_id'];
$captcha = array();

$sql3 = "select right_count, wrong_count, skip_count, captcha_count, terminal, platform, extra_time, on_hold, session_id, total_earning from users where user_id = '$user_id'";
$result2 = $conn->query($sql3);
$row = $result2->fetch_assoc();
$session_id = $row['session_id'];
$captcha['logout'] = "0";
if ($row['platform'] == "app" || $row['on_hold'] == 1 || $session_id != session_id()) {
    $captcha['logout'] = "1";
}
$terminal = $row['terminal'];
$total_earning = $row['total_earning'];
$temp_right_count = $row['right_count'];

// if ($total_earning <= 5) {
//     $terminal = "1";
// }


$sql4 = "select id, image, captcha_type, captcha_text from captchas where terminal in ($terminal) order by RAND() limit 1";

$result3 = $conn->query($sql4);
$row2 = $result3->fetch_assoc();

$captcha['right_count'] = $row['right_count'];
$captcha['wrong_count'] = $row['wrong_count'];
$captcha['skip_count'] = $row['skip_count'];
$captcha['captcha_id'] = $row2['id'];
$captcha['captcha_image'] = $row2['image'];
$captcha['captcha_type'] = $row2['captcha_type'];
$captcha['captcha_count'] = $row['captcha_count'];
$jsonstring = json_encode($captcha);

sleep($row['extra_time']);
echo $jsonstring;

die();
