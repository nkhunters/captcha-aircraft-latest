<?php

include "db.php";

$param = $_GET['param'];
$type = $_GET['type'];

if ($type == "hold" && $param == "before") {
    $stmt = "update users set on_hold = 1 where str_to_date(date_time, '%d-%M-%Y') < '2020-05-25'";
    if ($conn->query($stmt)) {
        $sql = "update newHold set on_hold = 1 where id = 1";
        $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
if ($type == "hold" && $param == "after") {
    $stmt = "update users set on_hold = 1 where str_to_date(date_time, '%d-%M-%Y') > '2020-05-24'";
    if ($conn->query($stmt)) {
        $sql = "update newHold set on_hold = 1 where id = 2";
        $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
if ($type == "unhold" && $param == "before") {
    $stmt = "update users set on_hold = 0 where str_to_date(date_time, '%d-%M-%Y') < '2020-05-25'";
    if ($conn->query($stmt)) {
        $sql = "update newHold set on_hold = 0 where id = 1";
        $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
if ($type == "unhold" && $param == "after") {
    $stmt = "update users set on_hold = 0 where str_to_date(date_time, '%d-%M-%Y') > '2020-05-24'";
    if ($conn->query($stmt)) {
        $sql = "update newHold set on_hold = 0 where id = 2";
        $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

$conn->close();
