<?php

include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];
$password = $_GET['password'];

if ($password == $savedPassword) {

    if (isset($_GET['submit-all'])) {
        $stmt = "update demo_whatsapp_contacts set isDeleted = 1";
        if ($conn->query($stmt)) {
            echo "<script>alert('Numbers deleted successfully')</script>";
            echo "<script>window.location = 'demo-whatsapp-numbers.php';</script>";
        }
    }

    if (isset($_GET['submit-single'])) {
        $id = $_GET['id'];
        $stmt = "update demo_whatsapp_contacts set isDeleted = 1 where id = '$id'";
        
        if ($conn->query($stmt)) {
            echo "<script>alert('Numbers deleted successfully')</script>";
            echo "<script>window.location = 'demo-whatsapp-numbers.php';</script>";
        }
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'demo-whatsapp-numbers.php';</script>";
}
$conn->close();