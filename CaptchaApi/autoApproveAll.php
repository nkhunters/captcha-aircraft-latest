<?php

include "db.php";

$stmt = "update users set auto_approve = 1";
if($conn->query($stmt))
{
$sql = "update auto_approve set is_enabled = 1";
if($conn->query($sql))
echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();