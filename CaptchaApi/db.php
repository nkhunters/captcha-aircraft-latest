<?php
$servername = "aircraft.cqalnaq7jxxj.ap-south-1.rds.amazonaws.com";
$username = "root";
$password = "qwertyShubu2109";
$dbname = "aircraft";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
