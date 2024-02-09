<?php

include "db.php"; 
$sql = "update websitestatus set app_status = 1";
if($conn->query($sql))
{
    echo("<script>alert('App Enabled !!')</script>");
    echo "<script>window.location = 'http://aircraftcaptchaservices.com/aircraft/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();
