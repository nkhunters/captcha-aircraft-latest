<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sort = "date";
if (isset($_GET['sort']))
    $sort = $_GET['sort'];
$date = date('Y-m-d');
if (isset($_GET['date']))
    $date = $_GET['date'];
?>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Order History</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <style>
        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontSize: {
                        9: "9px",
                        13: "13px",
                        15: "15px",
                    },
                    spacing: {
                        3.5: "0.875rem",
                        7.5: "1.875rem",
                        six: "6px",
                    },
                    colors: {
                        clifford: "#da373d",
                        blueviolet: "#9134f5",
                        darkslateblue: "#5B7742",
                        //darkslateblue: "#372495",
                        slateblue: "#7d55db",
                        mediumslateblue: "#8655e0",
                        mediumpurpule: "#a059f5",
                        primary: "#fd3a55",
                        primaryLight: "#6F97FF",
                        primaryNormal: "#4037B3",
                        coolGray: "#8493A8",
                        midGray: "#ADB9CA",
                        lightGray: "#CAD3DF",
                        deepBlue: "#18288D",
                        brightYellow: "#FFC13D",
                        lilac: "#95B4FF",
                        indigo: "#4169e1",
                        darkBlue: "#1167b1",
                        EB5757: "#EB5757",
                        DEE8FF: "#DEE8FF",
                        EFEEFB: "#EFEEFB",
                        D7D4F5: "#D7D4F5",
                        B9B6EC: "#B9B6EC",
                        white: "#ffffff",
                        C6D7FF: "#C6D7FF",
                        F5F8FF: "#F5F8FF",
                        BG1364A3: "#1364A3",
                        C4c4c4c: "#4c4c4c",
                        green: "#23A455",
                        lightPink: "#D02F68",
                        semiBlack: "#252424",
                        darkGray: "#4E4E4E",
                        bgWhite: "#f8f8ff",
                        bgBlue: "#0e0e52",
                        DFEFFF: "#DFEFFF",
                        E61A89: "#E61A89",
                        Gold: "#B4833E",
                        lightGold: "#EDD87D",
                        Platinum: "#C7C6C4",
                        lightPlatinum: "#F4F3F1",
                        Brown: "#925F36",
                    },
                    outline: {
                        gray: {
                            400: "#CBCBCB",
                        },
                    },
                    borderWidth: {
                        12: "12px",
                        1: "1px",
                        6: "6px",
                    },
                },
            },
        };
    </script>

</head>

