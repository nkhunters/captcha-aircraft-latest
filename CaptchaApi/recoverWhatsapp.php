<?php 
include "db.php";
 $id = $_GET['id'];
 $stmt = "update demo_whatsapp_contacts set isDeleted = 0 where id = '$id'";
 
 if ($conn->query($stmt)) {
     echo "<script>alert('Number recovered successfully')</script>";
     echo "<script>window.location = 'deletedWhatsapp.php?password=1234';</script>";
 }
?>