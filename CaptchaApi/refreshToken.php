<?php
        
        include "db.php";
        
        $user_id = $_GET['user_id'];
        
        $sql = "update users set unique_id = 'not_init' where user_id = '$user_id'";
        if($conn->query($sql)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        $conn->close();
?>