<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
if (!isset($_GET['5dollar'])) {
    unset($_SESSION['5dollar']);
}

include "db.php";

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
    <title>View Users Old</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <script>
    $(document).on("click", "#delete_modal", function() {
        var user_id = $(this).data('id');
        var new_href = "deleteUser.php?user_id=" + user_id;
        $(".modal-footer #user_id").attr("href", new_href);

    });

    $(document).on("click", "#terminal_modal", function() {
        var terminal = $(this).data('id');
        var new_href = "changeTerminal.php?terminal=" + terminal;
        $(".modal-footer #terminal").attr("href", new_href);

    });

    $(document).on("click", "#hold_modal", function() {
        var user_id = $(this).data('id');
        var new_href = "holdUser.php?user_id=" + user_id;
        $(".modal-footer #user_id").attr("href", new_href);
    });

    $(document).on("click", "#remove_hold_modal", function() {
        var user_id = $(this).data('id');
        var new_href = "removeHold.php?user_id=" + user_id;
        $(".modal-footer #user_id").attr("href", new_href);
    });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="deleteUser.php" type="button"
                        class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3">Yes Delete!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="shiftTerminalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shift Terminal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Shift Terminal ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="changeTerminal.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Shift!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Auto Approve -->
    <div class="modal fade" id="autoApproveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Auto approve all</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Auto approve all?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="autoApproveAll.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Approve!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Remove Auto Approve -->
    <div class="modal fade" id="removeAutoApproveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Remove auto approve all</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Remove auto approve all?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="removeAutoApproveAll.php" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Remove!</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Hold All -->
    <div class="modal fade" id="holdAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hold all</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hold all users?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="holdAll.php" method="GET">

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

    <!-- Modal Remove Auto Approve -->
    <div class="modal fade" id="removeHoldAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remove hold all</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Remove hold all?
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

    <!-- Modal Shift Platform App -->
    <div class="modal fade" id="shiftPlatformAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shift platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Shift all users to App?
                </div>

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="changePlatform.php?platform=app"
                    method="POST">

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
                            Shift!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Shift Platform Web -->
    <div class="modal fade" id="shiftPlatformWebModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shift platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Shift all users to Web?
                </div>
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="changePlatform.php?platform=web"
                    method="POST">

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
                            Shift!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Shift Platform App -->
    <div class="modal fade" id="shiftPlatformBothModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shift platform</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Shift all users to both App & Website?
                </div>
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="changePlatform.php?platform=both"
                    method="POST">

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
                            Shift!</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hold Single User -->
    <div class="modal fade" id="HoldSingleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hold user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hold user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="changePlatform.php?platform=both" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Hold!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Remove Hold Single User -->
    <div class="modal fade" id="removeHoldSingleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remove hold</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Remove hold?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="changePlatform.php?platform=both" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Remove!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Disable app and website -->
    <div class="modal fade" id="disableAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Disable app and website</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Disable app and website?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="disableWebsite.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Disable!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Enable app and website -->
    <div class="modal fade" id="enableAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enable app and website</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Enable app and website?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="enableWebsite.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Enable!</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Refresh All Modal -->
    <div class="modal fade" id="refreshAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Refresh All Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Refresh All Users?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="refreshAll.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Refresh!</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'nav.php'; ?>

    <br><br>

    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold text-red-600">View Users - Non Offer</h2>
        <h6><a href="viewuserstoday.php">View Today's Users</a></h6>
        <h6><a href="view-users-earning-wise.php?plan=0&earning=70&time=2">View Users Earning Wise</a></h6>
        <br><br>

        <div class="container">
            <div class="row">

                <?php

                $disable_website_color = "danger";
                $enable_website_color = "primary";

                $approve_on_color = "primary";
                $approve_off_color = "secondary";

                $sql_auto_approve = "select is_enabled from auto_approve where is_enabled = 0";
                $result_auto_approve = $conn->query($sql_auto_approve);
                if ($result_auto_approve->num_rows > 0) {
                    $approve_on_color = "secondary";
                    $approve_off_color = "primary";
                }

                $hold_on_color = "primary";
                $hold_off_color = "secondary";

                $sql_hold = "select on_hold from hold where on_hold = 0";
                $result_hold = $conn->query($sql_hold);
                if ($result_hold->num_rows > 0) {
                    $hold_on_color = "secondary";
                    $hold_off_color = "primary";
                }

                ?>
                <div class="col">
                    <a data-toggle="modal" href="#autoApproveModal"
                        class="btn text-white bg-darkslateblue btn-<?= $approve_on_color; ?>">Auto Approve All</a>
                    <br><br>
                    <a data-toggle="modal" href="#removeAutoApproveModal" class="btn text-white bg-red-600">Remove Auto
                        Approve</a>
                </div>


                <div class="col">
                    <a class="btn text-white bg-darkslateblue btn-<?= $hold_on_color; ?>" data-toggle="modal"
                        href="#holdAllModal">
                        Hold All Users
                    </a>
                    <br><br>
                    <a class="btn text-white bg-red-600" data-toggle="modal" href="#removeHoldAllModal">
                        Remove Hold
                    </a>
                </div>

                <div class="col">
                    <div class="dropdownInline">
                        <div class="dropdown show">
                            <?php
                            $stmt3 = "select terminal from current_terminal";
                            $result3 = $conn->query($stmt3);
                            $row3 = $result3->fetch_assoc();
                            if ($row3['terminal'] == -1) {
                            ?>
                            <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Shift Terminal
                            </a>

                            <?php
                            } else {
                            ?>
                            <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Current Terminal <?= $row3['terminal']; ?>
                            </a>

                            <?php
                            }
                            ?>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php
                                $stmt2 = "select terminal from terminals";
                                $result2 = $conn->query($stmt2);
                                while ($row2 = $result2->fetch_assoc()) {
                                ?>
                                <a class="dropdown-item" id="terminal_modal" data-id="<?= $row2['terminal']; ?>"
                                    data-toggle="modal" href="#shiftTerminalModal">Add all users to - Terminal
                                    <?= $row2['terminal']; ?></a>

                                <?php
                                }
                                ?>
                                <a class="dropdown-item" id="terminal_modal" data-id="0" data-toggle="modal"
                                    href="#shiftTerminalModal">Add all users to - Terminal Mix</a>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    <a class="btn text-white bg-red-600" data-toggle="modal" href="#disableAppModal">
                        Disable App & Website
                    </a>
                </div>


                <div class="col">
                    <div class="dropdown show">
                        <?php
                        $stmt3 = "select platform from current_platform";
                        $result3 = $conn->query($stmt3);
                        $row3 = $result3->fetch_assoc();
                        if ($row3['platform'] == "none") {
                        ?>
                        <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Shift Platform
                        </a>

                        <?php
                        } else {
                        ?>
                        <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Current Platform <?= $row3['platform']; ?>
                        </a>

                        <?php
                        }
                        ?>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" data-toggle="modal" href="#shiftPlatformAppModal">Shift all users
                                to - App</a>
                            <a class="dropdown-item" data-toggle="modal" href="#shiftPlatformWebModal">Shift all users
                                to -
                                Website</a>
                            <a class="dropdown-item" data-toggle="modal" href="#shiftPlatformBothModal">Shift all users
                                to -
                                Both</a>
                        </div>
                    </div>

                    <br>

                    <a class="btn text-white bg-darkslateblue" data-toggle="modal" href="#enableAppModal">
                        Enable App & Website
                    </a>
                </div>


                <div class="col">
                    <div class="dropdown show" style="float: right;">
                        <a class="btn bg-brightYellow dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort By
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            <?php
                            $query_param_new = explode("&", $_SERVER['QUERY_STRING'])[0];
                            ?>


                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninghigh')))  ?>">Earning
                                - High
                                to Low</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninglow'))) ?>">Earning
                                - Low to
                                High</a>

                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-asc'))) ?>">Extra
                                time - Low to
                                High</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-desc'))) ?>">Extra
                                time - High to
                                Low</a>

                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => '5dollar'))) ?>">Earning
                                greater than
                                10 $</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                                by
                                Web</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                                by
                                App</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                                by
                                Both</a>
                            <a class="dropdown-item"
                                href="view-users-old.php?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Sort
                                by
                                Date</a>

                        </div>
                    </div>
                    <a class="btn text-white bg-darkslateblue" data-toggle="modal" href="#refreshAllModal">
                        Refresh All
                    </a>
                </div>




            </div>
            <br>
            <div class="row">
                <?php
                $sql_total = "select COUNT(id) as total_users, SUM(total_earning) as total_earning from users where captcha_count > 500";
                $result_total = $conn->query($sql_total);
                $row_total = $result_total->fetch_assoc();
                $total_users = $row_total["total_users"];

                $total_no_of_pages = ceil($total_users / $total_records_per_page);
                $second_last = $total_no_of_pages - 1;

                $total_earning = $row_total["total_earning"];

                $sql_unpaid = "select COUNT(total) as total_unpaid from (select count(id) as total from order_history where status = 0 group by user_id) as total";
                $result_unpaid = $conn->query($sql_unpaid);
                $row_unpaid = $result_unpaid->fetch_assoc();

                $total_unpaid = $row_unpaid['total_unpaid'];
                ?>

                <div class="col">
                    <h6>Total Users :- <?= $total_users; ?></h6>

                </div>
                <div class="col">
                    <h3>Total Earning :- <?= $total_earning; ?> $</h3>
                </div>

                <div class="col">
                    <h3>Total Unpaid :- <?= $total_unpaid; ?> $</h3>
                </div>
            </div>
        </div>

        <br><br>

        <div class="flex flex-row bg-white rounded-full shadow-md place-content-around w-full mb-3 p-2">
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=A">A
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=B">B
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=C">C
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=D">D
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=E">E
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=F">F
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=G">G
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=H">H
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=I">I
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=J">J
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=K">K
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=L">L
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=M">M
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=N">N
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=O">O
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=P">P
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=Q">Q
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=R">R
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=S">S
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=T">T
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=U">U
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=V">V
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=W">W
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=X">X
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=Y">Y
            </a>
            <a class="btn bg-darkslateblue text-white shadow-md rounded-full w-10 h-10" style="margin: 5px;"
                href="?page=Z">Z
            </a>
        </div>

        <form action="#" method="GET">
            <input class="rounded-full bg-white shadow-md px-4 border-0 focus:outline-none" name="page" type="text"
                id="myInput" onkeyup="myFunction()" placeholder="Search for Users.." title="Type in a name">
        </form>
        <div>
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
                            Terminal</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Platform</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Captcha time</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Created On</th>

                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Total Earning</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Current Earning</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Actions</th>
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
                        $page = "A%";
                    }

                    $limitQuery = "LIMIT $offset, $total_records_per_page";

                    $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' $limitQuery";

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
                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' order by total_earning " . $earningSort . " " . $limitQuery;
                    }

                    if (isset($sortTime)) {
                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' order by extra_time " . $sortTime . " " . $limitQuery;
                    }

                    if ($sort == "5dollar") {

                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' and total_earning > 10 order by total_earning desc $limitQuery";
                    }

                    if ($sort == "web") {
                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' and platform = 'web' $limitQuery";
                    }

                    if ($sort == "app") {
                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' and platform = 'app' $limitQuery";
                    }

                    if ($sort == "both") {
                        $sql = "SELECT * FROM users WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' and platform = 'both' $limitQuery";
                    }

                    if ($sort == "date") {
                        $sql = "SELECT *, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users  WHERE on_hold = 0 AND captcha_count > 500 and user_id like '$page' order by created_on desc $limitQuery";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) { ?>

                    <tr class="hover:bg-gray-100 border-b border-dashed">
                        <td class="px-2 py-4 text-sm"><?= $i + (($page_no - 1) *  $total_records_per_page); ?></td>
                        <td class="px-2 py-4 text-sm font-medium text-center"><a
                                href="vieworderhistory.php?user_id=<?= $row["user_id"]; ?>">
                                <?= $row["user_id"]; ?> </a>

                            <div class="flex items-center justify-center gap-2 text-13 mt-2">

                                <div
                                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                                    <div>
                                        <img alt="Natacha" src="../interest.png" class="w-5 h-5" />
                                    </div>
                                    <div class="text-center"><?= $row["captcha_count"]; ?>/<?= $row["captcha_rate"]; ?>$
                                    </div>
                                </div>

                                <div
                                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                                    <div>
                                        <img alt="Natacha" src="../checkmark.svg" class="w-5 h-5" />
                                    </div>
                                    <div class="text-center" id="right_count"><?= $row["right_count"]; ?></div>
                                </div>
                                <div
                                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                                    <div>
                                        <img alt="Natacha" src="../remove.svg" class="w-5 h-5" />
                                    </div>
                                    <div class="text-center" id="wrong_count"><?= $row["wrong_count"]; ?></div>
                                </div>

                                <div
                                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                                    <div>
                                        <img alt="Natacha" src="../right-arrow.svg" class="w-5 h-5" />
                                    </div>
                                    <div class="text-center" id="skip_count"><?= $row["skip_count"]; ?></div>
                                </div>
                            </div>

                        </td>
                        <td class="px-2 py-4 text-sm text-center"><?php if ($row["terminal"] == 0) {
                                                                                echo "Mix";
                                                                            } else {
                                                                                echo $row['terminal'];
                                                                            }
                                                                            ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["platform"]; ?></td>

                        <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_time"]; ?> sec /
                            <?= $row['extra_time']; ?> sec</td>

                        <?php

                                $dateValue = strtotime($row["date_time"]);

                                $yr = date("Y", $dateValue) . " ";
                                $mon = date("m", $dateValue) . " ";
                                $date = date("d", $dateValue);


                                if ($row["captcha_count"] == 2000 && $date > 4 && $mon > 5 && $yr > 2019) {
                                ?>
                        <td class="px-2 py-4 text-sm text-center" style="color: red">
                            <?= date_format(date_create($row["date_time"]), "d-M-Y h:i:sa"); ?></td>

                        <td class="px-2 py-4 text-sm text-center" style="color: red"><?= $row["total_earning"]; ?> $
                        </td>

                        <td class="px-2 py-4 text-sm text-center" style="color: red">
                            <?= number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', ''); ?>
                            $</td>
                        <?php
                                } else { ?>
                        <td class="px-2 py-4 text-sm text-center">
                            <?= date_format(date_create($row["date_time"]), "d-M-Y h:i:sa"); ?></td>

                        <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?> $</td>

                        <td class="px-2 py-4 text-sm text-center">
                            <?= number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', ''); ?>
                            $</td>
                        <?php } ?>


                        <td>
                            <?php

                                    if ($row['auto_approve'] == 1) {
                                    ?>

                            <div class="dropdown show">
                                <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Actions
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item"
                                        href="editUser.php?user_id=<?= $row["user_id"]; ?>">Edit</a>
                                    <a class="dropdown-item" id="delete_modal" data-id="<?= $row['user_id']; ?>"
                                        data-toggle="modal" href="#deleteModal">Delete</a>
                                    <a class="dropdown-item"
                                        href="refreshToken.php?user_id=<?= $row["user_id"]; ?>">Refresh Id</a>
                                    <a class="dropdown-item"
                                        href="removeAutoApprove.php?user_id=<?= $row["user_id"]; ?>">Remove Auto
                                        Approve</a>
                                    <?php
                                                if ($row['on_hold'] == 1) {
                                                ?>
                                    <a class="dropdown-item" id="remove_hold_modal" data-id="<?= $row['user_id']; ?>"
                                        data-toggle="modal" href="#removeHoldSingleModal">Remove Hold</a>
                                    <?php
                                                } else {
                                                ?>
                                    <a class="dropdown-item" id="hold_modal" data-id="<?= $row['user_id']; ?>"
                                        data-toggle="modal" href="#HoldSingleModal">Hold
                                        User</a>
                                    <?php
                                                }
                                            } else { ?>
                                    <div class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Actions
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item"
                                                href="editUser.php?user_id=<?= $row["user_id"]; ?>">Edit</a>
                                            <a class="dropdown-item" id="delete_modal" data-id="<?= $row['user_id']; ?>"
                                                data-toggle="modal" href="#deleteModal">Delete</a>
                                            <a class="dropdown-item"
                                                href="refreshToken.php?user_id=<?= $row["user_id"]; ?>">Refresh
                                                Id</a>
                                            <a class="dropdown-item"
                                                href="autoApprove.php?user_id=<?= $row["user_id"]; ?>">Auto Approve</a>
                                            <?php
                                                        if ($row['on_hold'] == 1) {
                                                        ?>
                                            <a class="dropdown-item" id="remove_hold_modal"
                                                data-id="<?= $row['user_id']; ?>" data-toggle="modal"
                                                href="#removeHoldSingleModal">Remove Hold</a>
                                            <?php
                                                        } else {
                                                        ?>
                                            <a class="dropdown-item" id="hold_modal" data-id="<?= $row['user_id']; ?>"
                                                data-toggle="modal" href="#HoldSingleModal">Hold
                                                User</a>
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

    </div>

</body>

</html>