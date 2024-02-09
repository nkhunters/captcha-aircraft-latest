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

$sql2 = "select * from main_website_social_details where id = 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$whatsapp = $row2['whatsapp'];
$email = $row2["email"];
$facebook = $row2["facebook"];
$instagram = $row2["instagram"];
$google = $row2["google"];
$youtube = $row2["youtube"];
$justdial = $row2["justdial"];

$formDemoVideoEng = $row2["formDemoVideoEng"];
$formTrainingVideoEng = $row2["formTrainingVideoEng"];

$formDemoVideoHindi = $row2["formDemoVideoHindi"];
$formTrainingVideoHindi = $row2["formTrainingVideoHindi"];

$formDemoVideoMarathi = $row2["formDemoVideoMarathi"];
$formTrainingVideoMarathi = $row2["formTrainingVideoMarathi"];

$formDemoWork = $row2["formDemoWork"];

$captchaDemoVideoEng = $row2["captchaDemoVideoEng"];
$captchaTrainingVideoEng = $row2["captchaTrainingVideoEng"];

$captchaDemoVideoHindi = $row2["captchaDemoVideoHindi"];
$captchaTrainingVideoHindi = $row2["captchaTrainingVideoHindi"];

$captchaDemoVideoMarathi = $row2["captchaDemoVideoMarathi"];
$captchaTrainingVideoMarathi = $row2["captchaTrainingVideoMarathi"];

$captchaDemoVideo = $row2["captchaDemoVideo"];
$captchaTrainingVideo = $row2["captchaTrainingVideo"];

$captchaDemoWork = $row2["captchaDemoWork"];
$captchaDemoApp = $row2["captchaDemoApp"];

