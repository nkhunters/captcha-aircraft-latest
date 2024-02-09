<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

if (isset($_POST['edit-entry'])) {
    $id = $_POST['id'];
    $total_earning = $_POST['total_earning'];
    $status = $_POST['status'];
    $stmt = "update order_history set status = '$status', total_earning = '$total_earning' where id = '$id'";

    if ($conn->query($stmt)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    $conn->close();
}

if (isset($_POST['edit-total'])) {
    $userId = $_POST['userId'];
    $total_earning = $_POST['total_earning'];

    $stmt = "update users set total_earning = '$total_earning' where user_id = '$userId'";

    if ($conn->query($stmt)) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    $conn->close();
}
