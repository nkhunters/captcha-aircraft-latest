<?php

include "db.php";


$sql = "SELECT * FROM deleted_users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $i = 1;
    while ($rowUsers = $result->fetch_assoc()) {

        $user_id = $rowUsers['user_id'];
        $password = $rowUsers['password'];
        $right_count = $rowUsers['right_count'];
        $wrong_count = $rowUsers['wrong_count'];
        $skip_count = $rowUsers['skip_count'];
        $captcha_time = $rowUsers['captcha_time'];
        $extra_time = $rowUsers['extra_time'];
        $captcha_count = $rowUsers['captcha_count'];
        $captcha_rate = $rowUsers['captcha_rate'];
        $unique_id = $rowUsers['unique_id'];
        $total_earning = $rowUsers['total_earning'];
        $auto_approve = $rowUsers['auto_approve'];
        $terminal = $rowUsers['terminal'];
        $platform = $rowUsers['platform'];
        $on_hold = $rowUsers['on_hold'];
        $session_id = $rowUsers['session_id'];
        $date_time = $rowUsers['date_time'];

        $sqlInsertUsers = "insert into users (user_id, password, right_count, wrong_count, skip_count, 
captcha_time, extra_time, captcha_count, captcha_rate, unique_id, total_earning, auto_approve, 
terminal, platform, on_hold, session_id, date_time) values ('$user_id', '$password', $right_count, $wrong_count, $skip_count, $captcha_time,
$extra_time, $captcha_count, $captcha_rate, '$unique_id', $total_earning, $auto_approve, '$terminal', '$platform', $on_hold, '$session_id', '$date_time')";


        if ($conn->query($sqlInsertUsers)) {
            $stmt = "TRUNCATE table deleted_users";
            if ($conn->query($stmt)) {
            }
        }
    }
}
echo "<script>window.location = 'deletedUsers.php?n=' + new Date().getTime() + '&password=1234';</script>";

$conn->close();
