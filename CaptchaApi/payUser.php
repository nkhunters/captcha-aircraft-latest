<?php

        include "db.php";
        
        $user_id = $_GET['user_id'];
        $id = $_GET['id'];
        
        $sql = "update order_history set status = 1 where user_id = '$user_id' and id <= '$id' and status = 0";
        if($conn->query($sql))
        {
            echo "<script>alert('User Paid Successfully');</script>";
            echo "<script>window.location = 'vieworderhistory.php?user_id=$user_id&n=' + new Date().getTime();</script>";
        }
        
        $conn->close();
?>