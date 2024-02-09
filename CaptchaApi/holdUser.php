<?php

        include "db.php";
        
$user_id = $_GET['user_id'];
$sql = "update users set on_hold = 1 where user_id = '$user_id'";
if($conn->query($sql))
{
    /*if(isset($_GET['inactive']))
        echo "<script>window.location = 'http://captchabro.website/CaptchaApi/inactiveUsers.php?n=' + new Date().getTime();</script>";
    else
        echo "<script>window.location = 'http://captchabro.website/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";*/
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$conn->close();
?>