<?php

include "db.php";

$stmt = "update users set auto_approve = 0";
if ($conn->query($stmt)) {
    $sql = "update auto_approve set is_enabled = 0";
    if ($conn->query($sql))
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

$conn->close();