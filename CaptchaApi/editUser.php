<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}

include "db.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "select captcha_time, extra_time, extra_time_web, captcha_count, captcha_rate, terminal, platform from users where user_id = '$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $captcha_time = $row['captcha_time'];
    $extra_time = $row['extra_time'];

    $captcha_count = $row['captcha_count'];
    $captcha_rate = $row['captcha_rate'];
    $terminal = $row['terminal'];
    $platform = $row['platform'];
}

if (isset($_POST['submit'])) {
    $old_user_id = $_GET['user_id'];
    $user_id = $_POST['user_id'];
    $captcha_count = $_POST['captcha_count'];
    $captcha_rate = $_POST['captcha_rate'];
    $captcha_time = $_POST['captcha_time'];
    $extra_time = $_POST['extra_time'];

    $terminal_array = $_POST['terminal'];
    $terminal = implode(',', $terminal_array);
    $platform = $_POST['platform'];

    $sql = "select id from users where user_id = '$old_user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['id'];

    $sql1 = "update users set user_id = '$user_id', captcha_time = '$captcha_time', extra_time = '$extra_time', captcha_count = '$captcha_count', captcha_rate = '$captcha_rate', terminal = '$terminal', platform = '$platform' where id='$id'";

    if ($conn->query($sql1)) {

        echo "<script>alert('User updated successfully.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Edit User</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
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
    * {
        box-sizing: border-box;
    }

    body {
        font: 16px Arial;
    }

    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>

    <script>
    function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8);
    };
    </script>
</head>

<body style="background-color:#F0F0F0;">

    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you realy want to update details of this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <button type="submit" form="my-form" name="submit" value="submit"
                        class="btn text-white bg-darkslateblue">Yes
                        Update!</a>
                </div>
            </div>
        </div>
    </div>


    <?php include 'nav.php'; ?>

    <br>

    <div class="flex flex-row w-full px-20 gap-20 h-full items-center justify-center">

        <img src="assets/images/create_user.svg" class="w-2/5" alt="">

        <div class="w-3/5 rounded-xl shadow-xl bg-white p-4">

            <h5 class="font-bold text-xl">EDIT USER</h5>
            <hr class="my-1" />


            <form id="my-form" action="" method="post" class="py-2 grid grid-cols-2 gap-x-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="User ID" name="user_id"
                        value="<?= $user_id; ?>">
                </div>


                <div class="form-group">

                    <input type="number" class="form-control" placeholder="Enter Captcha Time"
                        value="<?= $captcha_time; ?>" name="captcha_time">
                    <div class="float-right mr-1 text-sm">Seconds</div>
                </div>



                <div class="form-group">

                    <input type="number" class="form-control" placeholder="No. of captchas"
                        value="<?= $captcha_count; ?>" name="captcha_count">
                    <div class="float-right mr-1 text-sm">Words</div>
                </div>

                <div class="form-group">

                    <input type="number" class="form-control" placeholder="No. of captchas" value="<?= $captcha_rate ?>"
                        name="captcha_rate">
                    <div class="float-right mr-1 text-sm">$</div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Select Terminal</label>
                    <select class="form-control" name="terminal[]">
                        <?php
                        if ($terminal == '0') {

                        ?>
                        <option value='0' selected>Mix</option>
                        <?php
                        } else { ?>
                        <option value="<?= $terminal; ?>" selected><?= $terminal; ?></option>
                        <?php }
                        if ($terminal != '1') {
                        ?>
                        <option value="1">1</option>

                        <?php
                        }
                        $stmt = "select terminal from terminals";
                        $result = $conn->query($stmt);
                        while ($row = $result->fetch_assoc()) {
                            if ($row['terminal'] != $terminal) {
                            ?>

                        <option value="<?= $row['terminal']; ?>"><?= $row['terminal']; ?></option>

                        <?php
                            }
                        }
                        if ($terminal != 0) {
                            ?>

                        <option value="0">Mix</option>
                        <?php
                        }
                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Select Platform</label>
                    <select class="form-control" name="platform">
                        <?php
                        if ($platform == "app") {
                        ?>
                        <option value="app" selected>App</option>
                        <?php
                        } else { ?>

                        <option value="app">App</option>
                        <?php
                        } ?>

                        <?php
                        if ($platform == "web") {
                        ?>
                        <option value="web" selected>Web</option>
                        <?php
                        } else { ?>

                        <option value="web">Web</option>
                        <?php
                        } ?>

                        <?php
                        if ($platform == "both") {
                        ?>
                        <option value="both" selected>Both</option>
                        <?php
                        } else { ?>

                        <option value="both">Both</option>
                        <?php
                        } ?>
                    </select>
                </div>

                <div class="form-group">

                    <input type="number" class="form-control" placeholder="Enter Extra Time" value="<?= $extra_time; ?>"
                        name="extra_time">
                    <div class="float-right mr-1 text-sm">Seconds</div>
                </div>



                <div class="form-group">

                    <a data-toggle="modal" href="#editUserModal"
                        class="btn btn-primary float-right bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2">UPDATE</a>

                </div>

            </form>

        </div>
    </div>



</body>

</html>