<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";
$type = $_GET['type'];

if (isset($_POST['submit'])) {
    $contentEng = $_POST['contentEng'];
    $contentHindi = $_POST['contentHindi'];
    $contentMarathi = $_POST['contentMarathi'];

    $sql = "insert into main_website_how_it_works (contentEng, contentHindi, contentMarathi, type) values ('$contentEng', '$contentHindi', '$contentMarathi', '$type')";
    if ($conn->query($sql)) {
        echo "<script>alert('Details updated successfully.');</script>";
        echo "<script>window.location = 'main-website-how-it-works.php?type=' + $type;</script>";
    }
}
?>
<html>

<head>
    <meta charset="utf-8" />
    <title>How it works</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <style>
    #myInput {
        background-image: url('/css/searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
    </style>

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

<body style="background-color:#F0F0F0;">

    <?php include 'nav.php'; ?>

    <br><br>

    <div class="container">
        <h2 class="text-3xl font-bold">Main website How it Works (<?= $type == 'form' ? "Form Filling" : "Captcha" ?>)
        </h2>

        <br />

        <div class="card"
            style="box-shadow: 0 0 4px 0 rgba(0,0,0,.08), 0 2px 4px 0 rgba(0,0,0,.12);  border-radius: 3px;">
            <div class="card-body">
                <form id="my-form" action="" method="post" class="mt-2">
                    <h2 class="text-xl mb-3 font-bold">Create Item</h2>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Content English</label>
                        <input type="text" class="form-control" name="contentEng" />
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Content Hindi</label>
                        <input type="text" class="form-control" name="contentHindi" />
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Content Marathi</label>
                        <input type="text" class="form-control" name="contentMarathi" />
                    </div>

                    <div class="form-group">
                        <button type="submit" value="submit" name="submit"
                            class="form-control float-right bg-darkslateblue rounded-full shadow-xl mt-3 py-2 text-lg text-white mt-4 w-24">Submit</button>
                    </div>

                </form>
            </div>
        </div>

        <table class="w-full table-auto bg-white border-collapse mt-4" id="myTable">
            <thead class="border-b">
                <tr class="hover:bg-gray-100 border-b border-dashed text-center">
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Sr No.</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Content (English)</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Content (Hindi)</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Content (Marathi)</th>
                    <th
                        class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $sql = "SELECT * FROM main_website_how_it_works where type = '$type'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {

                ?>

                <tr class="hover:bg-gray-100 border-b border-dashed">
                    <td class="px-2 py-4 text-sm text-center"><?= $i; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["contentEng"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["contentHindi"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center"><?= $row["contentMarathi"]; ?></td>
                    <td class="px-2 py-4 text-sm text-center">
                        <a data-toggle="modal" data-target="#deletePlanModal<?= $i; ?>"
                            class="text-white btn btn-primary a-btn-slide-text">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            <span><strong>Delete</strong></span>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="deletePlanModal<?= $i; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Plan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Do you really want to delete this item?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3"
                                            data-dismiss="modal">Close</button>
                                        <a href="deleteHowItWorks.php?id=<?= $row["id"]; ?>" type="button"
                                            class="btn bg-red-600 text-white">Yes Delete!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>


                <?php
                        $i++;
                    }
                }

                $conn->close();
                ?>

            </tbody>
        </table>

    </div>

</body>

</html>