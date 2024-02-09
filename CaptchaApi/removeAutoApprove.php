<?php

        include "db.php";
        
$user_id = $_GET['user_id'];
$sql = "update users set auto_approve = 0 where user_id = '$user_id'";
if($conn->query($sql))
{
    //echo "<script>window.location = 'http://captchabro.website/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$conn->close();
?>