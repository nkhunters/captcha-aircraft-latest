<?php

include "db.php"; 
$sql = "update users set unique_id = 'not_init'";
if($conn->query($sql))
{
    echo("<script>alert('Users Refreshed !!')</script>");
    echo "<script>window.location = 'viewusers.php?n=' + new Date().getTime();</script>";
}

$conn->close();
