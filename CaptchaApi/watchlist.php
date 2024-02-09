<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
if (!isset($_GET['5dollar'])) {
    unset($_SESSION['5dollar']);
}

include "db.php";

$userIds = "";

if (isset($_POST["Import"])) {

    $filename = $_FILES["file"]["tmp_name"];


    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

            if ($getData[0] != "")
                $userIds .= "'" . $getData[0] . "'" . ", ";
        }
        $userIds = rtrim($userIds, ", ");
        $_SESSION['userIds'] = $userIds;
        fclose($file);
    }
}

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Watchlist Users</title>

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
        var new_href = "changeTerminalWatchlist.php?terminal=" + terminal;
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

    $(document).on("click", "#time_modal", function() {
        var time = $(this).data('id').split(",")[0];

        var new_href = "changeTimeWatchlist.php?time=" + time;
        $(".modal-footer #time").attr("href", new_href);

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
                    <a id="terminal" href="changeTerminalWatchlist.php" type="button"
                        class="btn text-white bg-darkslateblue">Yes
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

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="hold-all-watchlist.php"
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
                            Hold!</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Modal Remove Hold All -->
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

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="remove-hold-all-watchlist.php"
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

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="changePlatformWatchlist.php?platform=app" method="POST">

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
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="changePlatformWatchlist.php?platform=web" method="POST">

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
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    action="changePlatformWatchlist.php?platform=both" method="POST">

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

    <div class="modal fade" id="changeTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Time</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Change Time ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="time" href="changeTimeWatchlist.php" type="button"
                        class="btn text-white bg-darkslateblue">Yes Change!</a>
                </div>
            </div>
        </div>
    </div>




    <?php include 'nav.php'; ?>

    <br><br>

    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold">Watchlist Users</h2>



        <div class="container">

            <div class="row">
                <form class="form-horizontal" action="#" method="post" name="upload_excel"
                    enctype="multipart/form-data">
                    <fieldset>

                        <!-- File Button -->
                        <div class="form-group">
                            <label class="control-label" for="filebutton">Upload CSV File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">

                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import"
                                    class="btn btn-primary button-loading bg-darkslateblue"
                                    data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <br />

            <div class="row">

                <?php

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

                            <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Shift Terminal
                            </a>


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

                </div>


                <div class="col">
                    <div class="dropdown show">

                        <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Shift Platform
                        </a>


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
                </div>


                <div class="col">
                    <div class="dropdownInline">
                        <div class="dropdown show">

                            <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Change Time
                            </a>


                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" id="time_modal"
                                    data-id="30,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 30sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="35,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 35sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="40,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 40sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="45,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 45sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="50,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 50sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="55,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 55sec</a>

                                <a class="dropdown-item" id="time_modal"
                                    data-id="60,<?= $_GET['earning'] ?>,<?= $_GET['plan'] ?>" data-toggle="modal"
                                    href="#changeTimeModal">Change time to - 60sec</a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col">
                    <div>
                        <form class="d-flex align-items-center" action="changeExtraTimeWatchlist.php" method="post">
                            <input type="number" placeholder="Extra time" name="time"
                                class="bg-white px-3 py-2 rounded-md shadow-md" />

                            <button
                                class="btn btn-primary ml-3 bg-darkslateblue px-10 rounded-full shadow-xl py-2 border-0"
                                type="submit">Shift extra time</button>
                        </form>
                    </div>
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
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninghigh')))  ?>">Earning
                                - High
                                to Low</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninglow'))) ?>">Earning
                                - Low to
                                High</a>

                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-asc'))) ?>">Extra
                                time - Low to
                                High</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-desc'))) ?>">Extra
                                time - High to
                                Low</a>

                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => '5dollar'))) ?>">Earning
                                greater than
                                10 $</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                                by
                                Web</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                                by
                                App</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                                by
                                Both</a>
                            <a class="dropdown-item"
                                href="watchlist.php?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Sort
                                by
                                Date</a>
                        </div>
                    </div>

                </div>



            </div>

        </div>

        <br>

        <?php

        $userIds = $_SESSION['userIds'];
        $sql = "SELECT * FROM users WHERE user_id in ($userIds)";

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
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) order by total_earning " . $earningSort;
        }

        if (isset($sortTime)) {
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) order by extra_time " . $sortTime;
        }


        if ($sort == "5dollar") {
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) and total_earning > 10 order by total_earning desc";
        }

        if ($sort == "web") {
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) and platform = 'web'";
        }

        if ($sort == "app") {
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) and platform = 'app'";
        }

        if ($sort == "both") {
            $sql = "SELECT * FROM users WHERE user_id in ($userIds) and platform = 'both'";
        }

        if ($sort == "date") {
            $sql = "SELECT *, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users  WHERE user_id in ($userIds) order by created_on desc";
        }



        $result = $conn->query($sql);

        ?>

        <h3>Total Users :- <?= $result->num_rows; ?></h3>
        <br>
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



                        <td class="px-2 py-4 text-sm text-center">
                            <?= date_format(date_create($row["date_time"]), "d-M-Y h:i:sa"); ?></td>

                        <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?> $</td>

                        <td class="px-2 py-4 text-sm text-center">
                            <?= number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', ''); ?>
                            $</td>



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
                                                href="/CaptchaApi/refreshToken.php?user_id=<?= $row["user_id"]; ?>">Refresh
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

        </div>


    </div>
</body>

</html>