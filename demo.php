<?php
session_start();
include "db.php";

$sql3 = "select mobile, email, isWhatsappEnabledDemo, isFacebookEnabled, isInstaEnabled, showDemoCompletedMessage from support_details where id = 1";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();

$mobile = $row3['mobile'];
$email = $row3["email"];
$isWhatsappEnabledDemo = $row3["isWhatsappEnabledDemo"];
$isFacebookEnabled = $row3["isFacebookEnabled"];
$isInstaEnabled = $row3["isInstaEnabled"];
$showDemoCompletedMessage = $row3["showDemoCompletedMessage"];

$user_id = $_SESSION['user_id'];
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

$right_count = 0;
if (isset($_SESSION['right_count'])) {
    $right_count = $_SESSION['right_count'];
} else {
    $_SESSION['right_count'] = $right_count;
}

$wrong_count = 0;
if (isset($_SESSION['wrong_count'])) {
    $wrong_count = $_SESSION['wrong_count'];
} else {
    $_SESSION['wrong_count'] = $wrong_count;
}

$skip_count = 0;
if (isset($_SESSION['skip_count'])) {
    $skip_count = $_SESSION['skip_count'];
} else {
    $_SESSION['skip_count'] = $skip_count;
}


$captcha_time = 60;
$captcha_rate = 1;
$captcha_count = 500;
$terminal = "999";
$total_earning = 0;

$_SESSION['captcha_time'] = $captcha_time;
$_SESSION['captcha_rate'] = 1;
$_SESSION['captcha_count'] = 500;
$_SESSION['total_earning'] = 0;


$next_order = 0;


$sql2 = "select id, image, captcha_type, captcha_text from captchas where terminal = '999' order by RAND() limit 1";
if (isset($_SESSION['captcha_id'])) {
    $captcha_id = $_SESSION['captcha_id'];
    $sql2 = "select id, image, captcha_type, captcha_text from captchas where id = '$captcha_id'";
}


