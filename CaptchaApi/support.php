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

$sql2 = "select * from support_details where id = 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$mobile = $row2['mobile'];
$email = $row2["email"];
$showContent = $row2["showContent"];
$isWhatsappEnabled = $row2["isWhatsappEnabled"];
$isWhatsappEnabledDemo = $row2["isWhatsappEnabledDemo"];
$isFacebookEnabled = $row2["isFacebookEnabled"];
$isFacebookEnabledDemo = $row2["isFacebookEnabledDemo"];
$isInstaEnabled = $row2["isInstaEnabled"];
$isInstaEnabledDemo = $row2["isInstaEnabledDemo"];
$showDemoMessage = $row2["showDemoMessage"];
$showDemoCompletedMessage = $row2["showDemoCompletedMessage"];

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $showContent = $_POST['showContent'];
    $isWhatsappEnabled = $_POST['isWhatsappEnabled'];
    $isWhatsappEnabledDemo = $_POST['isWhatsappEnabledDemo'];
    $isFacebookEnabled = $_POST["isFacebookEnabled"];
    $isFacebookEnabledDemo = $_POST["isFacebookEnabledDemo"];
    $isInstaEnabled = $_POST["isInstaEnabled"];
    $isInstaEnabledDemo = $_POST["isInstaEnabledDemo"];
    $showDemoMessage = $_POST["showDemoMessage"];
    $showDemoCompletedMessage = $_POST["showDemoCompletedMessage"];


    $sql = "update support_details set mobile = '$mobile', email = '$email', showContent = $showContent, isWhatsappEnabled = $isWhatsappEnabled, isWhatsappEnabledDemo = $isWhatsappEnabledDemo, isFacebookEnabled = $isFacebookEnabled, isFacebookEnabledDemo = $isFacebookEnabledDemo, isInstaEnabled = $isInstaEnabled, isInstaEnabledDemo = $isInstaEnabledDemo, showDemoMessage = $showDemoMessage, showDemoCompletedMessage = $showDemoCompletedMessage  where id = 1";
    if ($conn->query($sql)) {
        echo "<script>alert('Details updated successfully.');</script>";
        echo "<script>window.location = 'support.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>

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

                        <h3 class="font-bold text-xl ">CHANGE SUPPORT DETAILS</h3>
                        <hr class="my-1" />


                        <form action="" method="post" class="mt-4">

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Mobile No.</label>
                                <input type="number" class="form-control" name="mobile" value="<?= $mobile ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Email</label>
                                <input type="text" class="form-control" name="email" value="<?= $email ?>" />
                            </div>

                            <div class="form-group">

                                <p>Show contact details:</p>
                                <input type="radio" id="showContentOn" name="showContent" value="1"
                                    <?= $showContent == 1 ? 'checked' : ''; ?>>
                                <label for="showContentOn">ON</label><br>
                                <input type="radio" id="showContentOf" name="showContent" value="0"
                                    <?= $showContent == 0 ? 'checked' : ''; ?>>
                                <label for="showContentOf">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show whatsapp chat on website:</p>
                                <input type="radio" id="isWhatsappEnabledOn" name="isWhatsappEnabled" value="1"
                                    <?= $isWhatsappEnabled == 1 ? 'checked' : ''; ?>>
                                <label for="isWhatsappEnabledOn">ON</label><br>
                                <input type="radio" id="isWhatsappEnabledOff" name="isWhatsappEnabled" value="0"
                                    <?= $isWhatsappEnabled == 0 ? 'checked' : ''; ?>>
                                <label for="isWhatsappEnabledOff">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show whatsapp chat on demo:</p>
                                <input type="radio" id="isWhatsappEnabledDemoOn" name="isWhatsappEnabledDemo" value="1"
                                    <?= $isWhatsappEnabledDemo == 1 ? 'checked' : ''; ?>>
                                <label for="isWhatsappEnabledDemoOn">ON</label><br>
                                <input type="radio" id="isWhatsappEnabledDemoOFF" name="isWhatsappEnabledDemo" value="0"
                                    <?= $isWhatsappEnabledDemo == 0 ? 'checked' : ''; ?>>
                                <label for="isWhatsappEnabledDemoOFF">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Facebook on website:</p>
                                <input type="radio" id="isFacebookEnabledOn" name="isFacebookEnabled" value="1"
                                    <?= $isFacebookEnabled == 1 ? 'checked' : ''; ?>>
                                <label for="isFacebookEnabledOn">ON</label><br>
                                <input type="radio" id="isFacebookEnabledOff" name="isFacebookEnabled" value="0"
                                    <?= $isFacebookEnabled == 0 ? 'checked' : ''; ?>>
                                <label for="isFacebookEnabledOff">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Facebook on app:</p>
                                <input type="radio" id="isFacebookEnabledDemoOn" name="isFacebookEnabledDemo" value="1"
                                    <?= $isFacebookEnabledDemo == 1 ? 'checked' : ''; ?>>
                                <label for="isFacebookEnabledDemoOn">ON</label><br>
                                <input type="radio" id="isFacebookEnabledDemoOFF" name="isFacebookEnabledDemo" value="0"
                                    <?= $isFacebookEnabledDemo == 0 ? 'checked' : ''; ?>>
                                <label for="isFacebookEnabledDemoOFF">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Instagram on website:</p>
                                <input type="radio" id="isInstaEnabledOn" name="isInstaEnabled" value="1"
                                    <?= $isInstaEnabled == 1 ? 'checked' : ''; ?>>
                                <label for="isInstaEnabledOn">ON</label><br>
                                <input type="radio" id="isInstaEnabledOff" name="isInstaEnabled" value="0"
                                    <?= $isInstaEnabled == 0 ? 'checked' : ''; ?>>
                                <label for="isInstaEnabledOff">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Instagram on app:</p>
                                <input type="radio" id="isInstaEnabledDemoOn" name="isInstaEnabledDemo" value="1"
                                    <?= $isInstaEnabledDemo == 1 ? 'checked' : ''; ?>>
                                <label for="isInstaEnabledDemoOn">ON</label><br>
                                <input type="radio" id="isInstaEnabledDemoOFF" name="isInstaEnabledDemo" value="0"
                                    <?= $isInstaEnabledDemo == 0 ? 'checked' : ''; ?>>
                                <label for="isInstaEnabledDemoOFF">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Demo Message on Demo Page:</p>
                                <input type="radio" id="showDemoMessageOn" name="showDemoMessage" value="1"
                                    <?= $showDemoMessage == 1 ? 'checked' : ''; ?>>
                                <label for="showDemoMessageOn">ON</label><br>
                                <input type="radio" id="showDemoMessageOFF" name="showDemoMessage" value="0"
                                    <?= $showDemoMessage == 0 ? 'checked' : ''; ?>>
                                <label for="showDemoMessageOFF">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Demo Message after Demo Completion:</p>
                                <input type="radio" id="showDemoCompletedMessageOn" name="showDemoCompletedMessage"
                                    value="1" <?= $showDemoCompletedMessage == 1 ? 'checked' : ''; ?>>
                                <label for="showDemoCompletedMessageOn">ON</label><br>
                                <input type="radio" id="showDemoCompletedMessageOFF" name="showDemoCompletedMessage"
                                    value="0" <?= $showDemoCompletedMessage == 0 ? 'checked' : ''; ?>>
                                <label for="showDemoCompletedMessageOFF">OFF</label>

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