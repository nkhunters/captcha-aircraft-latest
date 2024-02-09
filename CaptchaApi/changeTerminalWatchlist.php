<?php
session_start();
include "db.php";

$terminal = $_GET['terminal'];
$userIds = $_SESSION['userIds'];


$stmt = "update users set terminal = '$terminal' WHERE user_id in ($userIds)";
if ($conn->query($stmt)) {
   
        header("Location: " . $_SERVER["HTTP_REFERER"]);

}

$conn->close();