<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sql = "SET time_zone = '+05:30'";
$conn->query($sql);

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
    <title>Main Website Enquiries</title>

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

    <!-- Modal -->
    <div class="modal fade" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="delete-enquiries-all.php"
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
                        <button id="terminal" type="submit" name="submit-all" value="submit-all"
                            class="btn text-white bg-darkslateblue">Yes
                            Delete!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Excel Modal -->
    <div class="modal fade" id="downloadExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Download Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Download Excel ?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="export-enquiries-excel.php"
                    method="GET">

                    <input type="hidden" name="start-date" value="<?= $_GET['start-date']; ?>" />
                    <input type="hidden" name="end-date" value="<?= $_GET['end-date']; ?>" />
                    <input type="hidden" name="sort" value="<?= $_GET['sort']; ?>" />
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
                        <button id="terminal" type="submit" name="submit-all" value="submit-all"
                            class="btn text-white bg-darkslateblue">
                            Download</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <br />

    <?php

    $user_id = $_GET['user_id'];
    ?>

    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold">Main website enquiries</h2>

        <?php
        $date = date("Y-m-d", strtotime("yesterday"));
        $sql = "SELECT * FROM website_enquiries WHERE DATE(createdAt) = '$date' and isDeleted = 0 order by id desc";
        $result = $conn->query($sql);
        $totalBoth = 0;
        $totalCaptcha = 0;
        $totalForm = 0;
        while ($row = $result->fetch_assoc()) {
            if ($row['interestedIn'] == 'both')
                $totalBoth += 1;
            if ($row['interestedIn'] == 'captcha')
                $totalCaptcha += 1;
            if ($row['interestedIn'] == 'form')
                $totalForm += 1;
        }

        ?>

        <div>Yesterday Total - <?= $result->num_rows ?></div>
        <div>Yesterday Total (Both) - <?= $totalBoth ?></div>
        <div>Yesterday Total (Captcha) - <?= $totalCaptcha ?></div>
        <div>Yesterday Total (Form) - <?= $totalForm ?></div>


        <?php

        $sql_total = "select COUNT(id) as total_users from website_enquiries where isDeleted = 0";
        $whereClause = "DATE(createdAt)=CURDATE() and isDeleted = 0";

        if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

            $startDate = $_GET['start-date'];
            $endDate = $_GET['end-date'];
            $whereClause = "DATE(createdAt) >= '$startDate' and DATE(createdAt) <= '$endDate' and isDeleted = 0";
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
        <br />
        <div class='row w-full'>
            <div class='col-md-8 w-full'>
                <form class="flex items-center">
                    <strong>Select Date :- </strong>
                    <input type="date" name="start-date" value="<?= $_GET['start-date'] ?>"
                        class="px-3 py-2 rounded-xl bg-white shadow-md" />
                    <input type="date" name="end-date" value="<?= $_GET['end-date'] ?>"
                        class="px-3 py-2 rounded-xl bg-white shadow-md" />
                    <input type="submit"
                        class="bg-darkslateblue text-white ml-3 cursor-pointer px-10 rounded-full shadow-xl py-2" />
                    <button type="button" data-toggle="modal" data-target="#downloadExcel"
                        class="bg-darkslateblue text-white ml-6 cursor-pointer px-4 shadow-xl py-2">Download
                        Excel</button>
                </form>
            </div>

            <div class="col-md-2 w-full"><button type="button"
                    class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3 mr-3" data-toggle="modal"
                    data-target="#deleteAll">Delete All</button></div>

            <div class="col-md-2">
                <div class="dropdown show">
                    <a class="btn bg-brightYellow dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
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

        </div>

        <div>Total Enquiries - <?= $total_users; ?></div>

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
                        Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $limitQuery = "LIMIT $offset, $total_records_per_page";
                $whereClause = "DATE(createdAt)=CURDATE() and isDeleted = 0";

                if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

                    $startDate = $_GET['start-date'];
                    $endDate = $_GET['end-date'];
                    $whereClause = "DATE(createdAt) >= '$startDate' and DATE(createdAt) <= '$endDate' and isDeleted = 0";
                }

                $sql = "SELECT * FROM website_enquiries WHERE " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "form")
                    $sql = "SELECT * FROM website_enquiries WHERE interestedIn='form' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "captcha")
                    $sql = "SELECT * FROM website_enquiries WHERE interestedIn='captcha' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "both")
                    $sql = "SELECT * FROM website_enquiries WHERE interestedIn='both' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "en")
                    $sql = "SELECT * FROM website_enquiries WHERE language='English' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "hi")
                    $sql = "SELECT * FROM website_enquiries WHERE language='Hindi' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "mr")
                    $sql = "SELECT * FROM website_enquiries WHERE language='Marathi' and " . $whereClause . " order by id desc $limitQuery";

                if (isset($_GET['sort']) && $_GET['sort'] == "date")
                    $sql = "SELECT * FROM website_enquiries WHERE " . $whereClause . " order by id desc $limitQuery";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {

                ?>

                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center"><?= $i + (($page_no - 1) *  $total_records_per_page); ?>
                    </td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['name']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['email']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['mobile']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['interestedIn']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row['language']; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["message"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center">
                        <?= date_format(date_create($row["createdAt"]), "d-M-Y h:i:sa"); ?>
                    </td>
                    <td class="px-2 py-4 text-sm text-center">
                        <button type="button" class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3"
                            data-toggle="modal" data-target="#deleteModal<?= $i; ?>">Delete</button>



                        <div class="modal fade" id="deleteModal<?= $i; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Number</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Delete Enquiry ?
                                    </div>

                                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                                        action="delete-enquiries-all.php" method="GET">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                        <div class="mb-6">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                                Password
                                            </label>
                                            <input
                                                class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                                id="password" name="password" type="password"
                                                placeholder="******************">

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gray-600 text-white"
                                                data-dismiss="modal">Close</button>
                                            <button id="terminal" type="submit" name="submit-single"
                                                value="submit-single" class="btn text-white bg-darkslateblue">Yes
                                                Delete!</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </td>

                </tr>


                <?php
                        $i++;
                    }
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

</body>

</html>