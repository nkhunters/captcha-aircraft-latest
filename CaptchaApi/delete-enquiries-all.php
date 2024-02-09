<?php

include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];
$password = $_GET['password'];

if ($password == $savedPassword) {

    if (isset($_GET['submit-all'])) {
        $stmt = "update website_enquiries set isDeleted = 1";
        if ($conn->query($stmt)) {
            echo "<script>alert('Enquiries deleted successfully')</script>";
            echo "<script>window.location = 'main-website-enquiries.php';</script>";
        }
    }

    if (isset($_GET['submit-single'])) {
        $id = $_GET['id'];
        $stmt = "update website_enquiries set isDeleted = 1 where id = '$id'";
       
        if ($conn->query($stmt)) {
            echo "<script>alert('Enquiries deleted successfully')</script>";
            echo "<script>window.location = 'main-website-enquiries.php';</script>";
        }
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'main-website-enquiries.php';</script>";
}
$conn->close();