<?php

       include "db.php";
        
        $id = $_GET['id'];
        $sql = "delete from main_website_how_it_works where id = '$id'";
        if($conn->query($sql))
        {
            echo "<script>window.location = 'main-website-how-it-works.php';</script>";
        }
