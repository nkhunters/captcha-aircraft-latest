<?php

session_start();

include "db.php";

$stmt = "select web_status from websitestatus";
$rset = $conn->query($stmt);
$status = $rset->fetch_assoc();
if ($status['web_status'] == 0) {
    echo "<script>window.location = 'captcygtr.php';</script>";
}

$sql2 = "select * from support_details where id = 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$mobile = $row2['mobile'];
$email = $row2["email"];
$showContent = $row2["showContent"];
$isWhatsappEnabled = $row2["isWhatsappEnabled"];
$showDemoMessage = $row2["showDemoMessage"];

if (isset($_POST['submit'])) {

    $uname = $_POST['username'];
    $pwd = $_POST['password'];

    $sql = "select user_id, password, captcha_time from users where user_id = '$uname' and platform IN('web', 'both') and on_hold = 0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($pwd, $row['password'])) {
            $session_id = session_id();
            $sql_session = "update users set session_id = '$session_id' where user_id = '$uname'";
            if ($conn->query($sql_session)) {
                $_SESSION['user_id'] = $uname;
                $_SESSION['captcha_time'] = $row['captcha_time'];
                echo "<script>alert('Id already registered and activated.');</script>";
                echo "<script>window.location = 'captcha.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid password.');</script>";
            echo "<script>window.location = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid username.');</script>";
        echo "<script>window.location = 'index.php';</script>";
    }
}


?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - Aircraft Captcha Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="CaptchaApi/assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="CaptchaApi/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/themify-icons.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/metisMenu.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/slicknav.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="CaptchaApi/assets/css/typography.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/default-css.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/styles.css">
    <link rel="stylesheet" href="CaptchaApi/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="CaptchaApi/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: "#da373d",
                        blueviolet: "#9134f5",
                        darkslateblue: "#372495",
                        slateblue: "#7d55db",
                        mediumslateblue: "#8655e0",
                        mediumpurpule: "#a059f5",
                        lightPink: "#D02F68",
                    },
                },
            },
        };

        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>



</head>

<body class="bg-gradient-to-r from-blueviolet to-darkslateblue">

    <!-- Whatsapp Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter your 10 digits WhatsApp Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <br />
                    <form id="whatsapp-form" class="" method="post" action="save-whatsapp.php">
                        <div>
                            <img class="m-auto" src="logo.jpg" width="200" />
                        </div>
                        <div class="my-12">
                            <div class="form-gp">
                                <label for="exampleInputEmail1">Enter your 10 digits WhatsApp Number</label>
                                <input class="" type="text" maxlength="10" minlength="10" id="exampleInputEmail1" name="mobile" onkeypress='validate(event)' required />
                                <i class="ti-themify-favicon"></i>
                            </div>
                            <br />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white font-semibold rounded-md shadow-md py-2 px-3" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" value="submit" form="whatsapp-form" class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen container w-9/12">
        <div class="m-auto">
            <div class="shadow-2xl bg-gradient-to-r from-mediumslateblue to-mediumpurpule rounded-3xl my-6 lg:my-0">
                <div class="flex">
                    <div class="hidden lg:block w-3/5 flex items-center justify-center">
                        <div class="flex flex-col items-center content-between p-20">
                            <img class="" src="bg.svg" width="350" alt="My Happy SVG" />
                            <?php if ($showContent == 1) {

                            ?>
                                <span class="mt-12 text-base text-center">
                                    For more details please WhatsApp us at
                                    <a href="https://api.whatsapp.com/send?phone=91<?= $mobile ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans" target="_blank" class="font-medium text-white">+91
                                        <?= $mobile ?></a> or
                                    E-mail us at
                                    <a href="mailto:<?= $email ?>" class="font-medium text-white"><?= $email ?></a> </span>
                            <?php
                            } ?>

                        </div>
                    </div>
                    <div class="bg-white rounded-3xl lg:rounded-none lg:rounded-tr-3xl lg:rounded-br-3xl w-full lg:w-1/2 p-6 flex items-center justify-center">
                        <form class="" method="post" action="">
                            <div>
                                <img class="m-auto" src="logo.jpg" width="200" />
                            </div>
                            <div class="my-12 py-12 w-full">
                                <a id="demo-btn-modal" class="text-center font-medium rounded-full py-2 px-4 mx-auto flex items-center justify-center text-center border border-gray-200 bg-lightPink" data-toggle="modal" href="#deleteModal"><span class="text-white font-bold">Click
                                        here to
                                        try demo captcha work</a>
                                <a id="demo-btn-link" class="hidden text-center font-medium rounded-full py-2 px-4 mx-auto flex items-center justify-center text-center border border-gray-200 bg-lightPink" href="demo.php"><span class="text-white font-bold">Click here to
                                        try demo captcha work</a>
                                <br />

                                <p class="text-sm text-primary font-bold">
                                    Verify words ! Earn Money ...
                                    <br />
                                    No target , accuracy , time limit our deduction.
                                    <br />
                                    Daily payment & Lifetime work available.
                                </p>

                                <?php if ($showDemoMessage == 1) { ?>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">For more details please, Whatsapp us on <a href="https://api.whatsapp.com/send?phone=91<?= $mobile; ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans" target="_blank" class="font-medium">+91
                                                <?= $mobile ?></a> or
                                            E-mail us at
                                            <a href="mailto:<?= $email ?>" class="font-medium"><?= $email ?></a>
                                        </p>
                                    </div>

                                    <div class="lg:hidden mt-6 text-sm text-center">
                                        For more details please WhatsApp us at
                                        <a href="https://api.whatsapp.com/send?phone=91<?= $mobile ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans" target="_blank" class="font-medium text-lightPink">+91
                                            <?= $mobile ?></a> or
                                        E-mail us at
                                        <a href="mailto:<?= $email ?>" class="font-medium text-lightPink"><?= $email ?></a>
                                    </div>
                                <?php } ?>


                                <div class="w-full mt-4 flex flex-col items-center">
                                    <a class="flex items-center" href="https://www.youtube.com/watch?v=thaxDZ2zfTA" target="_blank">
                                        <img src="youtube.png" width="50" height="50" />
                                        <span class="text-black font-bold ml-1">Youtube</span>
                                    </a>

                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($isWhatsappEnabled == 1) {
        ?>
            <a href="https://api.whatsapp.com/send?phone=91<?= $mobile; ?>&text=Hi, Aircraft Captcha Services, i want to enquire about your plans" target="_blank">
                <img class="fixed shadow-2xl right-6 bottom-6 lg:right-8 lg:bottom-8 z-50" src="whatsapp.png" width="50" /></a>
        <?php

        } ?>

    </div>




    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="CaptchaApi/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="CaptchaApi/assets/js/popper.min.js"></script>
    <script src="CaptchaApi/assets/js/bootstrap.min.js"></script>
    <script src="CaptchaApi/assets/js/owl.carousel.min.js"></script>
    <script src="CaptchaApi/assets/js/metisMenu.min.js"></script>
    <script src="CaptchaApi/assets/js/jquery.slimscroll.min.js"></script>
    <script src="CaptchaApi/assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="CaptchaApi/assets/js/plugins.js"></script>
    <script src="CaptchaApi/assets/js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            let numberSaved = false;

            if (localStorage.getItem("numberSaved") == "1")
                numberSaved = true;

            if (numberSaved) {
                $("#demo-btn-modal").addClass("hidden");
                $("#demo-btn-link").removeClass("hidden");
            } else {
                $("#demo-btn-link").addClass("hidden");
                $("#demo-btn-modal").removeClass("hidden");
            }


        });
    </script>

</body>

</html>