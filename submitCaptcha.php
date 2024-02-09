<?php
session_start();
include "db.php";

$user_id = $_SESSION['user_id'];

$captcha_id = $_POST['captcha_id'];
$captcha_text = $_POST['captcha_text'];
$captcha = array();
$is_right = 0;

$sql = "select captcha_text, captcha_type from captchas where id = '$captcha_id'";
$result = $conn->query($sql);
$row3 = $result->fetch_assoc();

if ($captcha_text == '') {
    $sql2 = "update users set wrong_count = wrong_count+1 where user_id = '$user_id'";
    if ($conn->query($sql2)) {
    }
} else {
    if ($row3['captcha_type'] == "Case Sensitive" || $row3['captcha_type'] == "Special Alpha Numeric Case Sensitive") {
        if ($row3['captcha_text'] == $captcha_text) {
            $sql2 = "update users set right_count = right_count+1 where user_id = '$user_id'";
            if ($conn->query($sql2)) {
                $is_right = 1;
            }
        } else {

            $sql2 = "update users set wrong_count = wrong_count+1 where user_id = '$user_id'";
            if ($conn->query($sql2)) {
            }
        }
    } else {
        if (!strcasecmp($row3['captcha_text'], $captcha_text)) {
            $sql2 = "update users set right_count = right_count+1 where user_id = '$user_id'";
            if ($conn->query($sql2)) {
                $is_right = 1;
            }
        } else {

            $sql2 = "update users set wrong_count = wrong_count+1 where user_id = '$user_id'";
            if ($conn->query($sql2)) {
            }
        }
    }
}

$sql3 = "select right_count, wrong_count, skip_count, captcha_count, terminal, platform, on_hold, extra_time, session_id, total_earning from users where user_id = '$user_id'";
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


$sql4;
if ($is_right == 0 && $row3['captcha_type'] == "Calculative")
    $sql4 = "select id, image, captcha_type, captcha_text from captchas where id = $captcha_id";
else if ($terminal == '0')
    $sql4 = "select id, image, captcha_type, captcha_text from captchas order by RAND() limit 1";
else
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
$captcha['is_right'] = $is_right;
$_SESSION['captcha_id'] = $row2['id'];
$jsonstring = json_encode($captcha);

sleep($row['extra_time']);
echo $jsonstring;

die();
