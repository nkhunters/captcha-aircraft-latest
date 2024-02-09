<?php

        include "db.php";
        
$id = $_GET['id'];
$sql = "delete from order_history where id = '$id'";
if($conn->query($sql))
{
    /*if(isset($_GET['inactive']))
        echo "<script>window.location = 'http://captchabro.website/CaptchaApi/inactiveUsers.php?n=' + new Date().getTime();</script>";
    else
        echo "<script>window.location = 'http://captchabro.website/CaptchaApi/viewusers.php?n=' + new Date().getTime();</script>";*/
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$conn->close();
