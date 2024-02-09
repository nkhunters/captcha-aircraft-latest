 <?php
        
        $servername = "localhost";
        $username = "captcjcy_nkhun";
        $password = "qwertyniraj2109";
        $dbname = "captcjcy_captcha";

        $data = json_decode( file_get_contents( 'php://input' ), true );
        $temp = $data['object']['temp'];
        $bat = $data['object']['bat'];
        $e25 = $data['object']['e25'];
        $ec = $data['object']['ec'];
        $vwc = $data['object']['vwc'];
        
        $date_time = date('Y-m-d H:i:s');
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "insert into sensor_data (data_time, bat, e25, ec, temp, vwc) values ('$date_time', '$bat', '$e25', '$ec', '$temp', '$vwc')";
        if($conn->query($sql)){
                
                
            }
        ?>
        