<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location = 'index.php';</script>";
}
include "db.php";

$user_id = $_SESSION['user_id'];
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
$sql = "select right_count, wrong_count, skip_count, captcha_time, extra_time, captcha_count, captcha_rate, auto_approve, terminal, total_earning from users where user_id = '$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$right_count = $row['right_count'];
$wrong_count = $row['wrong_count'];
$skip_count = $row['skip_count'];
$captcha_time = $row['captcha_time'];
$extra_time = $row['extra_time'];
$captcha_rate = $row['captcha_rate'];
$captcha_count = $row['captcha_count'];
$auto_approve = $row['auto_approve'];
$terminal = $row['terminal'];
$total_earning = $row['total_earning'];

$next_order = 0;

if ($right_count >= $captcha_count) {
    if ($auto_approve == 1) {

        $url = 'https://aircraftcaptchaservices.com/CaptchaApi/public/autoApproveOrder-v2';

        // what post fields?
        $fields = array(
            'user_id' => $user_id
        );

        // build the urlencoded data
        $postvars = http_build_query($fields);

        // open connection
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // execute post
        $result = curl_exec($ch);

        // close connection
        curl_close($ch);

        echo "<script>alert('Your $captcha_rate $ payment completed successfully.');</script>";
        echo "<script>window.location = 'captcha.php';</script>";
    } else {
        $next_order = 1;
        echo "<script>alert('Your $captcha_rate $ payment completed successfully. Click on Next order to take next order.');</script>";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #fb3958;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    #snackbar-skip {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #ECE81A;
        color: #000;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar-skip.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    #snackbar-right {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #4BB543;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar-right.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }
    </style>

    <style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>

    <?php
    if ($next_order == 0) {
    ?>

    <script>
    $(document).ready(function() {

        getCaptcha();

        var intervalId, is_request_running = false;
        $("#captcha").focus();
        $("#enter").click(enter);

        $("#skip").click(skip);

        function enter() {
            var loader = document.getElementById("loader");
            var image = document.getElementById("image");
            loader.style.display = "block";
            image.style.display = "none"
            window.localStorage.removeItem("counter")
            if (is_request_running) {
                return false;
            }
            $("#enter").prop('disabled', true);
            is_request_running = true;
            $.post("submitCaptcha.php", {
                    captcha_id: $("#captcha").attr("name"),
                    captcha_text: $('#captcha').val()
                },
                function(data, status) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.is_right == 0)
                        myFunction();
                    else rightSnackbar();
                    //alert("Data: " + obj.wrong_count + "\nStatus: " + status);
                    $("#captcha").focus();
                    let captcha_image = obj.captcha_image;
                    let right_count = obj.right_count;
                    let wrong_count = obj.wrong_count;
                    let skip_count = obj.skip_count;
                    let captcha_id = obj.captcha_id;
                    let captcha_count = obj.captcha_count;
                    let captcha_type = obj.captcha_type;
                    let logout = obj.logout;

                    if (logout == "1") {
                        alert("This user id is being used on another computer");
                        window.location = 'logout.php';
                        return false;
                    }

                    if (parseInt(right_count) >= parseInt(captcha_count)) {
                        window.location = 'captcha.php';
                        return false;
                    }


                    $("#skip").prop('disabled', false);

                    $('#image').attr("src", captcha_image);
                    $("#right_count").html(right_count);
                    $("#wrong_count").html(wrong_count);
                    $("#skip_count").html(skip_count);
                    $("#captcha_type").html("* " + captcha_type);
                    $('#captcha').val('');
                    $("#captcha").attr("name", captcha_id);
                    $("#captcha").focus();

                    $("#enter").prop('disabled', false);

                    is_request_running = false;
                    clearInterval(intervalId);
                    startTimer();
                    loader.style.display = "none";
                    image.style.display = "block"
                });
        }

        function skip() {
            var loader = document.getElementById("loader");
            var image = document.getElementById("image");
            loader.style.display = "block";
            image.style.display = "none"
            $("#skip").prop('disabled', true);
            window.localStorage.removeItem("counter")
            $.post("skipCaptcha.php", {
                    captcha_id: $("#captcha").attr("name"),
                    captcha_text: $('#captcha').val()
                },
                function(data, status) {
                    var obj = jQuery.parseJSON(data);
                    //alert("Data: " + obj.wrong_count + "\nStatus: " + status);
                    skipSnackbar()
                    $("#captcha").focus();
                    let captcha_image = obj.captcha_image;
                    let captcha_id = obj.captcha_id;
                    let right_count = obj.right_count;
                    let wrong_count = obj.wrong_count;
                    let skip_count = obj.skip_count;
                    let captcha_count = obj.captcha_count;
                    let captcha_type = obj.captcha_type;
                    let logout = obj.logout;

                    if (logout == "1") {
                        alert("This user id is being used on another computer");
                        window.location = 'logout.php';
                        return false;
                    }

                    if (parseInt(right_count) >= parseInt(captcha_count)) {
                        window.location = 'captcha.php';
                        return false;
                    }



                    $('#image').attr("src", captcha_image);
                    $('#captcha').val('');
                    $("#captcha_type").html("* " + captcha_type);
                    $("#captcha").attr("name", captcha_id);
                    $("#skip_count").html(skip_count);
                    $("#captcha").focus();


                    $("#skip").prop('disabled', false);

                    clearInterval(intervalId);
                    startTimer();
                    loader.style.display = "none";
                    image.style.display = "block"
                });
        }

        function getCaptcha() {
            var loader = document.getElementById("loader");
            var image = document.getElementById("image");
            var timerText = document.getElementById("captcha_time");
            loader.style.display = "block";
            image.style.display = "none"
            timerText.style.display = "none"
            window.localStorage.removeItem("counter")
            $.get("getCaptcha.php",
                function(data, status) {
                    var obj = jQuery.parseJSON(data);
                    //alert("Data: " + obj.wrong_count + "\nStatus: " + status);
                    timerText.style.display = "block"
                    $("#captcha").focus();
                    let captcha_image = obj.captcha_image;
                    let captcha_id = obj.captcha_id;
                    let right_count = obj.right_count;
                    let wrong_count = obj.wrong_count;
                    let skip_count = obj.skip_count;
                    let captcha_count = obj.captcha_count;
                    let captcha_type = obj.captcha_type;
                    let logout = obj.logout;

                    if (logout == "1") {
                        alert("This user id is being used on another computer");
                        window.location = 'logout.php';
                        return false;
                    }

                    if (parseInt(right_count) >= parseInt(captcha_count)) {
                        window.location = 'captcha.php';
                        return false;
                    }

                    $('#image').attr("src", captcha_image);
                    $('#captcha').val('');
                    $("#captcha_type").html("* " + captcha_type);
                    $("#captcha").attr("name", captcha_id);
                    $("#skip_count").html(skip_count);
                    $("#captcha").focus();

                    clearInterval(intervalId);
                    startTimer();
                    loader.style.display = "none";
                    image.style.display = "block";
                });
        }

        function myFunction() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }

        function skipSnackbar() {
            var x = document.getElementById("snackbar-skip");
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }

        function rightSnackbar() {
            var x = document.getElementById("snackbar-right");
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }




        function startTimer() {
            let savedCounter = window.localStorage.getItem("counter")
            let counter = document.getElementById("captcha_orig_time").innerHTML;
            if (savedCounter)
                counter = parseInt(savedCounter)
            intervalId = setInterval(() => {
                document.getElementById("captcha_time").innerHTML = counter + " sec";
                counter -= 1;

                if (counter === -1) {
                    skip();
                    clearInterval(intervalId);
                }
            }, 1000);
        }
        startTimer();


        $(document).on('keydown', function(e) {
            if (e.which == 13) {
                enter();
            }
            if (e.which == 27) {
                skip();
            }
        });

        $(window).on('unload', function(event) {
            let counter = document.getElementById("captcha_time").innerHTML;
            window.localStorage.setItem("counter", counter)
        });

    });
    </script>

    <?php
    }
    ?>

    <script>
    $(document).ready(function() {
        $("#captcha").focus();
        $("#next_order").click(function() {
            $.post("CaptchaApi/public/createNextOrder-v2", {
                    user_id: $("#user_id").attr("name")
                },
                function(data, status) {
                    //var obj = jQuery.parseJSON (data);
                    alert(
                        'Your request for Next order has been sent to admin. Please wait for response'
                    );
                    $('#next_order').prop('disabled', true);
                    $("#captcha").focus();
                });
        });

        $("#captcha").on('change keydown paste input', function() {
            $("#captcha").prop("type", "text");

        });

    });
    </script>



