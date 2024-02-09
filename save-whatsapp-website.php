<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

include "db.php";
$stmt = "SET time_zone = '+05:30'";
$conn->query($stmt);
$mobile = $_GET['mobile'];

$sql = "insert into demo_whatsapp_contacts (mobile, platform) values ('$mobile', 'form')";

if (mysqli_query($conn, $sql)) {
    return true;
} else {
    return false;
}

$conn->close();