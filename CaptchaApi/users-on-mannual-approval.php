<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];
$enteredPassword = $_GET['password'];

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
} else {
    $page_no = 1;
}

$total_records_per_page = 40;

$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Users on hold</title>

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

    .dropdownInline {
        position: relative;
        display: inline-block;
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

    <br><br>
    <?php
    if ($enteredPassword == $savedPassword) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="deleteInactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete All</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Delete All ?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="deleteAllInactive.php"
                    method="GET">

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="******************">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                        <button id="terminal" type="submit" class="btn text-white bg-darkslateblue">Yes
                            Delete!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="holdAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hold All</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hold All ?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="holdAllInactive.php" method="GET">

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="******************">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                        <button id="terminal" type="submit" class="btn text-white bg-darkslateblue">Yes
                            Hold!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="removeHoldAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hold All</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Remove Hold All ?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="removeHoldAll.php" method="GET">

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input
                            class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="******************">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                        <button id="terminal" type="submit" class="btn text-white bg-darkslateblue">Yes
                            Remove!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold text-red-600">Users Not On Auto Approval</h2>


        <!-- <button data-toggle="modal" data-target="#removeHoldAll"
            class="bg-blue-500 text-white rounded-md shadow-md py-2 hover:no-underline px-3 a-btn-slide-text">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            <span><strong>Remove Hold</strong></span>
        </button>
        <button type="button" class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3 mr-3"
            data-toggle="modal" data-target="#deleteInactive">Delete All</button> -->
        <br><br>

        <?php

            if (isset($_GET['page'])) {
                if (strlen($_GET['page']) == 1)
                    $page = $_GET['page'] . "%";
                else
                    $page = "%" . $_GET['page'] . "%";
            } else {
                $page = "%%";
            }

            $sql = "SELECT user_id, COUNT(user_id) as total, date_time, platform, total_earning, auto_approve FROM users where auto_approve = 0 AND user_id like '$page'";
            if (isset($_GET['web'])) {
                $sql = "SELECT user_id, COUNT(user_id) as total, date_time, platform, total_earning, auto_approve FROM users where auto_approve = 0 and platform = 'web' AND user_id like '$page'";
            }

            if (isset($_GET['app'])) {
                $sql = "SELECT user_id, COUNT(user_id) as total, date_time, platform, total_earning, auto_approve FROM users where auto_approve = 0 and platform = 'app' AND user_id like '$page'";
            }

            if (isset($_GET['both'])) {
                $sql = "SELECT user_id, COUNT(user_id) as total, date_time, platform, total_earning, auto_approve FROM users where auto_approve = 0 and platform = 'both' AND user_id like '$page'";
            }

            if (isset($_GET['date'])) {
                $sql = "SELECT user_id, COUNT(user_id) as total, date_time, platform, total_earning, auto_approve, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users where auto_approve = 0 AND user_id like '$page' order by created_on desc";
            }

            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_users = $row['total'];
            $total_no_of_pages = ceil($total_users / $total_records_per_page);
            $second_last = $total_no_of_pages - 1;
            ?>

        <h5 class="text-xl font-semibold">Total Users :- <?= $total_users; ?></h5>

        <div class="flex items-center justify-between w-full gap-3 mt-3">

            <form class="w-full" action="#" method="GET">
                <input type="hidden" name="password" value="<?= $savedPassword ?>" />
                <input class="rounded-full bg-white shadow-md px-4 border-0 focus:outline-none" name="page" type="text"
                    id="myInput" onkeyup="myFunction()" placeholder="Search for Users.." title="Type in a name">
            </form>

            <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle w-full" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort By
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item"
                        href="users-on-mannual-approval.php?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                        by Web</a>
                    <a class="dropdown-item"
                        href="users-on-mannual-approval.php?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                        by App</a>
                    <a class="dropdown-item"
                        href="users-on-mannual-approval.php?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                        by Both</a>
                    <a class="dropdown-item"
                        href="users-on-mannual-approval.php?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Sort
                        by Date</a>
                </div>
            </div>
        </div>
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
                        Created On</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Platform</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Total Earning ($)</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Auto Approve</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Delete User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_GET['page'])) {
                        if (strlen($_GET['page']) == 1)
                            $page = $_GET['page'] . "%";
                        else
                            $page = "%" . $_GET['page'] . "%";
                    } else {
                        $page = "%%";
                    }
                    $limitQuery = "LIMIT $offset, $total_records_per_page";
                    $j = 1;
                    $sql2 = "SELECT user_id, date_time, platform, auto_approve, total_earning, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users where auto_approve = 0 AND user_id like '$page' order by created_on desc $limitQuery";

                    $sort = 'date';
                    if (isset($_GET['sort']))
                        $sort = $_GET['sort'];

                    if ($sort == 'web') {
                        $sql2 = "SELECT user_id, date_time, platform, total_earning, auto_approve FROM users where  platform = 'web' AND auto_approve = 0 AND user_id like '$page' $limitQuery";
                    }

                    if ($sort == 'app') {
                        $sql2 = "SELECT user_id, date_time, platform, total_earning, auto_approve FROM users where  platform = 'app' AND auto_approve = 0 AND user_id like '$page' $limitQuery";
                    }

                    if ($sort == 'both') {
                        $sql2 = "SELECT user_id, date_time, platform, total_earning, auto_approve FROM users where  platform = 'both' AND auto_approve = 0 AND user_id like '$page' $limitQuery";
                    }

                    if ($sort == 'date') {
                        $sql2 = "SELECT user_id, date_time, platform, total_earning, auto_approve, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users where auto_approve = 0 AND user_id like '$page' order by created_on desc $limitQuery";
                    }

                    $result2 = $conn->query($sql2);
                    while ($row = $result2->fetch_assoc()) {
                    ?>
                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center"><?= $j + (($page_no - 1) *  $total_records_per_page); ?>
                    </td>
                    <td class="px-2 py-4 text-sm text-center"><a
                            href="vieworderhistory.php?user_id=<?= $row["user_id"]; ?>">
                            <?= $row["user_id"]; ?> </a></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["date_time"] ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["platform"] ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"] ?> $</td>

                    <td class="px-2 py-4 text-sm text-center">

                        <a data-toggle="modal" data-target="#removeHold<?= $j; ?>"
                            class="btn btn-danger a-btn-slide-text text-white cursor-pointer">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            <span><strong>Auto approve</strong></span>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="removeHold<?= $j; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Auto approve</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Auto approve ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3"
                                            data-dismiss="modal">Close</button>
                                        <a href="autoApprove.php?user_id=<?= $row["user_id"]; ?>" type="button"
                                            class="btn bg-red-600 text-white">Yes Approve!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>

                    <td class="px-2 py-4 text-sm text-center">
                        <button type="button" class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3"
                            data-toggle="modal" data-target="#exampleModal<?= $j; ?>">Delete</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?= $j; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Delete User ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3"
                                            data-dismiss="modal">Close</button>
                                        <a href="deleteUser.php?user_id=<?= $row["user_id"]; ?>" type="button"
                                            class="btn bg-red-600 text-white">Yes Delete!</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </td>

                </tr>

                <?php


                        $j++;
                    }

                    $conn->close();
                    ?>

            </tbody>
        </table>

        <div class="flex w-full items-center justify-end mt-4">

            <ul class="inline-flex -space-x-px">
                <li>
                    <a href=<?= $page_no > 1 ? "?" . http_build_query(array_merge($_GET, array('page_no' => $previous_page))) : '#' ?>
                        class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>

                <?php

                    $counter = $total_no_of_pages > 5 ? 5 : $total_no_of_pages;
                    for ($j = 1; $j <= $counter; ++$j) {
                    ?>

                <li>
                    <a href=<?= "?" . http_build_query(array_merge($_GET, array('page_no' => $j))) ?>
                        class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $j ?></a>
                </li>

                <?php
                    }
                    ?>


                <li>
                    <a href=<?= $page_no < $total_no_of_pages ? "?" . http_build_query(array_merge($_GET, array('page_no' => $next_page))) : '#' ?>
                        class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
            </ul>
        </div>

    </div>
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
    <?php } ?>
</body>

</html>