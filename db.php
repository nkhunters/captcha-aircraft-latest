<?php
$servername = "localhost";
$username = "root";
$password = "qwertyShubu2109@";
$dbname = "aircraft_new";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>