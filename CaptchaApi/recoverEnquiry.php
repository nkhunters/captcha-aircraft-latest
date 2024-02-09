<?php 
include "db.php";
 $id = $_GET['id'];
 $stmt = "update website_enquiries set isDeleted = 0 where id = '$id'";
 
 if ($conn->query($stmt)) {
     echo "<script>alert('Enquiry recovered successfully')</script>";
     echo "<script>window.location = 'deletedEnquiries.php?password=1234';</script>";
 }
?>