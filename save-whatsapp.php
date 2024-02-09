<?php
include "db.php";
$stmt = "SET time_zone = '+05:30'";
$conn->query($stmt);
if (isset($_POST['submit'])) {


    $mobile = $_POST['mobile'];

    $sql = "insert into demo_whatsapp_contacts (mobile, platform) values ('$mobile', 'web')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            localStorage.setItem('numberSaved', '1');
            window.location = 'demo.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


    $conn->close();
}