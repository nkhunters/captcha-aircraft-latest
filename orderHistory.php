<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location = 'index.php';</script>";
}
include "db.php";
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="Codelaxy" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="Fill Captcha and Earn">
    <title>CaptchaAir - Earn with Captcha filling</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="CaptchaApi/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Kavoon' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8425396099261130"
        crossorigin="anonymous"></script>

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



    <style>
    #image {
        border: 3px solid black;
    }

    #logo {
        width: 140px;
        height: 60px;
    }

    .navbar {
        background-color: #000000 !important
    }

    .nav-item {
        margin-right: 10em;
    }

    #foot {
        background-color: #000000;
        color: #f9f9f9;
    }

    #logo {
        font-family: 'kavoon';
        font-size: 30px;
    }
    </style>

</head>

<body style="background-color:#F0F0F0;">

    <nav class="bg-darkslateblue">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-btn">
                        <span class="sr-only">Open main menu</span>
                        <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="captcha.php" class="text-white text-xl font-bold">Aircraft Captcha Services</a>
                    </div>
                    <div class="hidden sm:block sm:ml-6 w-full" id="desktop-menu">
                        <div class="flex justify-end space-x-4 w-full">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                            <?php
                            if ($next_order == 1) {
                            ?>

                            <button type="button"
                                class="px-3 py-2 rounded-md text-sm font-medium text-white border border-lightPink bg-lightPink hover:bg-darkBlue"
                                id="next_order">NEXT
                                ORDER</button>

                            <?php
                            } else {
                            ?>

                            <button type="button"
                                class="bg-gray-600 text-gray-400 px-3 py-2 rounded-md text-sm font-medium"
                                id="next_order" disabled>NEXT
                                ORDER</button>

                            <?php }
                            ?>



                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button type="button"
                                class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="man.png" alt="" />
                            </button>
                        </div>

                        <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                            id="menu">
                            <!-- Active: "bg-gray-100", Not Active: "" -->

                            <a href="captcha.php" class="block px-4 py-2 text-sm text-gray-700 uppercase font-bold"
                                role="menuitem" tabindex="-1" id="user-menu-item-0"><?= $_SESSION['user_id']; ?></a>
                            <a href="orderHistory.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">Order history</a>
                            <a href="viewMsgs.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">View messages</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-2">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden lg:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <?php
                if ($next_order == 1) {
                ?>

                <button type="button"
                    class="px-3 py-2 rounded-md text-sm font-medium text-white border border-lightPink bg-lightPink hover:bg-darkBlue"
                    id="next_order">NEXT
                    ORDER</button>

                <?php
                } else {
                ?>

                <button type="button" class="bg-gray-600 text-gray-400 px-3 py-2 rounded-md text-sm font-medium"
                    id="next_order" disabled>NEXT
                    ORDER</button>

                <?php }
                ?>
            </div>
        </div>

        <script>
        const profile = document.querySelector("#user-menu-button");
        const menu = document.querySelector("#menu");

        const mobilemenubtn = document.querySelector("#mobile-menu-btn");
        const mobilemenu = document.querySelector("#mobile-menu");

        profile.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
        mobilemenubtn.addEventListener("click", () => {
            mobilemenu.classList.toggle("hidden");
        });
        </script>
    </nav>

    <br><br>


    <?php

    $user_id = $_SESSION['user_id'];

    $sql_total = "select total_earning from users where user_id = '$user_id'";
    $result = $conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total = $row["total_earning"];
    ?>


    <div class="container">
        <h2>View Order History</h2>
        <h5 style="float:right;">Total Earning : <?= $total; ?> $</h5>
        <br>
        <table class="w-full table-auto bg-white border-collapse" id="myTable">
            <thead class="border-b">
                <tr class="hover:bg-gray-100 border-b border-dashed text-center">
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700  top-0  bg-gray-200 text-left">
                        Order Date</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700  top-0  bg-gray-200 text-left">
                        Paid Amount ($)</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700  top-0  bg-gray-200 text-left">
                        Total Earning ($)</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700  top-0  bg-gray-200 text-left">
                        Payment Status</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $sql = "SELECT user_id, order_date, total_earning, paid_amount, status FROM order_history where user_id = '$user_id' order by id desc";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {

                ?>

                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center">
                        <?= date_format(date_create($row["order_date"]), "d-M-Y h:i:sa"); ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["paid_amount"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?></td>
                    <?php
                            if ($row['status'] == "1") {
                            ?>

                    <td class="px-2 py-4 text-sm text-center">
                        <font color="green">Paid</font>
                    </td>

                    <?php
                            } else { ?>
                    <td class="px-2 py-4 text-sm text-center">
                        <font color="red">Not Paid</font>
                    </td>
                    <?php } ?>
                </tr>


                <?php
                        $i++;
                    }
                }

                $conn->close();
                ?>

            </tbody>
        </table>

    </div>

</body>

</html>