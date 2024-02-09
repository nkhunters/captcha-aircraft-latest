<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}

date_default_timezone_set('Asia/Kolkata');

include "db.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Create User</title>

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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Exists</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    This user id already exists.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-darkslateblue text-white" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['user_id'])) {

        $user_id = strtoupper($_POST['user_id']);
        $password = $_POST['password'];
        $captcha_count = $_POST['captcha_count'];
        $captcha_rate = $_POST['captcha_rate'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $captcha_time = $_POST['captcha_time'];
        $extra_time = $_POST['extra_time'];

        $terminal_array = $_POST['terminal'];
        $terminal = implode(',', $terminal_array);
        $platform = $_POST['platform'];
        $date_time = date("d-M-Y h:i:sa");
        $auto_approve = $_POST['auto_approve'];

        $checkUser = "select id from users where user_id = '$user_id'";
        $result = $conn->query($checkUser);

        $checkDeletedUser = "select id from deleted_users where user_id = '$user_id'";
        $resultDeletedUser = $conn->query($checkDeletedUser);

        if ($result->num_rows > 0) {
            echo "<script>$('#myModal').modal('show');</script>";
            //echo "<script>window.location = 'http://captchabro.website/CaptchaApi/createuser.php?n=' + new Date().getTime();</script>";
        } else if ($resultDeletedUser->num_rows > 0) {
            echo "<script>$('#myModal').modal('show');</script>";
            //echo "<script>window.location = 'http://captchabro.website/CaptchaApi/createuser.php?n=' + new Date().getTime();</script>";
        } else {

            $sql = "insert into users (user_id, password, captcha_time, extra_time, captcha_count, captcha_rate, unique_id, terminal, date_time, platform, auto_approve) values ('$user_id','$hash_password','$captcha_time', '$extra_time', '$captcha_count','$captcha_rate','not_init','$terminal','$date_time','$platform','$auto_approve')";

            if (mysqli_query($conn, $sql)) {

                echo "<script>alert('User created Successfully');</script>";
                echo "<script>window.location = 'createuser.php?n=' + new Date().getTime();</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        $conn->close();
    }
    ?>

    <?php include 'nav.php'; ?>

    <br>

    <div class="flex flex-row w-full px-20 gap-20 h-full items-center justify-center">



        <img src="assets/images/create_user.svg" class="w-2/5" alt="">

        <div class="w-3/5 rounded-xl shadow-xl bg-white p-4">

            <h5 class="font-bold text-xl ">CREATE USER</h5>
            <hr class="my-1" />

            <form action="" method="post" class="py-2 grid grid-cols-2 gap-x-4">
                <div class="form-group">
                    <input type="text" class="form-control uppercase" placeholder="User ID" name="user_id" required />
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" value="1234"
                        autocomplete="new-password" required>
                </div>

                <div class="form-group">
                    <input type="number" class="form-control" placeholder="Enter Captcha Time" name="captcha_time"
                        value=60 required>
                    <div class="float-right mr-1 text-sm">Seconds</div>
                </div>


                <div class="form-group">

                    <select class="form-control" name="extra_time" required>
                        <option disabled selected value> -- select an option -- </option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                    <div class="float-right mr-1 text-sm">Seconds</div>
                </div>


                <div class="form-group">
                    <input type="number" class="form-control" placeholder="Rate ($)" name="captcha_rate" value=1
                        required>
                    <div class="float-right mr-1 text-sm">$</div>
                </div>


                <div class="form-group">

                    <select class="form-control" name="captcha_count" required>
                        <option disabled selected value> -- select an option -- </option>
                        <option value="500">500</option>
                        <option value="999">999</option>
                        <option value="1499">1499</option>
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2499">2499</option>
                        <option value="2500">2500</option>
                        <option value="2999">2999</option>
                        <option value="3000">3000</option>
                    </select>
                    <div class="float-right mr-1 text-sm">Words</div>
                </div>



                <div class="form-group">
                    <label for="exampleFormControlFile1">Select Terminal</label>
                    <select class="form-control" name="terminal[]" required>
                        <option disabled selected value> -- select an option -- </option>
                        <?php

                        $stmt = "select terminal from terminals";
                        $result = $conn->query($stmt);
                        while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?= $row['terminal']; ?>"><?= $row['terminal']; ?></option>

                        <?php
                        }
                        ?>
                        <option value="0">Mix</option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Select Platform</label>
                    <select class="form-control" name="platform" required>

                        <option value="app">App</option>
                        <option value="web">Web</option>
                        <option value="both">Both</option>

                    </select>
                </div>



                <div class="form-group">
                    <label for="exampleFormControlFile1">Auto Approve</label>
                    <div class="flex flex-row w-full justify-center">
                        <div class="w-4/12 flex flex-row items-center gap-2">
                            <input type="radio" name="auto_approve" value="1" checked class="h-5 w-5 cursor-pointer">
                            <div> On </div>
                        </div>
                        <div class="w-4/12 flex flex-row items-center gap-2">
                            <input type="radio" name="auto_approve" value="0" class="h-5 w-5 cursor-pointer">
                            <div> Off </div>
                        </div>
                        <div class="w-4/12"></div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary float-right bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2">
                        CREATE
                    </button>
                </div>

            </form>

        </div>

    </div>


    <script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    /*An array containing all the country names in the world:*/
    var countries = ["2000", "2500", "3000"];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("captcha_count"), countries);
    </script>

</body>

</html>