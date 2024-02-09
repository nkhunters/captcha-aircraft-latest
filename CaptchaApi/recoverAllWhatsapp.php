<?php

include "db.php";


$sql = "update demo_whatsapp_contacts set isDeleted = 0 where isDeleted = 1";

if ($conn->query($sql)) {
    echo "<script>window.location = 'deletedWhatsapp.php?n=' + new Date().getTime() + '&password=1234';</script>";
}


$conn->close();