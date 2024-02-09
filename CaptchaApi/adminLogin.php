<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {

    $uname = $_POST['username'];
    $pwd = $_POST['password'];

    $sql = "select username, password from admin where username = '$uname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($pwd, $row['password'])) {
            $_SESSION['admin_username'] = $row['username'];
            echo "<script>window.location = 'createuser.php';</script>";
        } else {
            echo "<script>alert('Invalid password.');</script>";
            echo "<script>window.location = 'adminLogin.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email.');</script>";
        echo "<script>window.location = 'adminLogin.php';</script>";
    }
}

$conn->close();
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - Aircraft Captcha Services</title>
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
                colors: {
                    clifford: "#da373d",
                    blueviolet: '#5B7742',
                    //blueviolet: "#9134f5",
                    darkslateblue: "#5B7742",
                    //darkslateblue: "#372495",
                    slateblue: "#7d55db",
                    // mediumslateblue: "#8655e0",
                    // mediumpurpule: "#a059f5",
                    mediumslateblue: "#5B7742",
                    mediumpurpule: "#5B7742",
                    lightPink: "#D02F68",
                },
            },
        },
    };
    </script>
</head>

<body class="bg-gradient-to-r from-blueviolet to-darkslateblue">


    <div class="flex h-screen">
        <div class="m-auto">
            <div class="shadow-2xl flex items-center bg-white p-20 space-x-12 rounded">

                <div class="hidden lg:block flex items-center justify-center">
                    <div class="flex items-center justify-center content-center">
                        <img class="my-auto" width="450" src="bg_old_2.svg" alt="My Happy SVG" />

                    </div>
                </div>

                <form class="bg-gradient-to-r from-blueviolet to-darkslateblue rounded-3xl" method="post" action="">
                    <div class="login-form-head bg-darkslateblue rounded-3xl">
                        <h4>Sign In</h4>
                        <p>Hello Aircraft Data Services, Sign in and start managing your Admin Panel</p>
                    </div>
                    <hr class="bg-white" />
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1" class="text-white">Username</label>
                            <input class="uppercase text-white bg-gradient-to-r from-blueviolet to-darkslateblue"
                                type="text" id="exampleInputEmail1" name="username" required />
                            <i class="ti-email text-white"></i>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1" class="text-white">Password</label>
                            <input class="text-white bg-gradient-to-r from-blueviolet to-darkslateblue" type="password"
                                id="exampleInputPassword1" name="password" required />
                            <i class="ti-lock text-white"></i>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit" name="submit" value="submit">Submit <i
                                    class="ti-arrow-right"></i></button>
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

</html>