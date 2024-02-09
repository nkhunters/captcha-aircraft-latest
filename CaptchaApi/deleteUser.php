 <?php

    include "db.php";
    $user_id = $_GET['user_id'];
    $sqlUsers = "select * from users where user_id = '$user_id'";
    $resultUsers = $conn->query($sqlUsers);
    $rowUsers = $resultUsers->fetch_assoc();

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

    $sqlInsertUsers = "insert into deleted_users (user_id, password, right_count, wrong_count, skip_count, 
    captcha_time, extra_time, captcha_count, captcha_rate, unique_id, total_earning, auto_approve, 
    terminal, platform, on_hold, session_id, date_time) values ('$user_id', '$password', $right_count, $wrong_count, $skip_count, $captcha_time,
    $extra_time, $captcha_count, $captcha_rate, '$unique_id', $total_earning, $auto_approve, '$terminal', '$platform', $on_hold, '$session_id', '$date_time')";

    if ($conn->query($sqlInsertUsers)) {
        $sql = "delete from users where user_id = '$user_id'";
        if ($conn->query($sql)) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
           
        }
    }


    $conn->close();
    ?>