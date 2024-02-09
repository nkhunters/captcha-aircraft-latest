<?php

include "db.php";

$terminal_id = $_GET['id'];
$terminal = $_GET['terminal'];

$sql_delete = "delete from captchas where terminal = '$terminal'";
if ($conn->query($sql_delete)) {
    $sql = "delete from terminals where id = '$terminal_id'";
    if ($conn->query($sql)) {

        echo "<script>window.location = 'viewTerminal.php?n=' + new Date().getTime();</script>";
    }
}

$conn->close();

?>
