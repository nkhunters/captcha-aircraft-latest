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

// AWS Info
$bucketName = 'captchas-new';
$IAM_KEY = 'AKIASKNODFAMRJ5O7B27';
$IAM_SECRET = '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';

$plan_id = $_GET['plan_id'];
$isEnabled = 0;
if (isset($plan_id)) {
    $sql2 = "select * from main_website_plans where id = $plan_id";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $planName = $row2['planName'];
    // $engName = $row2['engName'];
    // $hindiName = $row2['hindiName'];
    // $marathiName = $row2['marathiName'];
    // $hindiDesc = $row2['hindiDesc'];
    // $engDesc = $row2['engDesc'];
    // $marathiDesc = $row2['marathiDesc'];
    $isEnabled = $row2['isEnabled'];
    $paymentLink = $row2['paymentLink'];
    //$isOffer = $row2['planType'] == "offer" ? 1 : 0;
}

if (isset($plan_id) && isset($_POST['submit'])) {

    //$planType = $_POST['isOffer'] == 1 || $_POST['isOffer'] == "1" ? "offer" : "captcha";
    $isEnabled = $_POST['isEnabled'];
    $paymentLink = $_POST['paymentLink'];

    //$sql = "update main_website_plans set engName = '$engName', hindiName = '$hindiName', marathiName = '$marathiName', hindiDesc = '$hindiDesc', engDesc = '$engDesc', marathiDesc = '$marathiDesc', isEnabled = $isEnabled where id = $plan_id";
    $sql = "update main_website_plans set isEnabled = $isEnabled, paymentLink = '$paymentLink' where id = $plan_id";
    if ($conn->query($sql)) {
        echo "<script>alert('Details updated successfully.');</script>";
        echo "<script>window.location = 'main-website-view-plans.php?password=1234';</script>";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Plan</title>
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

                    <a class="mx-4 mt-4" href="main-website-view-plans.php">Click here to view Plans</a>

                    <div class="card-body">

                        <h3 class="font-bold text-xl ">Edit Plan - <?= $planName; ?></h3>
                        <hr class="my-1" />


                        <form id="my-form" action="" method="post" class="mt-4">

                            <!-- <div class="form-group">
                                <label for="exampleFormControlFile1">Upload Image (English)</label>
                                <input type="file" class="form-control-file" name="eng-image" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Upload Image (Hindi)</label>
                                <input type="file" class="form-control-file" name="hindi-image" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Upload Image (Marathi)</label>
                                <input type="file" class="form-control-file" name="marathi-image" />
                            </div> -->

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Payment Link</label>
                                <input type="text" class="form-control" name="paymentLink"
                                    value="<?= $paymentLink; ?>" />
                            </div>

                            <!-- <div class="form-group">
                                <label for="exampleFormControlFile1">Plan Name English</label>
                                <input type="text" class="form-control" name="engName" value="<?= $engName; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Plan Name Hindi</label>
                                <input type="text" class="form-control" name="hindiName" value="<?= $hindiName; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Plan Name Marathi</label>
                                <input type="text" class="form-control" name="marathiName" value="<?= $marathiName; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">English Description</label>
                                <textarea rows="4" cols="50" class="form-control" name="engDesc" form="my-form" placeholder="Enter description here..."><?= $engDesc ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Hindi Description</label>
                                <textarea rows="4" cols="50" class="form-control" name="hindiDesc" form="my-form" placeholder="Enter description here..."><?= $hindiDesc ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Marathi Description</label>
                                <textarea rows="4" cols="50" class="form-control" name="marathiDesc" form="my-form" placeholder="Enter description here..."><?= $marathiDesc ?></textarea>
                            </div> -->

                            <!-- <div class="form-group">
                                <label for="exampleFormControlFile1">Plan type</label>
                                <select class="form-control" name="planType" required>
                                    <option value="captcha" selected>Captcha</option>
                                    <option value="form-filling">Form Filling</option>
                                    <option value="offer">Offer</option>

                                </select>
                            </div> -->

                            <div class="form-group">

                                <p>Show Plan:</p>
                                <input type="radio" id="isPlanEnabledOn" name="isEnabled" value="1"
                                    <?= $isEnabled == 1 ? 'checked' : ''; ?> />
                                <label for="isEnabledOn">ON</label><br>
                                <input type="radio" id="isEnabledOff" name="isEnabled" value="0"
                                    <?= $isEnabled == 0 ? 'checked' : ''; ?> />
                                <label for="isEnabledOff">OFF</label>

                            </div>

                            <!-- <div class="form-group">

                                <p>IS Offer:</p>
                                <input type="radio" id="isOfferOn" name="isOffer" value="1"
                                    <?= $isOffer == 1 ? 'checked' : ''; ?> />
                                <label for="isOfferOn">ON</label><br>
                                <input type="radio" id="isOfferOff" name="isOffer" value="0"
                                    <?= $isOffer == 0 ? 'checked' : ''; ?> />
                                <label for="isOfferOff">OFF</label>

                            </div> -->

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

    <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(500)
                    .height(300);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</body>

</html>