<?php

include "db.php";
$planId = $_GET['plan_id'];
$isEnabled = $_GET['isEnabled'];

$stmt = "update main_website_plans set isEnabled = $isEnabled where id = $planId";
if ($conn->query($stmt)) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

$conn->close();