<?php

       include "db.php";
        
        $msg_id = $_GET['message_id'];
        $sql = "delete from messages where id = '$msg_id'";
        if($conn->query($sql))
        {
            echo "<script>window.location = 'viewMessages.php?n=' + new Date().getTime();</script>";
        }

?>