<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}

date_default_timezone_set('Asia/Kolkata');

include "db.php";


$str_title = "";
$str_body = "";

if (isset($_GET['message_id'])) {
    $msg_id = $_GET['message_id'];
    $sql = "select title, body from messages where id = '$msg_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $str_title = $row['title'];
    $str_body = $row['body'];
}


if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $body = $_POST['message'];
    $date_time = date("d-M-Y h:i:sa");

    // API access key from Google API's Console
    define('API_ACCESS_KEY', 'AAAAs3-FzZ8:APA91bGRR6clT9NcQQ3JlsDAa__YqSXIMn9iFrYs1oASzzOsJVf1it2Y_bpl0D8QdL9oXP53BIr5NzWzJT-du6Lw9kpclokH2Ie9BNPeAbXNM8EJWJWgEZrm8xR52rThYaMRLZxBofwl');
    // prep the bundle
    $msg = array(
        'body'  => "$body",
        'title'     => "$title",
        'click_action' => "com.codelaxy.qwertynewserver_TARGET_NOTIFICATION",
        'vibrate'   => 1,
        'sound'     => 1,
    );

    $data = array(

        "str_title" => $title,
        "str_body" => $body
    );

    $fields = array(
        'to'  => '/topics/messages',
        'notification'          => $msg,
        'data' => $data
    );

    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);

    $sql = "insert into messages (title, body, date_time) values ('$title', '$body', '$date_time')";
    if ($conn->query($sql)) {
        echo "<script>alert('Message Sent');</script>";
    }
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

    <!-- Modal Edit User -->
    <div class="modal fade" id="sendMsgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you realy want to send this message?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <button type="submit" form="my-form" name="submit" value="submit"
                        class="btn text-white bg-darkslateblue">Yes
                        Send!</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'nav.php'; ?>

    <br>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="card"
                    style="box-shadow: 0 0 4px 0 rgba(0,0,0,.08), 0 2px 4px 0 rgba(0,0,0,.12);  border-radius: 3px;">


                    <br />
                    <div class="card-body">

                        <h3 class="font-bold text-xl ">SEND NOTIFICATIONS</h3>
                        <hr class="my-1" />


                        <form id="my-form" action="" method="post">

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Enter Title</label>
                                <input type="text" class="form-control" name="title" value="<?= $str_title; ?>" />
                            </div>

                            <br>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">Enter Message</label>
                                <textarea rows="4" cols="50" class="form-control" name="message" form="my-form"
                                    placeholder="Enter message here..."><?= $str_body; ?></textarea>
                            </div>
                            <br>

                            <div class="form-group">
                                <a data-toggle="modal" href="#sendMsgModal"
                                    class="form-control text-center float-right bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2 text-lg text-white mt-4">Submit</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>