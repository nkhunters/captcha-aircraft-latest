 <?php
        
        include "db.php";
        
        $sql = "select user_id from order_requests";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                
            $user_id = $row['user_id'];
            
            $sql3 = "select right_count, wrong_count, captcha_rate from users where user_id = '$user_id'";
            $result2  = $conn->query($sql3);
             if ($result2->num_rows > 0) {
                 
             while($row2 = $result2->fetch_assoc()) {
            
            if($row2['right_count'] == 0 && $row2['wrong_count'] == 0)
                continue;
            else
            {
            $captcha_rate = $row2['captcha_rate'];
            
            $sql2 = "update users set right_count = 0, wrong_count = 0, total_earning = total_earning + '$captcha_rate' where user_id = '$user_id'";
            
            if($conn->query($sql2)){
                
                $sql5 = "select total_earning from users where user_id = '$user_id'";
                $result2 = $conn->query($sql5);
                if($result2->num_rows > 0){
                    
                    while($row2 = $result2->fetch_assoc()){
                        
                        $total_earning = $row2['total_earning'];
                        $sql6 = "select max(id) as max_id from order_history where user_id = '$user_id'";
                        $result3 = $conn->query($sql6);
                        if($result3->num_rows > 0){
                            
                            while($row3 = $result3->fetch_assoc()){
                                
                            $max_id = $row3['max_id'];
                        $time_sql="SET time_zone = '+05:30'";
                        $conn->query($time_sql);
                        $sql4 = "update order_history set approval_date = now(), total_earning = '$total_earning', total_earning = '$captcha_rate' where id = '$max_id'";
                        if($conn->query($sql4)){
                        }}
                        
            }
            
        }}}}}
            
             }}}
        
        $sql3 = "truncate table order_requests";
        if($conn->query($sql3)){
            
            echo "<script>window.location = 'approverequests.php?n=' + new Date().getTime();</script>";
        }
        
        $conn->close();
        
        ?>
        