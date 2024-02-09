<?php

include "db.php"; 
$sql = "update websitestatus set web_status = 0";
if($conn->query($sql))
{
    echo("<script>alert('Website Disabled !!')</script>");
    echo "<script>window.location = 'http://aircraftcaptchaservices.com/aircraft/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();
?>