 <?php

    include "db.php";

    $sql = "select password from lock_passwords where id = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $savedPassword =  $row['password'];
    $password = $_GET['password'];

    if ($password == $savedPassword) {
        $sql = "SELECT * FROM users where total_earning = 0 AND createdAt <= NOW() - INTERVAL 30 DAY";
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

                $sqlInsertUsers = "insert into deleted_users (user_id, password, right_count, wrong_count, skip_count, 
    captcha_time, extra_time, captcha_count, captcha_rate, unique_id, total_earning, auto_approve, 
    terminal, platform, on_hold, session_id, date_time) values ('$user_id', '$password', $right_count, $wrong_count, $skip_count, $captcha_time,
    $extra_time, $captcha_count, $captcha_rate, '$unique_id', $total_earning, $auto_approve, '$terminal', '$platform', $on_hold, '$session_id', '$date_time')";


                if ($conn->query($sqlInsertUsers)) {
                    $stmt = "delete from users where user_id = '$user_id'";
                    if ($conn->query($stmt)) {
                    }
                }
            }
        }
        echo "<script>window.location = 'inactiveUsers.php?n=' + new Date().getTime();</script>";
    } else {
        echo "<script>alert('Invalid password')</script>";
        echo "<script>window.location = 'inactiveUsers.php?n=' + new Date().getTime();</script>";
    }
    $conn->close();
    ?>