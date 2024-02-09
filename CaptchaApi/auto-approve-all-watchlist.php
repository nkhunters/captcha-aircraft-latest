<?php

include "db.php";

$userIds = $_POST['userIds'];

$stmt = "update users set auto_approve = 1 WHERE user_id in ($userIds)";
if($conn->query($stmt))
{
echo "<script>alert('Auto approve enabled for all');</script>";
echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();