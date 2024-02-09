<?php

if(isset($_POST['submit'])){
    
    $captcha_type = $_POST['captcha_type'];
    $captcha_text = $_POST['captcha_text'];
    $captcha_time = $_POST['captcha_time'];
    
     $banner = $_FILES['captcha_image']['name']; 
     $expbanner=explode('.',$banner);
     $bannerexptype=$expbanner[1];
     date_default_timezone_set('Australia/Melbourne');
     $date = date('m/d/Yh:i:sa', time());
     $rand=rand(10000,99999);
     $encname=$date.$rand;
     $bannername=md5($encname).'.'.$bannerexptype;
     $bannerpath="captchaImages/".$bannername;
     move_uploaded_file($_FILES["captcha_image"]["tmp_name"],$bannerpath);
    
    $servername = "localhost";
    $username = "amazingk_niraj";
    $password = "qwertyniraj2109";
    $dbname = "amazingk_captcha";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

        
$sql = "INSERT INTO captcha (image, time, captcha_type, captcha_text)
VALUES ('$bannername', '$captcha_time', '$captcha_type', '$captcha_text')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
}
?>