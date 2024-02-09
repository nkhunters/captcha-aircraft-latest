<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";
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

    <br>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="card"
                    style="box-shadow: 0 0 4px 0 rgba(0,0,0,.08), 0 2px 4px 0 rgba(0,0,0,.12);  border-radius: 3px;">


                    <br />
                    <div class="card-body">

                        <h3>CREATE CAPTCHA</h3>
                        <a href="createCaptchaTerminal2.php">Click here to create Captchas in Terminal 2</a>
                        <hr /><br />

                        <br>

                        <form action="public/uploadCaptcha" method="post" enctype="multipart/form-data">



                            <div class="form-group">
                                <label for="exampleFormControlFile1">Upload Captcha Image</label>
                                <input type="file" class="form-control-file" name="captcha_image"
                                    onchange="readURL(this);" />
                            </div>

                            <br>
                            <img id="blah" src="#" alt="your image" />
                            <br><br>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Select Captcha Type</label><br>
                                <select class="form-control" name="captcha_type">

                                    <option value="Case Sensitive">Case Sensitive</option>
                                    <option value="Numbers">Numbers</option>
                                    <option value="Two Words">Two Words</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alphanumeric">Alphanumeric</option>

                                </select>
                            </div>

                            <br>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ENTER CAPTCHA TEXT"
                                    name="captcha_text" />
                            </div>
                            <br>

                            <div class="form-group">
                                <button type="submit" class="form-control" value="submit" name="submit"
                                    style="background: linear-gradient(to bottom,#139ff0 0,#0087e0 100%);border: 1px solid #0087e0; color: #F7F7F7;font-weight: 700; text-shadow: 0 -1px transparent;">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>

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
            </div>
        </div>
    </div>
</body>

</html>