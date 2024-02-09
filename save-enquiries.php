<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

include "db.php";
$stmt = "SET time_zone = '+05:30'";
$conn->query($stmt);
$name = $_GET['name'];
$email = $_GET['email'];
$mobile = $_GET['mobile'];
$message = $_GET['message'];
$interestedIn = $_GET['interestedIn'];
$language = $_GET['language'];
$mainLanguage = 'English';
if($language == 'en')
$mainLanguage = 'English';
if($language == 'hi')
$mainLanguage = 'Hindi';
if($language == 'mr')
$mainLanguage = 'Marathi';



$sql = "insert into website_enquiries (name, email, mobile, interestedIn, message, language) values ('$name', '$email', '$mobile', '$interestedIn', '$message', '$mainLanguage')";

if (mysqli_query($conn, $sql)) {
    return true;
} else {
    return false;
}

$conn->close();