<body style="background-color:#F0F0F0;">

    <?php include 'nav.php'; ?>

    <br>

    <?php

    $sql = "SET time_zone = '+05:30'";
    $conn->query($sql);

    /* $sql_total = "select total_earning from users where user_id = '$user_id'";
        $result = $conn->query($sql_total);
        $row = $result->fetch_assoc();
        $total = $row["total_earning"];*/
    ?>

    <div class="mx-12">

        <h2 class="text-3xl mb-3 font-bold text-red-600">Daily Order History</h2>

        <?php

        $stmt2 = "SELECT count(user_id) as total_earning_auto FROM order_history WHERE auto_approve = 1";
        $result2 = $conn->query($stmt2);
        $row2 = $result2->fetch_assoc();
        $total_auto = $row2['total_earning_auto'];

        $stmt3 = "SELECT count(user_id) as total_earning_manual FROM order_history WHERE auto_approve = 0";
        $result3 = $conn->query($stmt3);
        $row3 = $result3->fetch_assoc();
        $total_manual = $row3['total_earning_manual'];

        ?>
        <div class='row mt-3'>
            <div class='col'>
                <div class="flex flex-col">
                    <h5><strong>Total Auto Approved :- </strong><?= $total_auto; ?> $</h5>
                    <h5><strong>Total Manual Approved :- </strong><?= $total_manual; ?> $</h5>
                </div>
                <?php
                $total_auto_orders = 0;
                $total_manual_orders = 0;

                $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                if (isset($_GET['date'])) {
                    $date = $_GET['date'];
                    $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                }
                $result4 = $conn->query($stmt4);
                while ($row4 = $result4->fetch_assoc()) {
                    if ($row4['auto_approve'] == 0) {
                        $total_manual_orders += $row4['captcha_rate'];
                    } else {
                        $total_auto_orders += $row4['captcha_rate'];
                    }
                }
                ?>
                <h5><strong>Auto Approved Orders (24 Hrs.) :-</strong> <?= $total_auto_orders; ?> $</h5>
                <h5><strong>Manual Approved Orders (24 Hrs.) :-</strong> <?= $total_manual_orders; ?> $</h5>
            </div>
            <div class='col'>
                <?php
                $total_auto_orders_previous = 0;
                $total_manual_orders_previous = 0;

                $prevdate = date('Y-m-d', strtotime("-1 days"));

                $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date) = '$prevdate' and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                if (isset($_GET['date'])) {
                    $date = $_GET['date'];
                    $prevdate = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                    $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date) = '$prevdate' and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                }
                $result4 = $conn->query($stmt4);
                while ($row4 = $result4->fetch_assoc()) {
                    if ($row4['auto_approve'] == 0) {
                        $total_manual_orders_previous += $row4['captcha_rate'];
                    } else {
                        $total_auto_orders_previous += $row4['captcha_rate'];
                    }
                }
                ?>
                <h5><strong>Auto Approved Orders (Yesterday) :-</strong> <?= $total_auto_orders_previous; ?> $</h5>
                <h5><strong>Manual Approved Orders (Yesterday) :-</strong> <?= $total_manual_orders_previous; ?> $</h5>


                <?php
                $total_auto_orders_previous_day = 0;
                $total_manual_orders_previous_day = 0;

                $prevdate = date('Y-m-d', strtotime("-2 days"));

                $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date) = '$prevdate' and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                if (isset($_GET['date'])) {
                    $date = $_GET['date'];
                    $prevdate = date('Y-m-d', strtotime('-2 day', strtotime($date)));
                    $stmt4 = "SELECT order_history.approval_date, order_history.auto_approve, users.total_earning, paid_amount, users.captcha_rate FROM order_history, users WHERE DATE(order_history.approval_date) = '$prevdate' and DATE(order_history.approval_date) = DATE(order_history.order_date) and order_history.user_id = users.user_id";
                }
                $result4 = $conn->query($stmt4);
                while ($row4 = $result4->fetch_assoc()) {
                    if ($row4['auto_approve'] == 0) {
                        $total_manual_orders_previous_day += $row4['captcha_rate'];
                    } else {
                        $total_auto_orders_previous_day += $row4['captcha_rate'];
                    }
                }
                ?>
                <h5><strong>Auto Approved Orders (Day before Yesterday) :-</strong>
                    <?= $total_auto_orders_previous_day; ?> $</h5>
                <h5><strong>Manual Approved Orders (Day before Yesterday) :-</strong>
                    <?= $total_manual_orders_previous_day; ?> $</h5>
            </div>
        </div>
        <br />
        <div class='row'>
            <div class='col'>
                <form action="">
                    <strong>Select Date :- </strong><input type="date" name="date" class="px-3 py-2 rounded-xl bg-white shadow-md" />
                    <input type="submit" class="bg-darkslateblue text-white ml-3 cursor-pointer px-10 rounded-full shadow-xl mt-3 py-2" />
                </form>
            </div>

            <div class='col'>
                <br />
                <a href="export-history-excel.php?date=<?= $date ?>&sort=<?= $sort ?>" class="bg-darkslateblue text-white ml-3 cursor-pointer px-4 shadow-xl py-2">Download
                    Excel</a>
            </div>

            <div class='col'>

                <div class="dropdown show">
                    <a class="btn bg-brightYellow dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </a>

                    <?php
                    $query_param_new = explode("&", $_SERVER['QUERY_STRING'])[0];
                    ?>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'earninghigh'))) ?>">Earning
                            - High to
                            Low</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'earninglow'))); ?>">Earning
                            - Low to
                            High</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'totalearninghigh'))) ?>">Total
                            Earning - High to Low</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'totalearninglow')))  ?>">Total
                            Earning - Low to High</a>

                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'wordshigh'))) ?>">Words -
                            High to Low</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'wordslow')))  ?>">Words -
                            Low to High</a>

                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'more107'))) ?>">Greater than
                            108$</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'less107')))  ?>">Less than
                            107$</a>

                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-asc'))) ?>">Extra
                            time - Low to
                            High</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-desc'))) ?>">Extra
                            time - High to
                            Low</a>

                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                            by
                            Web</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                            by
                            App</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                            by
                            Both</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'words-500'))) ?>">Sort
                            by
                            Words - 500</a>
                        <a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Date</a>

                    </div>
                </div>

            </div>


        </div>

        <?php
        $sql5 = "SELECT count(user_id) as total_earning_in_day FROM order_history WHERE DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) order by id desc";
        if (isset($_GET['date'])) {

            $date = $_GET['date'];
            $sql5 = "SELECT count(user_id) as total_earning_in_day FROM order_history WHERE DATE(order_history.approval_date)= '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) order by id desc";
        }
        $result5 = $conn->query($sql5);
        $row5 = $result5->fetch_assoc();
        ?>

        <?php
        $sql6 = "SELECT * from newHold where id = 1";
        $result6 = $conn->query($sql6);
        $row6 = $result6->fetch_assoc();

        $onHoldBefore = $row6["on_hold"];

        $sql7 = "SELECT * from newHold where id = 2";
        $result7 = $conn->query($sql7);
        $row7 = $result7->fetch_assoc();

        $onHoldAfter = $row7["on_hold"];

        $colorBefore = "btn-primary";
        if ($onHoldBefore == 1)
            $colorBefore = "btn-danger";

        $colorAfter = "btn-primary";
        if ($onHoldAfter == 1)
            $colorAfter = "btn-danger";
        ?>

        <!-- <div class="row">
            <div class="col">
                <a class="btn <?= $colorBefore ?>" href="holdNew.php?param=before&type=hold">Hold Before 5 June</a>
            </div>
            <div class="col">
                <a class="btn btn-primary" href="holdNew.php?param=before&type=unhold">Unhold Before 5 June</a>
            </div>
            <div class="col">
                <a class="btn <?= $colorAfter ?>" href="holdNew.php?param=after&type=hold">Hold After 5 June</a>
            </div>
            <div class="col">
                <a class="btn btn-primary" href="holdNew.php?param=after&type=unhold">Unhold After 5 June</a>
            </div>
        </div> -->

        <?php

        $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";

        if (isset($_GET['date'])) {

            $date = $_GET['date'];
            $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'earninghigh') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning desc";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'extra-asc') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'extra-desc') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time desc";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.extra_time desc";
        }


        if (isset($_GET['sort']) && $_GET['sort'] == 'date') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)= '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }


        if (isset($_GET['sort']) && $_GET['sort'] == 'earninglow') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by daily_earning";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'totalearninghigh') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning desc";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning desc";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'totalearninglow') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by total_earning";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'wordshigh') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count desc";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count desc";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'wordslow') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by users.captcha_count";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'more107') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning >= 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning >= 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'less107') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning < 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.total_earning < 107 and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'app') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'app' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'web') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'web' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'web' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'both') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'both' and order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE users.platform = 'both' and order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) group by order_history.user_id order by order_history.id";
        }

        if (isset($_GET['sort']) && $_GET['sort'] == 'words-500') {
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date) = '$date' and DATE(order_history.approval_date) = DATE(order_history.order_date) and users.captcha_count = 500 group by order_history.user_id order by order_history.id";
            } else
                $sql = "SELECT users.terminal, users.captcha_time, users.extra_time, users.platform, users.date_time, users.captcha_count, users.auto_approve, users.on_hold, order_history.user_id, order_history.order_date, order_history.approval_date, order_history.total_earning, order_history.paid_amount, count(order_history.user_id) as daily_earning FROM order_history, users WHERE order_history.user_id = users.user_id and DATE(order_history.approval_date)=CURDATE() and DATE(order_history.approval_date) = DATE(order_history.order_date) and users.captcha_count = 500 group by order_history.user_id order by order_history.id";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $i = 1;
        ?>


            Total Users - <?= $result->num_rows; ?>
            <br />
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Users.." title="Type in a name">
            <br />
            <table class="w-full table-auto bg-white border-collapse" id="myTable">
                <thead class="border-b">
                    <tr class="hover:bg-gray-100 border-b border-dashed text-center">
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Sr No.</th>
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            User Id</th>

                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Platform</th>
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Words</th>
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Created On</th>

                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Approved On</th>

                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Total Earning ($)</th>
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Daily Earning ($)</th>

                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Captcha time</th>
                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Terminal</th>

                        <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $offerEarning = 0;
                    $redCount = 0;
                    $normalCount = 0;

                    $normalCountBefore = 0;
                    $normalCountAfter = 0;
                    $moreThanDollar = 0;
                    $lessThanDollar = 0;
                    $totalDollar = 0;
                    $totalDailyEarning5 = 0;

                    while ($row = $result->fetch_assoc()) {
                        $totalDollar += $row["daily_earning"];
                        if ($row["total_earning"] >= 108) {
                            if ($row["captcha_count"] == 500)
                                $moreThanDollar += $row["daily_earning"];
                        } else {
                            if ($row["captcha_count"] == 500)
                                $lessThanDollar += $row["daily_earning"];
                        }
                        if (date_format(date_create($row["order_date"]), "d-M-Y h:i:sa") == "30-Nov--0001 12:00:00am") {
                            continue;
                        } else {
                    ?>

                            <tr class="hover:bg-gray-100 border-b border-dashed">
                                <td class="px-2 py-4 text-sm text-center"><?= $i; ?></td>
                                <td class="px-2 py-4 text-sm text-center"><a href="vieworderhistory.php?user_id=<?= $row["user_id"]; ?>"> <?= $row["user_id"]; ?> </a>
                                </td>

                                <td class="px-2 py-4 text-sm text-center"><?= $row["platform"]; ?></td>
                                <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_count"]; ?></td>
                                <?php
                                $dateValue = strtotime($row["date_time"]);

                                $yr = date("Y", $dateValue) . " ";
                                $mon = date("m", $dateValue) . " ";
                                $date = date("d", $dateValue);

                                if ($row["captcha_count"] == 500) {
                                    $offerEarning += $row["daily_earning"];
                                }

                                if ($row["captcha_count"] == 2000 && $date > 4 && $mon > 5 && $yr > 2019) {
                                    $redCount += $row["daily_earning"];;
                                ?>
                                    <td class="px-2 py-4 text-sm text-center" style="color: red">
                                        <?= date_format(date_create($row["date_time"]), "d-M-Y h:i:sa"); ?></td>

                                    <td class="px-2 py-4 text-sm text-center" style="color: red">
                                        <?= date_format(date_create($row["approval_date"]), "d-M-Y h:i:sa"); ?></td>

                                    <td class="px-2 py-4 text-sm text-center" style="color: red"><?= $row["total_earning"]; ?></td>
                                    <td class="px-2 py-4 text-sm text-center" style="color: red"><?= $row["daily_earning"]; ?></td>
                                <?php
                                } else {
                                    $normalCount += $row["daily_earning"];

                                    if ($date > 4 && $mon > 5 && $yr > 2019) {
                                        $normalCountAfter += $row["daily_earning"];
                                    } else {
                                        $normalCountBefore += $row["daily_earning"];
                                    }
                                ?>
                                    <td class="px-2 py-4 text-sm text-center">
                                        <?= date_format(date_create($row["date_time"]), "d-M-Y h:i:sa"); ?></td>

                                    <td class="px-2 py-4 text-sm text-center">
                                        <?= date_format(date_create($row["approval_date"]), "d-M-Y h:i:sa"); ?></td>

                                    <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?></td>
                                    <td class="px-2 py-4 text-sm text-center"><?= $row["daily_earning"]; ?></td>

                                <?php } ?>
                                <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_time"]; ?> sec /
                                    <?= $row['extra_time']; ?> sec</td>
                                <td class="px-2 py-4 text-sm text-center"><?= $row["terminal"]; ?></td>
                                <td class="px-2 py-4 text-sm text-center">

                                    <?php

                                    if ($row['auto_approve'] == 1) {
                                    ?>

                                        <div class="dropdown show">
                                            <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="editUser.php?user_id=<?= $row["user_id"]; ?>">Edit</a>
                                                <a class="dropdown-item" href="removeAutoApprove.php?user_id=<?= $row["user_id"]; ?>">Remove Auto Approve</a>
                                                <?php
                                                if ($row['on_hold'] == 1) {
                                                ?>
                                                    <a class="dropdown-item" href="removeHold.php?user_id=<?= $row["user_id"]; ?>">Remove
                                                        Hold</a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a class="dropdown-item" href="holdUser.php?user_id=<?= $row["user_id"]; ?>">Hold
                                                        User</a>
                                                <?php
                                                }
                                            } else { ?>
                                                <div class="dropdown show">
                                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="editUser.php?user_id=<?= $row["user_id"]; ?>">Edit</a>
                                                        <a class="dropdown-item" href="autoApprove.php?user_id=<?= $row["user_id"]; ?>">Auto Approve</a>
                                                        <?php
                                                        if ($row['on_hold'] == 1) {
                                                        ?>
                                                            <a class="dropdown-item" href="removeHold.php?user_id=<?= $row["user_id"]; ?>">Remove Hold</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a class="dropdown-item" href="holdUser.php?user_id=<?= $row["user_id"]; ?>">Hold User</a>
                                                    </div>
                                                </div>

                                </td>


                            </tr>


        <?php

                                                        }
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }

                                        $conn->close();
        ?>

                </tbody>
            </table>

            <b style="color: green">
                <?php
                $withoutOffer = $offerEarning > $redCount + $normalCount ? $offerEarning - ($redCount + $normalCount) : ($redCount + $normalCount) - $offerEarning;
                ?>
                <!-- <p>Total Earning($) - <?= $redCount + $normalCount; ?></p> -->
                <p>Without offer Earning($) -
                    <?= $withoutOffer; ?>
                </p>
                <p>More than 108$ - <?= $moreThanDollar; ?></p>
                <p>Less than 107$ - <?= $lessThanDollar; ?></p>
                <p>Total ($) - <?= $moreThanDollar + $withoutOffer ?></p>
                <p class="text-blue-600">Total Daily ($) - <?= $moreThanDollar + $lessThanDollar + $withoutOffer ?></p>
                <p class="text-red-600">All Total ($) - <?= $total_auto_orders ?></p>
            </b>

            <script>
                function myFunction() {
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {

                            //alert(td.getElementsByTagName("a")[0].innerHTML.toUpperCase().startsWith(filter));
                            var data = td.getElementsByTagName("a")[0].innerHTML.toUpperCase();
                            if (data.includes(filter)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
    </div>

</body>

</html>