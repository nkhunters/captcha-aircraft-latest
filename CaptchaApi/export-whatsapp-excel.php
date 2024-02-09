<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminLogin.php';</script>";
}
include "db.php";

$sql = "select password from lock_passwords where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$savedPassword =  $row['password'];
$password = $_GET['password'];

if ($password == $savedPassword) {

    $savedPassword =  $row['password'];
    $password = $_GET['password'];

    $sqlTime = "SET time_zone = '+05:30'";
    $conn->query($sqlTime);


    $filename = "whatsapp-numbers";     //File Name


    $whereClause = "DATE(createdAt)=CURDATE() and isDeleted = 0";

    if (isset($_GET['start-date']) && isset($_GET['end-date'])) {

        $startDate = $_GET['start-date'];
        $endDate = $_GET['end-date'];
        $whereClause = "DATE(createdAt) >= '$startDate' and DATE(createdAt) <= '$endDate' and isDeleted = 0";
    }
    $sql = "SELECT * FROM demo_whatsapp_contacts WHERE " . $whereClause . " order by id desc";

    if (isset($_GET['sort']) && $_GET['sort'] == "app")
        $sql = "SELECT * FROM demo_whatsapp_contacts WHERE platform='app' and " . $whereClause . " order by id desc";

    if (isset($_GET['sort']) && $_GET['sort'] == "web")
        $sql = "SELECT * FROM demo_whatsapp_contacts WHERE platform='web' and " . $whereClause . " order by id desc";

    if (isset($_GET['sort']) && $_GET['sort'] == "form")
        $sql = "SELECT * FROM demo_whatsapp_contacts WHERE platform='form' and " . $whereClause . " order by id desc";

    if (isset($_GET['sort']) && $_GET['sort'] == "date")
        $sql = "SELECT * FROM demo_whatsapp_contacts WHERE " . $whereClause . " order by id desc";

    $result = $conn->query($sql);
    $file_ending = "xls";
    //header info for browser
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    /*******Start of Formatting for Excel*******/
    //define separator (defines columns in excel & tabs in word)
    $sep = ","; //tabbed character
    //start of printing column names as names of MySQL fields

    echo "Mobile" . $sep;
    echo "Date" . $sep;

    print("\n");
    //end of printing column names  
    //start while loop to get data
    while ($row = $result->fetch_assoc()) {
        $schema_insert = "";

        $mobile  = $row['mobile'];
        $createdOn = date_format(date_create($row["createdAt"]), "d-M-Y h:i:sa");


        $schema_insert .= "$mobile" . $sep;
        $schema_insert .= "$createdOn" . $sep;



        $schema_insert = str_replace($sep . "$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= $sep;
        print(trim($schema_insert));
        print "\n";
    }
} else {
    echo "<script>alert('Invalid password')</script>";
    echo "<script>window.location = 'demo-whatsapp-numbers.php';</script>";
}
$conn->close();