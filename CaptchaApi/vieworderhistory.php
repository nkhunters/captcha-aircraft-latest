<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Order History</title>

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

    <script>
        $(document).on("click", "#payment_modal", function() {
            var user_id = $(this).data('id');
            var row_id = $(this).data('rowid');
            var new_href = "payUser.php?user_id=" + user_id + "&id=" + row_id;
            $(".modal-footer #user_id").attr("href", new_href);

        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pay User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pay User ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Close</button>
                    <a id="user_id" href="deleteUser.php" type="button" class="btn text-white bg-darkslateblue">Yes
                        Pay!</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'nav.php'; ?>

    <br><br>

    <?php

    $user_id = $_GET['user_id'];

    $sql_total = "select total_earning from users where user_id = '$user_id'";
    $result = $conn->query($sql_total);
    $row = $result->fetch_assoc();
    $total = $row["total_earning"];

    $sql_unpaid = "select count(id) as total_unpaid from order_history where user_id = '$user_id' and status = 0";
    $result_unpaid = $conn->query($sql_unpaid);
    $row_unpaid = $result_unpaid->fetch_assoc();
    $total_unpaid = $row_unpaid["total_unpaid"];
    ?>

    <div class="mx-12">
        <h2 class="text-3xl mb-3 font-bold text-red-600">View Order History</h2>
        <div class="flex items-center" style="float:right;">
            <h5>
                Total Earning : <?= $total; ?> $</h5>
            <button type="button" class="ml-4 bg-darkBlue text-white font-semibold rounded-md shadow-md py-2 px-3" data-toggle="modal" data-target="#editTotalModal">Edit</button>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="editTotalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Total Earning</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <br />


                        <form id="total-form" method="POST" action="edit-history-entry.php">
                            <input type="hidden" name="userId" value="<?= $user_id; ?>" />
                            <div class="mb-6">
                                <label for="email" class="mb-2 text-sm font-medium text-gray-900">Total Earning</label>
                                <input type="number" name="total_earning" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $total; ?>" required="">
                            </div>

                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit-total" value="edit-total" form="total-form" class="btn bg-red-600 text-white">Yes Edit!</button>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search with Date.." title="Type in a name">
        <h5 class="text-red-600" style="float:right;">Total Unpaid : <?= $total_unpaid; ?> $</h5>
        <br>
        <table class="w-full table-auto bg-white border-collapse" id="myTable">
            <thead class="border-b">
                <tr class="hover:bg-gray-100 border-b border-dashed text-center">
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Sr No.</th>
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        User Id</th>
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Captcha Time</th>
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Order Date</th>
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Approved On</th>

                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Total Earning ($)</th>
                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Payment Status</th>

                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Edit</th>

                    <th class="text-center px-2 py-4 font-bold uppercase text-xs text-gray-700 sticky top-0 z-10 bg-gray-200 text-left">
                        Delete Entry</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $sql = "select order_history.id, order_history.user_id, users.captcha_time, users.extra_time, order_date, approval_date, order_history.total_earning, paid_amount, status FROM order_history, users where users.user_id = order_history.user_id and order_history.user_id = '$user_id' order by id desc";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {

                ?>

                        <tr class="hover:bg-gray-100 border-b border-dashed">
                            <td class="px-2 py-4 text-sm text-center"><?= $i; ?></td>
                            <td class="px-2 py-4 text-sm text-center uppercase"><?= $row["user_id"]; ?></td>
                            <td class="px-2 py-4 text-sm text-center"><?= $row["captcha_time"]; ?> sec /
                                <?= $row['extra_time']; ?> sec</td>
                            <td class="px-2 py-4 text-sm text-center">
                                <?= date_format(date_create($row["order_date"]), "d-M-Y h:i:sa"); ?></td>
                            <td class="px-2 py-4 text-sm text-center">
                                <?= date_format(date_create($row["approval_date"]), "d-M-Y h:i:sa"); ?></td>

                            <td class="px-2 py-4 text-sm text-center"><?= $row["total_earning"]; ?></td>
                            <?php
                            if ($row["status"] == 1) {
                            ?>
                                <td class="px-2 py-4 text-sm text-center"><button type="button" class="btn bg-green text-white">Paid</button></td>

                            <?php
                            } else {
                            ?>
                                <td class="px-2 py-4 text-sm text-center"><a id="payment_modal" data-id="<?= $row['user_id']; ?>" data-rowid="<?= $row['id']; ?>" data-toggle="modal" href="#paymentModal"> <button type="button" class="btn bg-red-600 text-white">Not
                                            Paid - Pay Now</button></a></td>
                            <?php
                            }
                            ?>

                            <td class="px-2 py-4 text-sm text-center">
                                <button type="button" class="bg-darkBlue text-white font-semibold rounded-md shadow-md py-2 px-3" data-toggle="modal" data-target="#editModal<?= $i; ?>">Edit</button>

                                <!-- Modal -->
                                <div class="modal fade" id="editModal<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Entry</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <br />


                                                <form id="edit-form<?= $i; ?>" method="POST" action="edit-history-entry.php">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>" />
                                                    <div class="mb-6">
                                                        <label for="email" class="mb-2 text-sm font-medium text-gray-900">Total
                                                            Earning</label>
                                                        <input type="number" name="total_earning" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $row["total_earning"]; ?>" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlFile1" class="mb-2 text-sm font-medium text-gray-900">Status</label>
                                                        <select class="form-control" name="status" required>
                                                            <option value="0" <?= $row["status"] == 0 ? "selected" : "" ?>>Not
                                                                Paid</option>
                                                            <option value="1" <?= $row["status"] == 1 ? "selected" : "" ?>>Paid
                                                            </option>

                                                        </select>
                                                    </div>
                                                </form>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3" data-dismiss="modal">Close</button>
                                                <button type="submit" name="edit-entry" value="edit-entry" form="edit-form<?= $i; ?>" class="btn bg-red-600 text-white">Yes
                                                    Edit!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>

                            <td class="px-2 py-4 text-sm text-center">
                                <button type="button" class="bg-red-600 text-white font-semibold rounded-md shadow-md py-2 px-3" data-toggle="modal" data-target="#exampleModal<?= $i; ?>">Delete</button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Entry</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Delete Entry ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class=" bg-blue-500 text-white rounded-md shadow-md py-2 px-3" data-dismiss="modal">Close</button>
                                                <a href="deleteOrderHistory.php?id=<?= $row["id"]; ?>" type="button" class="btn bg-red-600 text-white">Yes Delete!</a>
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
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[2];
                    if (td) {

                        //alert(td.getElementsByTagName("a")[0].innerHTML.toUpperCase().startsWith(filter));
                        var data = td.getElementsByTagName("a")[0].innerHTML.toUpperCase();
                        if (data.includes(filter)) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

    </div>

</body>

</html>