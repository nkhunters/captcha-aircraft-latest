 <?php
    include "db.php";

    $user_id = $_GET['user_id'];

    $sql = "delete from order_requests where user_id = '$user_id'";
    if ($conn->query($sql)) {

        $sql3 = "select captcha_rate from users where user_id = '$user_id'";
        $result  = $conn->query($sql3);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $captcha_rate = $row['captcha_rate'];

                $sql2 = "update users set right_count = 0, wrong_count = 0, total_earning = total_earning + '$captcha_rate' where user_id = '$user_id'";
                if ($conn->query($sql2)) {

                    $sql5 = "select total_earning from users where user_id = '$user_id'";
                    $result2 = $conn->query($sql5);
                    if ($result2->num_rows > 0) {

                        while ($row2 = $result2->fetch_assoc()) {

                            $total_earning = $row2['total_earning'];

                            $time_sql = "SET time_zone = '+05:30'";
                            $conn->query($time_sql);

                            $sql4 = "insert into order_history (user_id, total_earning, paid_amount, auto_approve) values ('$user_id', $total_earning, $captcha_rate, 0)";

                            if ($conn->query($sql4)) {

                                echo "<script>window.location = 'approverequests.php?n=' + new Date().getTime();</script>";
                            }
                        }
                    }
                }
            }
        }
    }
    $conn->close();
    ?>
        