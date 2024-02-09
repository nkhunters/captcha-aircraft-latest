<?php
session_start();

if (!isset($_SESSION['admin_username']))
    echo "<script>window.location = 'adminLogin.php';</script>";

include "db.php";

$sql = "select password from lock_passwords where id = 2";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];
$enteredPassword = $_GET['password'];

if (isset($_POST['submit'])) {

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $sql = "select password from lock_passwords where id = 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($old_password == $row['password']) {

        $sql2 = "update lock_passwords set password = '$new_password' where id = 1";
        if ($conn->query($sql2)) {
            echo "<script>alert('Password Changed.');</script>";
            echo "<script>window.location = 'adminLogin.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid password.');</script>";
        echo "<script>window.location = 'change-lock-password.php';</script>";
    }
}

$conn->close();
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Change Password - CaptchaBro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

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

<?php
if ($enteredPassword == $savedPassword) {
?>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->

    <!-- Modal Change password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you realy want to change the password?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <button type="submit" form="my-form" name="submit" value="submit"
                        class="btn text-white bg-darkslateblue">Yes
                        Change!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post" action="" id="my-form">
                    <div class="login-form-head">
                        <h4>Change Password</h4>
                        <p>Hello there, Change your Security Password</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Old Password</label>
                            <input type="password" id="exampleInputEmail1" name="old_password" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">New Password</label>
                            <input type="password" id="exampleInputPassword1" name="new_password" required>
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-group mx-auto flex items-center justify-center">

                            <a data-toggle="modal" href="#changePasswordModal"
                                class="btn btn-primary text-center bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2">UPDATE</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
<?php } ?>

</html>