$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$captcha_id = $row2['id'];
$captcha_image = $row2["image"];
$captcha_type = $row2["captcha_type"];
$captcha_text = $row2["captcha_text"];
$_SESSION['captcha_id'] = $row2['id'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Codelaxy" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="Fill Captcha and Earn">
    <title>Demo - Aircraft Captcha Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="CaptchaApi/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Kavoon' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
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
                    //darkslateblue: "#5B7742",
                    darkslateblue: "#372495",
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
            $.post("submitCaptchaDemo.php", {
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
                    let captcha_words = obj.captcha_words;
                    let logout = obj.logout;

                    if (right_count + wrong_count + skip_count >= 20) {
                        const demoCompleted = document.querySelector("#demo_completed");
                        demoCompleted.classList.toggle("hidden");
                    }


                    if (logout == "1") {
                        alert("This user id is being used on another computer");
                        window.location = 'logout-demo.php';
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
                    $("#captcha_words").html("* " + captcha_words + " words");
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
            $.post("skipCaptchaDemo.php", {
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
                    let captcha_words = obj.captcha_words;
                    let logout = obj.logout;

                    if (right_count + wrong_count + skip_count >= 20) {
                        const demoCompleted = document.querySelector("#demo_completed");
                        demoCompleted.classList.toggle("hidden");
                    }


                    if (logout == "1") {
                        alert("This user id is being used on another computer");
                        window.location = 'logout-demo.php';
                        return false;
                    }


                    $('#image').attr("src", captcha_image);
                    $('#captcha').val('');
                    $("#captcha_type").html("* " + captcha_type);
                    $("#captcha_words").html("* " + captcha_words + " words");
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
            $.post("CaptchaApi/public/createNextOrder", {
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


    <div id="demo_completed" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->
            <div
                class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-4 sm:p-6 sm:pb-4">
                    <div class="">
                        <div class="flex flex-col items-center content-between">
                            <img src="demo-completed.svg" class="w-2/4" />
                        </div>

                        <div class="sm:mt-0 sm:ml-4 sm:text-left mt-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Demo completed
                            </h3>
                            <?php
                            if ($showDemoCompletedMessage == 1) { ?><div class="mt-2">
                                <p class="text-sm text-gray-500">Your demo is completed, if you want to purchase the
                                    paid plan and want to earn real money, Whatsapp us on <a
                                        href="https://api.whatsapp.com/send?phone=91<?= $mobile; ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans"
                                        target="_blank" class="font-medium">+91
                                        <?= $mobile ?></a> or
                                    E-mail us at
                                    <a href="mailto:<?= $email ?>" class="font-medium"><?= $email ?></a> .
                                </p>
                            </div> <?php }
                                        ?>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="location.href = 'logout-demo.php';"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Go back to dashboard</button>

                </div>
            </div>
        </div>
    </div>

    <nav class="bg-darkslateblue">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="hidden absolute inset-y-0 left-0 flex items-center sm:hidden">
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
                    <div class="flex-shrink-0 flex items-center hidden md:block">
                        <span class="text-white text-xl font-bold">Aircraft Captcha Services (Demo)</span>
                    </div>


                </div>



                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="flex justify-end"> <a href="viewMsgsDemo.php"
                            class="block px-4 py-2 text-sm text-white rounded-full py-px bg-lightPink hover:bg-brightYellow shadow-md cursor-pointer items-center"
                            role="menuitem" tabindex="-1" id="user-menu-item-1">View Messages</a></div>
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
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Demo</a>
                            <a href="viewMsgsDemo.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">View Messages</a>
                            <a href="logout-demo.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-2">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->


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
        class="text-primary lg:p-10 bg-bgWhite h-screen flex flex-col items-center">

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
            <div class="flex justify-between content-center items-center w-full">
                <div class="text-start text-lightPink text-sm float-left" id="captcha_words">
                    * <?= strlen($captcha_text); ?> words
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
            <div class="flex items-center justify=between my-4 w-full">
                <div class="w-full flex justify-center ml-4">
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
                <div class="flex flex-row-reverse">
                    <?php if ($isWhatsappEnabledDemo == 1) {
                    ?>
                    <a href="https://api.whatsapp.com/send?phone=91<?= $mobile; ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans"
                        target="_blank">
                        <img class="justify-items-end shadow-2xl" src="whatsapp.png" width="40" /></a>
                    <?php

                    } ?>
                </div>

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

            <span
                class="w-full mt-4 text-center px-4 py-2 text-12 bg-gradient-to-r from-blueviolet to-darkslateblue text-white border-0 font-medium font-nexabold border-Gold my-2 shadow-xl rounded-full">
                Total earning - <?= $total_earning; ?>$
            </span>

            <div class="">


                <?php
                if ((isset($isFacebookEnabled) && $isFacebookEnabled != 0) || (isset($isInstaEnabled) && $isInstaEnabled != 0)) {

                ?>

                <div class="mt-2">
                    <div class="text-coolGray text-sm lg:text-base">
                        <span class="text-red-600">* For Payment Proofs, check our social media.</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        <?php
                            if ((isset($isInstaEnabled) && $isInstaEnabled != 0)) {
                            ?>
                        <div class="text-coolGray text-sm lg:text-base">
                            <a href="https://www.instagram.com/aircraftdataentry/" target="_blank"> <span
                                    class="text-primary">Instagram</span></a>
                        </div>
                        <?php
                            }
                            ?>

                        <?php
                            if ((isset($isFacebookEnabled) && $isFacebookEnabled != 0)) {
                            ?>
                        <div class="text-coolGray text-sm lg:text-base">
                            <a href="https://www.facebook.com/AIRCRAFTDATAENTRY/" target="_blank"><span
                                    class="text-primary">Facebook</span></a>
                        </div>
                        <?php
                            }
                            ?>


                    </div>

                    <?php

                }

                    ?>

                </div>



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