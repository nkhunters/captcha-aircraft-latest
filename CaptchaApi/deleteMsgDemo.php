<?php

        include "db.php";
        
        $msg_id = $_GET['message_id'];
        $sql = "delete from demo_messages where id = '$msg_id'";
        if($conn->query($sql))
        {
            echo "<script>window.location = 'viewMessagesDemo.php?n=' + new Date().getTime();</script>";
        }

?>