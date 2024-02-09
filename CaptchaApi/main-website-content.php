<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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

$sql2 = "select * from main_website_content where id = 1";
$result2 = $conn->query($sql2);
$rowContent = $result2->fetch_assoc();

$whyUsContentEng = $rowContent["whyUsContentEng"];
$whyUsContentHindi = $rowContent["whyUsContentHindi"];
$whyUsContentMarathi = $rowContent["whyUsContentMarathi"];

$whyUsTagLineEng = $rowContent["whyUsTagLineEng"];
$whyUsTagLineHindi = $rowContent["whyUsTagLineHindi"];
$whyUsTagLineMarathi = $rowContent["whyUsTagLineMarathi"];

$aboutUsContentEng = $rowContent["aboutUsContentEng"];
$aboutUsContentHindi = $rowContent["aboutUsContentHindi"];
$aboutUsContentMarathi = $rowContent["aboutUsContentMarathi"];

$aboutUsTagLineEng = $rowContent["aboutUsTagLineEng"];
$aboutUsTagLineHindi = $rowContent["aboutUsTagLineHindi"];
$aboutUsTagLineMarathi = $rowContent["aboutUsTagLineMarathi"];

$formFillingEnabled = $rowContent['formFillingEnabled'];
$captchaFillingEnabled = $rowContent['captchaFillingEnabled'];
$defaultLanguage = $rowContent['defaultLanguage'];
$singleLanguage = $rowContent['singleLanguage'];
$showChat = $rowContent['showChat'];
$showAddress = $rowContent['showAddress'];
$showGst = $rowContent['showGst'];
$showWhatsapp = $rowContent['showWhatsapp'];
$showOffer = $rowContent['showOffer'];
$showContactUsOnSide = $rowContent['showContactUsOnSide'];
$showContactUsOnPageLoad = $rowContent['showContactUsOnPageLoad'];