if (isset($_POST['submit'])) {

    $whatsapp = $_POST['whatsapp'];
    $email = $_POST["email"];
    $facebook = $_POST["facebook"];
    $instagram = $_POST["instagram"];
    $google = $_POST["google"];
    $youtube = $_POST["youtube"];
    $justdial = $_POST["justdial"];

    $formDemoVideoEng = $_POST["formDemoVideoEng"];
    $formTrainingVideoEng = $_POST["formTrainingVideoEng"];

    $formDemoVideoHindi = $_POST["formDemoVideoHindi"];
    $formTrainingVideoHindi = $_POST["formTrainingVideoHindi"];

    $formDemoVideoMarathi = $_POST["formDemoVideoMarathi"];
    $formTrainingVideoMarathi = $_POST["formTrainingVideoMarathi"];

    $formDemoWork = $_POST["formDemoWork"];

    $captchaDemoVideoEng = $_POST["captchaDemoVideoEng"];
    $captchaTrainingVideoEng = $_POST["captchaTrainingVideoEng"];

    $captchaDemoVideoHindi = $_POST["captchaDemoVideoHindi"];
    $captchaTrainingVideoHindi = $_POST["captchaTrainingVideoHindi"];

    $captchaDemoVideoMarathi = $_POST["captchaDemoVideoMarathi"];
    $captchaTrainingVideoMarathi = $_POST["captchaTrainingVideoMarathi"];

    $captchaDemoWork = $_POST["captchaDemoWork"];
    $captchaDemoApp = $_POST["captchaDemoApp"];


    $sql = "update main_website_social_details set whatsapp = '$whatsapp', email = '$email', facebook = '$facebook', instagram = '$instagram', google = '$google', youtube = '$youtube', justdial = '$justdial', formDemoVideoEng = '$formDemoVideoEng', formTrainingVideoEng = '$formTrainingVideoEng', formDemoVideoHindi = '$formDemoVideoHindi', formTrainingVideoHindi = '$formTrainingVideoHindi', formDemoVideoMarathi = '$formDemoVideoMarathi', formTrainingVideoMarathi = '$formTrainingVideoMarathi', formDemoWork = '$formDemoWork', captchaDemoVideoEng = '$captchaDemoVideoEng', captchaTrainingVideoEng = '$captchaTrainingVideoEng', captchaDemoVideoHindi = '$captchaDemoVideoHindi', captchaTrainingVideoHindi = '$captchaTrainingVideoHindi', captchaDemoVideoMarathi = '$captchaDemoVideoMarathi', captchaTrainingVideoMarathi = '$captchaTrainingVideoMarathi', captchaDemoWork = '$captchaDemoWork', captchaDemoApp = '$captchaDemoApp' where id = 1";
    if ($conn->query($sql)) {
        echo "<script>alert('Details updated successfully.');</script>";
        echo "<script>window.location = 'main-website-social.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Main Website Social Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet"
        type="text/css" />

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

<body>

    <?php include 'nav.php'; ?>

    <br />

    <?php
    if ($enteredPassword == $savedPassword) {
    ?>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="card"
                    style="box-shadow: 0 0 4px 0 rgba(0,0,0,.08), 0 2px 4px 0 rgba(0,0,0,.12);  border-radius: 3px;">


                    <br />
                    <div class="card-body">

                        <h3 class="font-bold text-xl ">Main website SUPPORT DETAILS</h3>
                        <hr class="my-1" />


                        <form action="" method="post" class="mt-4">

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Whatsapp No.</label>
                                <input type="number" class="form-control" name="whatsapp" value="<?= $whatsapp ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Email</label>
                                <input type="text" class="form-control" name="email" value="<?= $email ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Facebook</label>
                                <input type="text" class="form-control" name="facebook" value="<?= $facebook ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Instagram</label>
                                <input type="text" class="form-control" name="instagram" value="<?= $instagram ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Google</label>
                                <input type="text" class="form-control" name="google" value="<?= $google ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Youtube</label>
                                <input type="text" class="form-control" name="youtube" value="<?= $youtube ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Justdial</label>
                                <input type="text" class="form-control" name="justdial" value="<?= $justdial ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Demo Video English</label>
                                <input type="text" class="form-control" name="formDemoVideoEng"
                                    value="<?= $formDemoVideoEng ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Demo Video Hindi</label>
                                <input type="text" class="form-control" name="formDemoVideoHindi"
                                    value="<?= $formDemoVideoHindi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Demo Video Marathi</label>
                                <input type="text" class="form-control" name="formDemoVideoMarathi"
                                    value="<?= $formDemoVideoMarathi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Training Video English</label>
                                <input type="text" class="form-control" name="formTrainingVideoEng"
                                    value="<?= $formTrainingVideoEng ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Training Video Hindi</label>
                                <input type="text" class="form-control" name="formTrainingVideoHindi"
                                    value="<?= $formTrainingVideoHindi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Training Video Marathi</label>
                                <input type="text" class="form-control" name="formTrainingVideoMarathi"
                                    value="<?= $formTrainingVideoMarathi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Form Filling Demo Work</label>
                                <input type="text" class="form-control" name="formDemoWork"
                                    value="<?= $formDemoWork ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Demo Video English</label>
                                <input type="text" class="form-control" name="captchaDemoVideoEng"
                                    value="<?= $captchaDemoVideoEng ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Demo Video Hindi</label>
                                <input type="text" class="form-control" name="captchaDemoVideoHindi"
                                    value="<?= $captchaDemoVideoHindi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Demo Video Marathi</label>
                                <input type="text" class="form-control" name="captchaDemoVideoMarathi"
                                    value="<?= $captchaDemoVideoMarathi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Training Video English</label>
                                <input type="text" class="form-control" name="captchaTrainingVideoEng"
                                    value="<?= $captchaTrainingVideoEng ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Training Video Hindi</label>
                                <input type="text" class="form-control" name="captchaTrainingVideoHindi"
                                    value="<?= $captchaTrainingVideoHindi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Training Video Marathi</label>
                                <input type="text" class="form-control" name="captchaTrainingVideoMarathi"
                                    value="<?= $captchaTrainingVideoMarathi ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Demo Work</label>
                                <input type="text" class="form-control" name="captchaDemoWork"
                                    value="<?= $captchaDemoWork ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Captcha Demo App</label>
                                <input type="text" class="form-control" name="captchaDemoApp"
                                    value="<?= $captchaDemoApp ?>" />
                            </div>

                            <br>

                            <div class="form-group">
                                <button type="submit" value="submit" name="submit"
                                    class="form-control float-right bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2 text-lg text-white mt-4">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</body>

</html>