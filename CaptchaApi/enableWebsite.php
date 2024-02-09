<?php

include "db.php"; 
$sql = "update websitestatus set web_status = 1";
if($conn->query($sql))
{
    echo("<script>alert('Website Enabled !!')</script>");
    echo "<script>window.location = 'http://aircraftcaptchaservices.com/aircraft/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();
?>