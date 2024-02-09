<?php
include "db.php";
$sql = "SELECT user_id, date_time, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as converted_date FROM users where total_earning = 0";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $userId = $row['user_id'];
    $convertedDate = $row['converted_date'];
    echo $userId, $convertedDate;

    $stmt = "update users set createdAt = '$convertedDate' where user_id = '$userId'" ;
    if ($conn->query($stmt)) {
        echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
    }
}