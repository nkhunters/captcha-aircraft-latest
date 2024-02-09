 <?php
        
        include "db.php";
        $id = $_GET['id'];
        $sql = "delete from captchas where id = '$id'";
        if($conn->query($sql)){
            
            echo "<script>window.location = 'viewcaptcha.php?n=' + new Date().getTime();</script>";
        }
        $conn->close();
        ?>
        