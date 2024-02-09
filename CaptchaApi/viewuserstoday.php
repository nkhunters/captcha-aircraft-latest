<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
if (!isset($_GET['5dollar']))
    unset($_SESSION['5dollar']);

include "db.php";
$sql = "SET time_zone = '+05:30'";
$conn->query($sql);
?>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Users</title>

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
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="changePlatform.php?platform=app" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Shift!</a>
                </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="changePlatform.php?platform=web" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Shift!</a>
                </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="terminal" href="changePlatform.php?platform=both" type="button"
                        class="btn text-white bg-darkslateblue">Yes
                        Shift!</a>
                </div>
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

    <?php include 'nav.php'; ?>

    <br><br>

    <div class="container">
        <h2 class="text-3xl mb-3 font-bold text-red-600">View Users Today</h2>

        <br>

        <div class="container">
            <div class="row">

                <?php
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
                                <a class="dropdown-item" id="terminal_modal" data-id="1" data-toggle="modal"
                                    href="#shiftTerminalModal">Add all users to - Terminal 1</a>
                                <a class="dropdown-item" id="terminal_modal" data-id="0" data-toggle="modal"
                                    href="#shiftTerminalModal">Add all users to - Terminal Mix</a>
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

                            </div>
                        </div>
                    </div>

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
                </div>


                <div class="col">
                    <div class="dropdown show">
                        <a class="btn bg-brightYellow dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort By
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninghigh')))  ?>">Earning
                                - High
                                to Low</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'earninglow'))) ?>">Earning
                                - Low to
                                High</a>

                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'wordshigh')))  ?>">Captcha
                                Words
                                - High
                                to Low</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'wordslow'))) ?>">Captcha
                                Words
                                - Low to
                                High</a>

                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-asc'))) ?>">Extra
                                time - Low to
                                High</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'extra-desc'))) ?>">Extra
                                time - High to
                                Low</a>

                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => '5dollar'))) ?>">Earning
                                greater than
                                10 $</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'web'))) ?>">Sort
                                by
                                Web</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'app'))) ?>">Sort
                                by
                                App</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'both'))) ?>">Sort
                                by
                                Both</a>
                            <a class="dropdown-item"
                                href="viewuserstoday.php?<?= http_build_query(array_merge($_GET, array('sort' => 'date'))) ?>">Sort
                                by
                                Date</a>

                        </div>
                    </div>
                </div>

            </div>
            <br />
            <div class='row'>
                <div class='col'>
                    <form action="" class="flex items-center">
                        <strong>Select Date :- </strong>
                        <input type="date" name="start-date" value="<?= $_GET['start-date'] ?>"
                            class="px-3 py-2 rounded-xl bg-white shadow-md ml-2" />
                        <input type="date" name="end-date" value="<?= $_GET['end-date'] ?>"
                            class="px-3 py-2 rounded-xl bg-white shadow-md ml-2" />
                        <input type="submit"
                            class="bg-darkslateblue text-white ml-3 cursor-pointer px-10 rounded-full shadow-xl py-2" />
                        <a href="today-users-excel.php?start-date=<?= $_GET['start-date'] ?>&end-date=<?= $_GET['end-date'] ?>&sort=<?= $_GET['sort'] ?>"
                            class="bg-darkslateblue text-white ml-9 cursor-pointer px-4 shadow-xl py-2">Download
                            Excel</a>
                    </form>
                </div>




            </div>

            <br>

            <?php

            $curr_date = date("Y-m-d");

            $whereCondition = "STR_TO_DATE(date_time, '%d-%b-%Y') = '$curr_date'";

            if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

                $startDate = $_GET['start-date'];
                $endDate = $_GET['end-date'];
                $whereCondition = "STR_TO_DATE(date_time, '%d-%b-%Y') >= '$startDate' and STR_TO_DATE(date_time, '%d-%b-%Y') <= '$endDate'";
            }

            $sql = "SELECT * FROM users WHERE " . $whereCondition;

            $sort = "date";
            if (isset($_GET['sort']))
                $sort = $_GET['sort'];

            if ($sort == "earninghigh")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by total_earning desc";

            if ($sort == "earninglow")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by total_earning asc";



            if ($sort == "wordshigh")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by captcha_count desc";

            if ($sort == "wordslow")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by captcha_count asc";



            if ($sort == "extra-desc")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by extra_time desc";

            if ($sort == "extra-asc")

                $sql = "SELECT * FROM users where " . $whereCondition . " order by extra_time asc";

            if ($sort == "5dollar") {
                $_SESSION['5dollar'] = "5dollar";
                $sql = "SELECT * FROM users where total_earning > 10 and " . $whereCondition . " order by total_earning desc";
            }

            if ($sort == "web") {
                $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'web'";
            }

            if ($sort == "app") {
                $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'app'";
            }

            if ($sort == "both") {
                $sql = "SELECT * FROM users where " . $whereCondition . " and platform = 'both'";
            }

            if ($sort == "date") {
                $sql = "SELECT *, STR_TO_DATE(date_time, '%d-%b-%Y %h:%i:%s%p') as created_on FROM users where " . $whereCondition . " order by created_on desc";
            }

            $result = $conn->query($sql);

            ?>

            <div class="row">

                <div class="col">
                    <h3>Total Users :- <?= $result->num_rows; ?></h3>
                </div>


            </div>
        </div>

        <br>

        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Users.." title="Type in a name">
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
                            Captcha Words</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Terminal</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Platform</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Created On</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Right Captcha Count</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Wrong Captcha Count</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Skip Count</th>
                        <th
                            class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                            Rate</th>
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
                        <td class="px-2 py-4 text-sm text-center"><?= $i; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><a
                                href="vieworderhistory.php?user_id=<?= $row["user_id"]; ?>"> <?= $row["user_id"]; ?>
                            </a>
                        </td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_count"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?php if ($row["terminal"] == 0) echo "Mix";
                                                                            else echo $row['terminal']; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["platform"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["date_time"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["right_count"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["wrong_count"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?= $row["skip_count"]; ?></td>
                        <td class="px-2 py-4 text-sm text-center"><?php echo $row["captcha_count"]; ?> /
                            <?php echo $row["captcha_rate"]; ?> $</td>

                        <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?> $</td>

                        <td class="px-2 py-4 text-sm text-center">
                            <?= number_format((float) (($row["captcha_rate"] / $row["captcha_count"]) * $row["right_count"]), 2, '.', ''); ?>
                            $</td>

                        <td class="px-2 py-4 text-sm text-center">
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
                                        href="removeAutoApprove.php?user_id=<?= $row["user_id"]; ?>">Remove Auto
                                        Approve</a>
                                    <?php
                                                if ($row['on_hold'] == 1) {
                                                ?>
                                    <a class="dropdown-item"
                                        href="removeHold.php?user_id=<?= $row["user_id"]; ?>">Remove Hold</a>
                                    <?php
                                                } else {
                                                ?>
                                    <a class="dropdown-item" href="holdUser.php?user_id=<?= $row["user_id"]; ?>">Hold
                                        User</a>
                                    <?php
                                                }
                                            } else { ?>
                                    <div class="dropdown show">
                                        <a class="btn text-white bg-darkslateblue dropdown-toggle" href="#"
                                            role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item"
                                                href="editUser.php?user_id=<?= $row["user_id"]; ?>">Edit</a>
                                            <a class="dropdown-item" id="delete_modal" data-id="<?= $row['user_id']; ?>"
                                                data-toggle="modal" href="#deleteModal">Delete</a>
                                            <a class="dropdown-item"
                                                href="autoApprove.php?user_id=<?= $row["user_id"]; ?>">Auto Approve</a>
                                            <?php
                                                        if ($row['on_hold'] == 1) {
                                                        ?>
                                            <a class="dropdown-item"
                                                href="removeHold.php?user_id=<?= $row["user_id"]; ?>">Remove Hold</a>
                                            <?php
                                                        } else {
                                                        ?>
                                            <a class="dropdown-item"
                                                href="holdUser.php?user_id=<?= $row["user_id"]; ?>">Hold User</a>
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