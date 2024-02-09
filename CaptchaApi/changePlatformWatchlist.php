<?php
session_start();
include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];

$platform = $_GET['platform'];
$userIds = $_SESSION['userIds'];

$password = $_POST['password'];

if ($password == $savedPassword) {
    $stmt = "update users set platform = '$platform' WHERE user_id in ($userIds)";
    

    if ($conn->query($stmt)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

$conn->close();