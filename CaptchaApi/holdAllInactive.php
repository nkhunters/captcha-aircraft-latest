<?php

include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];

$password = $_GET['password'];

if ($password == $savedPassword) {
    $sql2 = "SELECT user_id, date_time FROM users where total_earning = 0 AND createdAt <= NOW() - INTERVAL 30 DAY";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        // output data of each row
        $i = 1;
        while ($row2 = $result2->fetch_assoc()) {

            $user_id = $row2['user_id'];
            $stmt = "update users set on_hold = 1 where user_id = '$user_id'";
            if ($conn->query($stmt)) {
            }
        }
    }

    $sql3 = "update hold_inactive set hold = 1";
    if ($conn->query($sql3)) {
        echo "<script>window.location = 'inactiveUsers.php?n=' + new Date().getTime();</script>";
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'inactiveUsers.php?n=' + new Date().getTime();</script>";
}
$conn->close();