if (isset($_POST['submit'])) {

    $whyUsContentEng = $_POST["whyUsContentEng"];
    $whyUsContentHindi = $_POST["whyUsContentHindi"];
    $whyUsContentMarathi = $_POST["whyUsContentMarathi"];

    $whyUsTagLineEng = $_POST["whyUsTagLineEng"];
    $whyUsTagLineHindi = $_POST["whyUsTagLineHindi"];
    $whyUsTagLineMarathi = $_POST["whyUsTagLineMarathi"];

    $aboutUsContentEng = $_POST["aboutUsContentEng"];
    $aboutUsContentHindi = $_POST["aboutUsContentHindi"];
    $aboutUsContentMarathi = $_POST["aboutUsContentMarathi"];

    $aboutUsTagLineEng = $_POST["aboutUsTagLineEng"];
    $aboutUsTagLineHindi = $_POST["aboutUsTagLineHindi"];
    $aboutUsTagLineMarathi = $_POST["aboutUsTagLineMarathi"];

    $formFillingEnabled = $_POST['formFillingEnabled'];
    $captchaFillingEnabled = $_POST['captchaFillingEnabled'];
    $defaultLanguage = $_POST['defaultLanguage'];
    $singleLanguage = $_POST['singleLanguage'];
    $showChat = $_POST['showChat'];
    $showAddress = $_POST['showAddress'];
    $showGst = $_POST['showGst'];
    $showWhatsapp = $_POST['showWhatsapp'];
    // $showOffer = $_POST['showOffer'];
    $showContactUsOnSide = $_POST['showContactUsOnSide'];
    $showContactUsOnPageLoad = $_POST['showContactUsOnPageLoad'];

    $sql = "update main_website_content set 
    whyUsContentEng = '$whyUsContentEng', 
    whyUsContentHindi = '$whyUsContentHindi', 
    whyUsContentMarathi = '$whyUsContentMarathi', 
    whyUsTagLineEng = '$whyUsTagLineEng', 
    whyUsTagLineHindi = '$whyUsTagLineHindi', 
    whyUsTagLineMarathi = '$whyUsTagLineMarathi',
    aboutUsContentEng = '$aboutUsContentEng', 
    aboutUsContentHindi = '$aboutUsContentHindi', 
    aboutUsContentMarathi = '$aboutUsContentMarathi', 
    aboutUsTagLineEng = '$aboutUsTagLineEng', 
    aboutUsTagLineHindi = '$aboutUsTagLineHindi', 
    aboutUsTagLineMarathi = '$aboutUsTagLineMarathi', 
    captchaFillingEnabled = $captchaFillingEnabled, 
    formFillingEnabled = $formFillingEnabled, 
    defaultLanguage = '$defaultLanguage', 
    singleLanguage = $singleLanguage, 
    showChat = $showChat, 
    showAddress = $showAddress, 
    showGst = $showGst, 
    showWhatsapp = $showWhatsapp,
    showContactUsOnSide = $showContactUsOnSide,
    showContactUsOnPageLoad = $showContactUsOnPageLoad
    where id = 1";


    if ($conn->query($sql)) {
        echo "<script>alert('Details updated successfully.');</script>";
        echo "<script>window.location = 'main-website-content.php';</script>";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main website content</title>
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
                    <a class="mx-4 mt-4" href="main-website-how-it-works.php?type=form">Click here to view How it Works
                        (Form Filling)</a>
                    <a class="mx-4 mt-2" href="main-website-how-it-works.php?type=captcha">Click here to view How it
                        Works (Captcha)</a>
                    <!-- <a class="mx-4 mt-2" href="main-website-services.php">Click here to view Services</a> -->
                    <div class="card-body">

                        <h3 class="font-bold text-xl ">Main website content</h3>
                        <hr class="my-1" />


                        <form id="my-form" action="" method="post" class="mt-4">

                            <!-- <div class="form-group">
                                <label for="exampleFormControlFile1">Services Form Filling English</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesFormEng" form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormEng ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Services Form Filling Hindi</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesFormHindi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormHindi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Services Form Filling Marathi</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesFormMarathi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormMarathi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Services Captcha English</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesCaptchaEng"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormEng ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Services Captcha Hindi</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesCaptchaHindi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormHindi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Services Captcha Marathi</label>
                                <textarea rows="4" cols="50" class="form-control" name="servicesCaptchaMarathi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $servicesFormMarathi ?></textarea>
                            </div> -->

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Content English</label>
                                <textarea rows="4" cols="50" class="form-control" name="whyUsContentEng" form="my-form"
                                    placeholder="Enter description here..."><?= $whyUsContentEng ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Content Hindi</label>
                                <textarea rows="4" cols="50" class="form-control" name="whyUsContentHindi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $whyUsContentHindi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Content Marathi</label>
                                <textarea rows="4" cols="50" class="form-control" name="whyUsContentMarathi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $whyUsContentMarathi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Tagline English</label>
                                <input type="text" class="form-control" name="whyUsTagLineEng"
                                    value="<?= $whyUsTagLineEng; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Tagline Hindi</label>
                                <input type="text" class="form-control" name="whyUsTagLineHindi"
                                    value="<?= $whyUsTagLineHindi; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Why Us Tagline Marathi</label>
                                <input type="text" class="form-control" name="whyUsTagLineMarathi"
                                    value="<?= $whyUsTagLineMarathi; ?>" />
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Content English</label>
                                <textarea rows="4" cols="50" class="form-control" name="aboutUsContentEng"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $aboutUsContentEng ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Content Hindi</label>
                                <textarea rows="4" cols="50" class="form-control" name="aboutUsContentHindi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $aboutUsContentHindi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Content Marathi</label>
                                <textarea rows="4" cols="50" class="form-control" name="aboutUsContentMarathi"
                                    form="my-form"
                                    placeholder="Enter description here..."><?= $aboutUsContentMarathi ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Tagline English</label>
                                <input type="text" class="form-control" name="aboutUsTagLineEng"
                                    value="<?= $aboutUsTagLineEng; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Tagline Hindi</label>
                                <input type="text" class="form-control" name="aboutUsTagLineHindi"
                                    value="<?= $aboutUsTagLineHindi; ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">About Us Tagline Marathi</label>
                                <input type="text" class="form-control" name="aboutUsTagLineMarathi"
                                    value="<?= $aboutUsTagLineMarathi; ?>" />
                            </div>

                            <div class="form-group">

                                <p>Show Form filling content:</p>
                                <input type="radio" id="formFillingEnabledOn" name="formFillingEnabled" value="1"
                                    <?= $formFillingEnabled == 1 ? 'checked' : ''; ?>>
                                <label for="formFillingEnabledOn">ON</label><br>
                                <input type="radio" id="formFillingEnabledOff" name="formFillingEnabled" value="0"
                                    <?= $formFillingEnabled == 0 ? 'checked' : ''; ?>>
                                <label for="formFillingEnabledOff">OFF</label>

                            </div>

                            <div class="form-group">

                                <p>Show Captcha content:</p>
                                <input type="radio" id="captchaFillingEnabledOn" name="captchaFillingEnabled" value="1"
                                    <?= $captchaFillingEnabled == 1 ? 'checked' : ''; ?>>
                                <label for="captchaFillingEnabledOn">ON</label><br>
                                <input type="radio" id="captchaFillingEnabledOff" name="captchaFillingEnabled" value="0"
                                    <?= $captchaFillingEnabled == 0 ? 'checked' : ''; ?>>
                                <label for="captchaFillingEnabledOff">OFF</label>

                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Default Language</label>
                                <select class="form-control" name="defaultLanguage" value="<?= $defaultLanguage ?>"
                                    required>
                                    <option value="en" <?= $defaultLanguage == 'en' ? 'selected' : ''; ?>>English
                                    </option>
                                    <option value="hi" <?= $defaultLanguage == 'hi' ? 'selected' : ''; ?>>Hindi</option>
                                    <option value="mr" <?= $defaultLanguage == 'mr' ? 'selected' : ''; ?>>Marathi
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">

                                <p>Single Language:</p>
                                <input type="radio" id="singleLanguageOn" name="singleLanguage" value="1"
                                    <?= $singleLanguage == 1 ? 'checked' : ''; ?>>
                                <label for="singleLanguageOn">Yes</label><br>
                                <input type="radio" id="singleLanguageOff" name="singleLanguage" value="0"
                                    <?= $singleLanguage == 0 ? 'checked' : ''; ?>>
                                <label for="singleLanguageOff">No</label>

                            </div>

                            <div class="form-group">

                                <p>Show Whatsapp Chatbot:</p>
                                <input type="radio" id="showChatOn" name="showChat" value="1"
                                    <?= $showChat == 1 ? 'checked' : ''; ?>>
                                <label for="showChatOn">Yes</label><br>
                                <input type="radio" id="showChatOff" name="showChat" value="0"
                                    <?= $showChat == 0 ? 'checked' : ''; ?>>
                                <label for="showChatOff">No</label>

                            </div>

                            <div class="form-group">

                                <p>Show Address:</p>
                                <input type="radio" id="showAddressOn" name="showAddress" value="1"
                                    <?= $showAddress == 1 ? 'checked' : ''; ?>>
                                <label for="showAddressOn">Yes</label><br>
                                <input type="radio" id="showAddressOff" name="showAddress" value="0"
                                    <?= $showAddress == 0 ? 'checked' : ''; ?>>
                                <label for="showAddressOff">No</label>

                            </div>

                            <div class="form-group">

                                <p>Show GST:</p>
                                <input type="radio" id="showGstOn" name="showGst" value="1"
                                    <?= $showGst == 1 ? 'checked' : ''; ?>>
                                <label for="showGstOn">Yes</label><br>
                                <input type="radio" id="showGstOff" name="showGst" value="0"
                                    <?= $showGst == 0 ? 'checked' : ''; ?>>
                                <label for="showGstOff">No</label>

                            </div>

                            <div class="form-group">

                                <p>Show Whatsapp:</p>
                                <input type="radio" id="showWhatsappOn" name="showWhatsapp" value="1"
                                    <?= $showWhatsapp == 1 ? 'checked' : ''; ?>>
                                <label for="showWhatsappOn">Yes</label><br>
                                <input type="radio" id="showWhatsappOff" name="showWhatsapp" value="0"
                                    <?= $showWhatsapp == 0 ? 'checked' : ''; ?>>
                                <label for="showWhatsappOff">No</label>

                            </div>


                            <div class="form-group">

                                <p>Show Contact Us On Side:</p>
                                <input type="radio" id="showContactUsOnSideOn" name="showContactUsOnSide" value="1"
                                    <?= $showContactUsOnSide == 1 ? 'checked' : ''; ?>>
                                <label for="showContactUsOnSideOn">Yes</label><br>
                                <input type="radio" id="showContactUsOnSideOff" name="showContactUsOnSide" value="0"
                                    <?= $showContactUsOnSide == 0 ? 'checked' : ''; ?>>
                                <label for="showContactUsOnSideOff">No</label>

                            </div>

                            <div class="form-group">

                                <p>Show Enquiry Form On Page Load:</p>
                                <input type="radio" id="showContactUsOnPageLoadOn" name="showContactUsOnPageLoad"
                                    value="1" <?= $showContactUsOnPageLoad == 1 ? 'checked' : ''; ?>>
                                <label for="showContactUsOnPageLoadOn">Yes</label><br>
                                <input type="radio" id="showContactUsOnPageLoadOff" name="showContactUsOnPageLoad"
                                    value="0" <?= $showContactUsOnPageLoad == 0 ? 'checked' : ''; ?>>
                                <label for="showContactUsOnPageLoadOff">No</label>

                            </div>

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