<?php

        include "db.php";
        
$user_id = $_GET['user_id'];
$sql = "update users set auto_approve = 1 where user_id = '$user_id'";
if($conn->query($sql))
{
    //echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
$conn->close();
?>