</head>

<body class="bg-gradient-to-r from-blueviolet to-darkslateblue">

    <p id="user_id" name="<?= $user_id; ?>" hidden></p>
    <p id="captcha_orig_time" hidden><?= $captcha_time; ?></p>

    <nav class="bg-darkslateblue">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-btn">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-white text-xl font-bold">Aircraft Captcha Services</span>
                    </div>
                    <div class="hidden sm:block sm:ml-6 w-full" id="desktop-menu">
                        <div class="flex justify-end items-center space-x-4 w-full">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                            <span class="text-white text-sm uppercase font-medium"><?= $_SESSION['user_id'] ?></span>

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

                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                            id="menu">
                            <!-- Active: "bg-gray-100", Not Active: "" -->

                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 uppercase font-bold"
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




    <div style="background-image: url('body-bg.png');"
        class="text-primary lg:p-20 bg-bgWhite h-screen flex flex-col items-center">
        <div
            class="rounded-xl grid grid-cols font-sans bg-white p-4 lg:px-8 shadow-xl items-center justify-items-center gap-1">
            <div class="loader" id="loader" style="display:none;"></div>
            <img src="<?= $captcha_image; ?>" alt="captcha" id="image"
                class="w-80 h-36 mb-5 lg:mx-10 rounded-xl border-1 border-coolGray shadow" />
            <div class="flex justify-between content-center items-center w-full">
                <div class="text-start text-lightPink text-sm float-left" id="captcha_type">
                    * <?= $captcha_type; ?>
                </div>
                <div class="float-right w-auto content-center px-3 mr-2 bg-lightPink rounded-full shadow items-center">
                    <span class="text-white text-center w-full text-xs lg:text-sm" id="captcha_time">
                        <?= $captcha_time; ?> sec
                    </span>
                </div>
            </div>
            <div
                class="w-full grid grid-cols-5 gap-4 text-black px-4 py-3 bg-F5F8FF rounded-xl shadow-lg mt-2 items-center">
                <div class="col-span-4" id="form">
                    <input type="password" autocomplete="off" id="captcha" placeholder="Enter Captcha"
                        name="<?= $captcha_id; ?>" class="w-full bg-F5F8FF outline-none" />
                </div>



                <?php
                if ($next_order == 1) {
                ?>
                <button id="skip" disabled
                    class="rounded-full py-px bg-lightPink hover:bg-brightYellow shadow-md float-right col-span-1 cursor-pointer items-center">
                    <div class="text-xs lg:text-sm py-px text-white text-center">
                        Skip
                    </div>
                </button>
                <?php
                } else {
                ?>
                <button id="skip"
                    class="rounded-full py-px bg-lightPink hover:bg-brightYellow shadow-md float-right col-span-1 cursor-pointer items-center">
                    <div class="text-xs lg:text-sm py-px text-white text-center">
                        Skip
                    </div>
                </button>
                <?php }
                ?>


            </div>
            <div class="flex lg:flex-col-2 gap-10 my-4">

                <?php
                if ($next_order == 1) {
                ?>
                <button disabled
                    class="rounded-full px-6 text-center py-2 font-nexabold text-15 text-white border border-lightPink bg-lightPink hover:bg-darkBlue shadow-lg"
                    id="enter">
                    Submit
                </button>
                <?php
                } else {
                ?>
                <button
                    class="rounded-full px-6 text-center py-2 font-nexabold text-15 text-white border border-lightPink bg-lightPink hover:bg-darkBlue shadow-lg"
                    id="enter">
                    Submit
                </button>
                <?php }
                ?>


            </div>
            <div class="flex flex-col-5 lg:gap-5 gap-2 text-13 items-center">

                <div
                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                    <div>
                        <img alt="Natacha" src="interest.png" class="w-5 h-5" />
                    </div>
                    <div class="text-center"><?= $captcha_count; ?>/<?= $captcha_rate; ?>$</div>
                </div>

                <div
                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                    <div>
                        <img alt="Natacha" src="checkmark.svg" class="w-5 h-5" />
                    </div>
                    <div class="text-center" id="right_count"><?= $right_count; ?></div>
                </div>
                <div
                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                    <div>
                        <img alt="Natacha" src="remove.svg" class="w-5 h-5" />
                    </div>
                    <div class="text-center" id="wrong_count"><?= $wrong_count; ?></div>
                </div>

                <div
                    class="py-1 shadow-md px-2 bg-bgWhite text-black border-1 border-coolGray rounded-lg flex flex-col-2 gap-2 items-center justify-items-center">
                    <div>
                        <img alt="Natacha" src="right-arrow.svg" class="w-5 h-5" />
                    </div>
                    <div class="text-center" id="skip_count"><?= $skip_count; ?></div>
                </div>
            </div>

            <a href="orderHistory.php"
                class="w-full mt-4 text-center px-4 py-2 text-12 bg-blueviolet text-white border-0 font-medium font-nexabold border-Gold my-2 shadow-xl rounded-full">
                Total earning - <?= $total_earning; ?>$
            </a>

            <div class="mt-6">
                <div class="text-coolGray text-xs lg:text-sm">
                    <span class="text-primary">*</span> All words are case sensitive.
                </div>
                <div class="text-coolGray text-xs lg:text-sm">
                    <span class="text-primary">*</span> Calculative captchas must be solved.
                </div>
                <div class="text-coolGray text-xs lg:text-sm">
                    <span class="text-primary">*</span> Length of captchas will be between 6 to 12 characters.
                </div>
                <div class="text-coolGray text-xs lg:text-sm">
                    <span class="text-primary">*</span> There result can also be negative numbers eg. (5 - 8 = -3).
                </div>


            </div>
        </div>
    </div>

    <div id="snackbar">Wrong Answer..</div>
    <div id="snackbar-right">Right Answer..</div>
    <div id="snackbar-skip">Skipped..</div>

</body>

</html>
