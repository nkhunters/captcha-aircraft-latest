<?php

session_start();

include("./phptextClass.php");
include("./RealCaptcha.php");
include "db.php";
require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// AWS Info
$bucketName = 'captchabro';
$IAM_KEY = 'AKIAWZO6AXDVGKKKT26Q';
$IAM_SECRET = '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';


if (isset($_POST['submit'])) {

    $color_hex = $_POST['color_hex'];
    $color_rgb_1 = $_POST['color_rgb_1'];
    $color_rgb_2 = $_POST['color_rgb_2'];
    $color_rgb_3 = $_POST['color_rgb_3'];

    $color_text_hex = $_POST['color_text_hex'];
    $color_text_rgb_1 = $_POST['color_text_rgb_1'];
    $color_text_rgb_2 = $_POST['color_text_rgb_2'];
    $color_text_rgb_3 = $_POST['color_text_rgb_3'];


    $captcha_text = $_POST['captcha_text'];
    $level = $_POST['level'];
    $answer = $_POST['answer'];
    $captcha_type = $_POST['captcha_type'];

    $_SESSION['level'] = $level;
    $_SESSION['captcha_type'] = $captcha_type;

    $_SESSION['color_hex'] = $color_hex;
    $_SESSION['color_rgb_1'] = $color_rgb_1;
    $_SESSION['color_rgb_2'] = $color_rgb_2;
    $_SESSION['color_rgb_3'] = $color_rgb_3;

    $_SESSION['color_text_hex'] = $color_text_hex;
    $_SESSION['color_text_rgb_1'] = $color_text_rgb_1;
    $_SESSION['color_text_rgb_2'] = $color_text_rgb_2;
    $_SESSION['color_text_rgb_3'] = $color_text_rgb_3;

    $colors = array("#DCDCDC", "#D3D3D3", "#C0C0C0", "#A9A9A9", '#fff', '#fb3958');


    $fileName = mt_rand() . ".png";


    $fonts_dir = "fontsCaseSensitive/";

    $captcha = new RealCaptcha(array(
        "height" => 150,
        "width" => 350,
        "source" => realCaptcha::INPUT,
        "number_of_words" => 2,
        "fonts_dir" => "$fonts_dir",
        "background_color" => array($color_rgb_1, $color_rgb_2, $color_rgb_3),
        "text_color" => array($color_text_rgb_1, $color_text_rgb_2, $color_text_rgb_3)
    ));

    //Generating the Captcha...
    $c1 = $captcha->generate($captcha_text);

    ob_start();
    imagepng($c1->image);
    $imageData = ob_get_clean();
    ob_end_clean();

    // Connect to AWS
    try {
        // You may need to change the region. It will say in the URL when the bucket is open
        // and on creation.
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'ap-south-1'
            )
        );

        // For this, I would generate a unqiue random string for the key name. But you can do whatever.
        $keyName = 'newcaptchas/' . $fileName;
        $pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $bucketName . '/' . $keyName;


        $s3->putObject(
            array(
                'Bucket' => $bucketName,
                'Key' =>  $keyName,
                'Body' => $imageData,
                'StorageClass' => 'REDUCED_REDUNDANCY'
            )
        );
    } catch (Exception $e) {
        // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
        // return a json object.
        die("Error: " . $e->getMessage());
    }


    //The url you wish to send the POST request to
    $url = "https://earneasy24.xyz/api/createCaptcha";

    //The data you want to send via POST
    $fields = [
        'text' => $answer,
        'image' => $pathInS3,
        'level' => $level,
        'type' => $captcha_type
    ];

    //url-ify the data for the POST
    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);
    //echo $result;
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="jscolor.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

    <script>
        $(document).ready(function() {

            $("#captcha").focus();

        });
    </script>
</head>

