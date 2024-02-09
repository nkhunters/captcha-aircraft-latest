<?php
session_start();

include "db.php";

$user_id = $_SESSION['user_id'];
$captcha_id = $_POST['captcha_id'];


$right_count = $_SESSION['right_count'];
$wrong_count = $_SESSION['wrong_count'];
$captcha_count = $_SESSION['captcha_count'];
$skip_count_old = $_SESSION['skip_count'];
$_SESSION['skip_count'] = $skip_count_old + 1;
$skip_count = $_SESSION['skip_count'];
$total_earning = $_SESSION['total_earning'];
$terminal = "999";

$captcha = array();
$captcha['logout'] = "0";

$sql = "select captcha_text, captcha_type from captchas where id = '$captcha_id'";
$result = $conn->query($sql);
$row3 = $result->fetch_assoc();


$sql4;
if ($row3['captcha_type'] == "Calculative")
    $sql4 = "select id, image, captcha_type, captcha_text from captchas where id = $captcha_id";
else
    $sql4 = "select id, image, captcha_type, captcha_text from captchas where terminal in ($terminal) order by RAND() limit 1";

$result3 = $conn->query($sql4);
$row2 = $result3->fetch_assoc();

$captcha['right_count'] = $right_count;
$captcha['wrong_count'] = $wrong_count;
$captcha['skip_count'] = $skip_count;
$captcha['captcha_id'] = $row2['id'];
$captcha['captcha_image'] = $row2['image'];
$captcha['captcha_type'] = $row2['captcha_type'];
$captcha['captcha_words'] = strlen($row2['captcha_text']);
$captcha['captcha_count'] = $captcha_count;
$_SESSION['captcha_id'] = $row2['id'];
$jsonstring = json_encode($captcha);

//sleep(1);
echo $jsonstring;

die();