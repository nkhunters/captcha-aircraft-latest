<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}

include "db.php";
?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Approve Requests</title>

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


    <!-- Modal -->
    <div class="modal fade" id="approveAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve all</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Approve all ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="approveall.php" type="button"
                        class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3">Yes approve!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="approveUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Approve user ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="approveall.php" type="button"
                        class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3">Yes approve!</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'nav.php'; ?>


    <br><br>
    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold">Next Order Requests</h2>

        <?php
        $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id order by order_id asc";

        $sort = 'date';
        if (isset($_GET['sort']))
            $sort = $_GET['sort'];

        if ($sort == 'earninghigh') {
            $earningSort = "desc";
        }

        if ($sort == 'earninglow') {
            $earningSort = "asc";
        }

        if ($sort == "extra-asc")
            $sortTime = "asc";
        if ($sort == "extra-desc")
            $sortTime = "desc";


        if (isset($earningSort)) {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id order by total_earning " . $earningSort;
        }

        if (isset($sortTime)) {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id order by extra_time " . $sortTime;
        }

        if ($sort == "5dollar") {

            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users WHERE users.user_id = order_requests.user_id and total_earning > 10 order by total_earning desc";
        }

        if ($sort == "web") {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id and platform = 'web'";
        }

        if ($sort == "app") {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id and platform = 'app'";
        }

        if ($sort == "both") {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id and platform = 'both'";
        }

        if ($sort == "date") {
            $sql = "SELECT order_requests.user_id, total_earning, captcha_time, extra_time, platform, order_date FROM order_requests, users where users.user_id = order_requests.user_id order by order_id asc";
        }


        $result = $conn->query($sql);
        ?>

        <h3>Total Requests :- <?= $result->num_rows; ?></h3>

        <br>


        <div class="row">

            <div class="col">
                <a data-toggle="modal" href="#approveAllModal" class="btn btn-primary a-btn-slide-text">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    <span><strong>Approve All</strong></span>
                </a>
            </div>
            <div class="col">
                <div class="dropdown show">
                    <a class="btn bg-brightYellow dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <?php
                        $query_param_new = explode("&", $_SERVER['QUERY_STRING'])[0];
                        ?>

                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninghigh')))  ?>">Earning
                            - High
                            to Low</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninglow'))) ?>">Earning
                            - Low to
                            High</a>

                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-asc'))) ?>">Extra
                            time - Low to
                            High</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-desc'))) ?>">Extra
                            time - High to
                            Low</a>

                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => '5dollar'))) ?>">Earning
                            greater than
                            10 $</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                            by
                            Web</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                            by
                            App</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                            by
                            Both</a>
                        <a class="dropdown-item"
                            href="approverequests.php?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Date
                        </a>

                    </div>
                </div>

            </div>
        </div>
        <br>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Users.." title="Type in a name">

        <table class="w-full table-auto bg-white border-collapse" id="myTable">
            <thead class="border-b">
                <tr class="hover:bg-gray-100 border-b border-dashed text-center">
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Sr No.</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        User Id</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Total Earning</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Captcha Time</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Platform</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Order Date</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Time Taken</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Approve</th>
                </tr>
            </thead>
            <tbody>

                <?php

                // output data of each row
                $i = 1;
                while ($row = $result->fetch_assoc()) {

                ?>

                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center"><?= $i; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><a
                            href="vieworderhistory.php?user_id=<?= $row["user_id"]; ?>"><?= $row["user_id"]; ?></a></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?> $</td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_time"]; ?> sec /
                        <?= $row['extra_time']; ?> sec</td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["platform"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center">
                        <?= date_format(date_create($row["order_date"]), "d-M-Y h:i:sa"); ?></td>

                    <td class="px-2 py-4 text-sm text-center">
                        <?php

                            $date1 = new DateTime($row["order_date"], new DateTimeZone('Asia/Kolkata'));
                            $date2 = new DateTime("now", new DateTimeZone('Asia/Kolkata'));


                            $diff = $date2->diff($date1);
                            echo $diff->format('%d') . " Days " . $diff->format('%h') . " Hours " . $diff->format('%i') . " Minutes";

                            ?>
                    </td>

                    <td class="px-2 py-4 text-sm text-center">
                        <a data-toggle="modal" href="#approveUserModal<?= $i ?>"
                            href="approveUser.php?user_id=<?= $row["user_id"]; ?>"
                            class="btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            <span><strong>Approve</strong></span>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="approveUserModal<?= $i ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Approve user</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Approve user ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gray-600 text-white"
                                            data-dismiss="modal">Close</button>
                                        <a id="user_id" href="approveUser.php?user_id=<?= $row["user_id"]; ?>"
                                            type="button"
                                            class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3">Yes
                                            approve!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>

                </tr>

                <?php
                    $i++;
                }

                $conn->close();
                ?>

            </tbody>
        </table>
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