<body>

    <br />

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="card" style="box-shadow: 0 0 4px 0 rgba(0,0,0,.08), 0 2px 4px 0 rgba(0,0,0,.12);  border-radius: 3px;">

                    <div class="card-body">

                        <h3>CREATE CAPTCHA</h3>
                        <hr />

                        <form action="" method="post">

                            <div class="form-group">
                                <label for="exampleFormControlFile1">CAPTCHA Text</label>
                                <input type="text" class="form-control" name="captcha_text" />
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlFile1">CAPTCHA Answer</label>
                                <input type="text" class="form-control" name="answer" />
                            </div>


                            <input type="hidden" id="hex-str" name="color_hex" value="<?php
                                                                                        if (isset($_SESSION['color_hex']))
                                                                                            echo $_SESSION['color_hex'];
                                                                                        else echo "";
                                                                                        ?>" />
                            <input type="hidden" id="rgb-1" name="color_rgb_1" value="<?php
                                                                                        if (isset($_SESSION['color_rgb_1']))
                                                                                            echo $_SESSION['color_rgb_1'];
                                                                                        else echo "";
                                                                                        ?>" />
                            <input type="hidden" id="rgb-2" name="color_rgb_2" value="<?php
                                                                                        if (isset($_SESSION['color_rgb_2']))
                                                                                            echo $_SESSION['color_rgb_2'];
                                                                                        else echo ""; ?>" />
                            <input type="hidden" id="rgb-3" name="color_rgb_3" value="<?php
                                                                                        if (isset($_SESSION['color_rgb_3']))
                                                                                            echo $_SESSION['color_rgb_3'];
                                                                                        else echo ""; ?>" />

                            <div class="form-group">
                                <label for="exampleFormControlFile1">SELECT BACKGROUND COLOUR</label>
                                <input class="jscolor {onFineChange:'update(this)'}" value="<?php
                                                                                            if (isset($_SESSION['color_hex']))
                                                                                                echo $_SESSION['color_hex'];
                                                                                            else echo "ffffff"; ?>">
                                <script>
                                    function update(picker) {
                                        document.getElementById('hex-str').value = picker.toHEXString();

                                        document.getElementById('rgb-1').value = Math.round(picker.rgb[0]);
                                        document.getElementById('rgb-2').value = Math.round(picker.rgb[1]);
                                        document.getElementById('rgb-3').value = Math.round(picker.rgb[2]);
                                    }
                                </script>

                                <input type="hidden" id="hex-text-str" name="color_text_hex" value="<?php
                                                                                                    if (isset($_SESSION['color_text_hex']))
                                                                                                        echo $_SESSION['color_text_hex'];
                                                                                                    else echo "";
                                                                                                    ?>" />
                                <input type="hidden" id="text-rgb-1" name="color_text_rgb_1" value="<?php
                                                                                                    if (isset($_SESSION['color_text_rgb_1']))
                                                                                                        echo $_SESSION['color_text_rgb_1'];
                                                                                                    else echo "";
                                                                                                    ?>" />
                                <input type="hidden" id="text-rgb-2" name="color_text_rgb_2" value="<?php
                                                                                                    if (isset($_SESSION['color_text_rgb_2']))
                                                                                                        echo $_SESSION['color_text_rgb_2'];
                                                                                                    else echo ""; ?>" />
                                <input type="hidden" id="text-rgb-3" name="color_text_rgb_3" value="<?php
                                                                                                    if (isset($_SESSION['color_text_rgb_3']))
                                                                                                        echo $_SESSION['color_text_rgb_3'];
                                                                                                    else echo ""; ?>" />

                                <div class="form-group">
                                    <label for="exampleFormControlFile1">SELECT TEXT COLOUR</label>
                                    <input class="jscolor {onFineChange:'updateText(this)'}" value="<?php
                                                                                                    if (isset($_SESSION['color_text_hex']))
                                                                                                        echo $_SESSION['color_text_hex'];
                                                                                                    else echo "#162453"; ?>">

                                    <script>
                                        function updateText(picker) {
                                            document.getElementById('hex-text-str').value = picker.toHEXString();
                                            document.getElementById('text-rgb-1').value = Math.round(picker.rgb[0]);
                                            document.getElementById('text-rgb-2').value = Math.round(picker.rgb[1]);
                                            document.getElementById('text-rgb-3').value = Math.round(picker.rgb[2]);
                                        }
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Select Level</label><br>
                                    <select class="form-control" name="level">
                                        <?php
                                        if (isset($_SESSION['level']) && $_SESSION['level'] == "1") {
                                        ?>
                                            <option value="1" selected>1</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="1">1</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['level']) && $_SESSION['level'] == "2") {
                                        ?>
                                            <option value="2" selected>2</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="2">2</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['level']) && $_SESSION['level'] == "3") {
                                        ?>
                                            <option value="3" selected>3</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="3">3</option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Select Captcha Type</label><br>
                                    <select class="form-control" name="captcha_type">

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Case Sensitive") {
                                        ?>
                                            <option value="Case Sensitive" selected>Case Sensitive</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Case Sensitive">Case Sensitive</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Numbers") {
                                        ?>
                                            <option value="Numbers" selected>Numbers</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Numbers">Numbers</option>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Normal") {
                                        ?>
                                            <option value="Normal" selected>Normal</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Normal">Normal</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Calculative") {
                                        ?>
                                            <option value="Calculative" selected>Calculative</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Calculative">Calculative</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Alphanumeric") {
                                        ?>
                                            <option value="Alphanumeric" selected>Alphanumeric</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="Alphanumeric">Alphanumeric</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "SpecialAlpha") {
                                        ?>
                                            <option value="SpecialAlpha" selected>Special characters + Alpha</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="SpecialAlpha">Special characters + Alpha</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "SpecialNumeric") {
                                        ?>
                                            <option value="SpecialNumeric" selected>Special characters + Number</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="SpecialNumeric">Special characters + Number</option>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "SpecialAlphaNumeric") {
                                        ?>
                                            <option value="SpecialAlphaNumeric" selected>Special characters + Number + Alpha</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="SpecialAlphaNumeric">Special characters + Number + Alpha</option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="form-control" value="submit" name="submit" style="background: linear-gradient(to bottom,#139ff0 0,#0087e0 100%);border: 1px solid #0087e0; color: #F7F7F7;font-weight: 700; text-shadow: 0 -1px transparent;">Submit</button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>