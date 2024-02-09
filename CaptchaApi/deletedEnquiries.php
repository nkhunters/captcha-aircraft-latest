<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sql = "select password from lock_passwords where id = 2";
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

if (isset($_POST['submit'])) {
    $userId = $_POST['userId'];
    $sql = "delete from website_enquiries where id = '$userId'";
    if ($conn->query($sql)) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

if (isset($_POST['deleteAll'])) {
    $sql = "truncate table website_enquiries";
    if ($conn->query($sql)) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Deleted Enquiries</title>

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
    <div class="modal fade" id="removeHoldAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recover All</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Recover all users?
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a href="recoverAllEnquiry.php" id="terminal" class="btn text-white bg-darkslateblue">Yes
                        Recover!</a>
                </div>


            </div>
        </div>
    </div>


    <!-- Delete all Modal -->
    <div class="modal fade" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recover All</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Delete all users?
                </div>


                <form action="" method="POST" class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <button type="submit" name="deleteAll" value="deleteAll" class="btn text-white bg-red-600">Yes
                        Delete!</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold">Deleted Enquiries</h2>


        <button data-toggle="modal" data-target="#removeHoldAll"
            class="bg-blue-500 text-white rounded-md shadow-md py-2 hover:no-underline px-3 a-btn-slide-text">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            <span><strong>Recover All</strong></span>
        </button>

        <!-- <button data-toggle="modal" data-target="#deleteAll"
            class="bg-red-600 text-white rounded-md shadow-md py-2 hover:no-underline px-3 a-btn-slide-text">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            <span><strong>Delete All</strong></span>
        </button> -->

        <br><br>

        <?php


            $sql_total = "select COUNT(id) as total_users from website_enquiries where isDeleted = 1";
            $whereClause = "isDeleted = 1";

            if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

                $startDate = $_GET['start-date'];
                $endDate = $_GET['end-date'];
                $whereClause = "DATE(createdAt) >= '$startDate' and DATE(createdAt) <= '$endDate' and isDeleted = 1";
            }

            $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "form")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE interestedIn='form' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "captcha")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE interestedIn='captcha' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "both")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE interestedIn='both' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "en")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE language='English' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "hi")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE language='Hindi' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "mr")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE language='Marathi' and " . $whereClause . " order by id desc";

            if (isset($_GET['sort']) && $_GET['sort'] == "date")
                $sql_total = "SELECT COUNT(id) as total_users FROM website_enquiries WHERE " . $whereClause . " order by id desc";

            //$sql_total = "select SUM(total_earning) as total_earning from users";
            $result_total = $conn->query($sql_total);
            $row_total = $result_total->fetch_assoc();
            $total_users = $row_total["total_users"];

            $total_no_of_pages = ceil($total_users / $total_records_per_page);
            $second_last = $total_no_of_pages - 1;

            ?>

        <h5 class="text-xl font-semibold">Total Enquiries :- <?= $total_users; ?></h5>
        <div class="flex flex-row gap-3 items-center mt-3">
            <input class="w-11/12 h-12 rounded-lg" type="text" id="myInput" onkeyup="myFunction()"
                placeholder="Search for Users.." title="Type in a name">
            <div class="dropdown show w-1/12 h-12">
                <a class="btn btn-secondary dropdown-toggle w-full" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort By
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'form'))) ?>">Sort by
                        Form</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'captcha'))) ?>">Sort by
                        Captcha</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort by
                        Both</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'en'))) ?>">Sort by
                        English</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'hi'))) ?>">Sort by
                        Hindi</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'mr'))) ?>">Sort by
                        Marathi</a>
                    <a class="dropdown-item"
                        href="?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Sort by
                        Date</a>
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
                        Name</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Email</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Mobile</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Interested In</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Language</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Message</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Date</th>

                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Recover</th>

                    <!-- <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Delete Permanently</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                    $limitQuery = "LIMIT $offset, $total_records_per_page";
                    $j = 1;
                    $sql2 = "SELECT * FROM website_enquiries WHERE isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "form")
                        $sql2 = "SELECT * FROM website_enquiries WHERE interestedIn='form' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "captcha")
                        $sql2 = "SELECT * FROM website_enquiries WHERE interestedIn='captcha' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "both")
                        $sql2 = "SELECT * FROM website_enquiries WHERE interestedIn='both' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "en")
                        $sql2 = "SELECT * FROM website_enquiries WHERE language='English' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "hi")
                        $sql2 = "SELECT * FROM website_enquiries WHERE language='Hindi' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "mr")
                        $sql2 = "SELECT * FROM website_enquiries WHERE language='Marathi' and isDeleted = 1 order by id desc $limitQuery";

                    if (isset($_GET['sort']) && $_GET['sort'] == "date")
                        $sql2 = "SELECT * FROM website_enquiries WHERE isDeleted = 1 order by id desc $limitQuery";

                    $result2 = $conn->query($sql2);
                    while ($row = $result2->fetch_assoc()) {
                    ?>
                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center"><?= $j + (($page_no - 1) *  $total_records_per_page); ?>
                    </td>

                    <td class="px-2 py-4 text-sm text-center"><?= $row['name']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['email']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['mobile']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['interestedIn']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['language']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["message"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center">
                        <?= date_format(date_create($row["created_at"]), "d-M-Y h:i:sa"); ?>
                    </td>

                    <td class="px-2 py-4 text-sm text-center">

                        <a data-toggle="modal" data-target="#removeHold<?= $j; ?>"
                            class="btn bg-darkslateblue a-btn-slide-text text-white cursor-pointer">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            <span><strong>Recover</strong></span>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="removeHold<?= $j; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Recover user</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Recover user ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3"
                                            data-dismiss="modal">Close</button>
                                        <a href="recoverEnquiry.php?id=<?= $row["id"]; ?>" type="button"
                                            class="btn bg-red-600 text-white">Yes Recover!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>

                    <!-- <td class="px-2 py-4 text-sm text-center">

                        <a data-toggle="modal" data-target="#deleteUser<?= $j; ?>"
                            class="btn btn-danger a-btn-slide-text text-white cursor-pointer">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            <span><strong>Delete Permanently</strong></span>
                        </a>

                       
                        <div class="modal fade" id="deleteUser<?= $j; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Delete user ?
                                    </div>
                                    <form method="POST" action="" class="modal-footer">
                                        <input type="hidden" name="userId" value="<?= $row["user_id"]; ?>" />
                                        <button type="button"
                                            class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" value="submit"
                                            class="btn bg-red-600 text-white">Yes Delete!</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </td> -->
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