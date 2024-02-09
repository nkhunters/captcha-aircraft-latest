<?php

       include "db.php";
        
        $plan_id = $_GET['plan_id'];
        $sql = "delete from main_website_plans where id = '$plan_id'";
        if($conn->query($sql))
        {
            echo "<script>window.location = 'main-website-view-plans.php';</script>";
        }

?>