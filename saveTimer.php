<?php
session_start();
if(isset($_POST['time']))
{
    $time = $_POST['time'];
    $_SESSION['captcha_time'] = $time;
}
die();