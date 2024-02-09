<?php

include "db.php";


$sql = "update website_enquiries set isDeleted = 0 where isDeleted = 1";

if ($conn->query($sql)) {
    echo "<script>window.location = 'deletedEnquiries.php?n=' + new Date().getTime() + '&password=1234';</script>";
}


$conn->close();