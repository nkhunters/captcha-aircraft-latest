<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
include "db.php";
$plans = array();

$sql = "select * from main_website_plans where isEnabled = 1";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $plan = array();
    $plan['id'] = $row['id'];
    $plan['planName'] = $row['planName'];
    $plan['isEnabled'] = $row['isEnabled'];
    $plan['paymentLink'] = $row['paymentLink'];
   
    array_push($plans, $plan);
}

$jsonstring = json_encode($plans);
echo $jsonstring;

die();