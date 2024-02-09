<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With");

include("phptextClass.php");
include("RealCaptcha.php");
require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// AWS Info
$bucketName = 'captchas-new';
$IAM_KEY = 'AKIASKNODFAMRJ5O7B27';
$IAM_SECRET = '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';


if (isset($_POST['submit'])) {

    $color_rgb_1 = $_POST['color_rgb_1'];
    $color_rgb_2 = $_POST['color_rgb_2'];
    $color_rgb_3 = $_POST['color_rgb_3'];

    $color_text_rgb_1 = $_POST['color_text_rgb_1'];
    $color_text_rgb_2 = $_POST['color_text_rgb_2'];
    $color_text_rgb_3 = $_POST['color_text_rgb_3'];

    $terminal = $_POST['terminal'];
    $captcha_type = $_POST['captcha_type'];
    $type = $_POST['type'];
    $captcha_length = $_POST['captcha_length'];

    $colors = array("#DCDCDC", "#D3D3D3", "#C0C0C0", "#A9A9A9", '#fff', '#fb3958');

    $captcha_count = $_POST['captcha_count'];

    echo $captcha_count;

    $captchas = array();

    for ($i = 0; $i < $captcha_count; $i++) {

        $random_keys = array_rand($colors);

        $number = mt_rand(0, 100);

        $result = 0;

        if ($captcha_type == "Case Sensitive")
            $generated_text = getRandomStringCaseSensitive($captcha_length);

        if ($captcha_type == "Numbers")
            $generated_text = getRandomStringNumeric($captcha_length);

        if ($captcha_type == "Normal")
            $generated_text = getRandomStringNormal($captcha_length);

        if ($captcha_type == "Alphanumeric")
            $generated_text = getRandomStringAlphaNumeric($captcha_length);

        if ($captcha_type == "SpecialAlpha")
            $generated_text = getRandomStringSpecialAlpha($captcha_length);

        if ($captcha_type == "SpecialNumeric")
            $generated_text = getRandomStringSpecialNumeric($captcha_length);

        if ($captcha_type == "Special Alpha Numeric Case Sensitive")
            $generated_text = getRandomStringSpecialAlphaNumeric($captcha_length);

        if ($captcha_type == "Calculative") {
            $calCaptcha = getCalculativeCaptcha();
            $generated_text = $calCaptcha[0];
            $result = $calCaptcha[1];
        }

        $fileName = mt_rand() . ".png";

        if ($type == "normal") {
            $number = 13;
        }

        $fonts_dir = $captcha_type == "Calculative" ? "fontsNormal/" : "fontsCaseSensitive/";
        if ($type == "font1")
            $fonts_dir = "font1942/";

        if ($type == "font2")
            $fonts_dir = "fontAllura/";

        if ($type == "font3")
            $fonts_dir = "fontarizonia/";

        if ($type == "font4")
            $fonts_dir = "fontass/";

        if ($type == "font5")
            $fonts_dir = "fontbatmos/";

        if ($type == "font6")
            $fonts_dir = "fontbonbon/";

        if ($type == "font7")
            $fonts_dir = "fontcarbontype/";

        if ($type == "font8")
            $fonts_dir = "fontconfigur/";

        if ($type == "font9")
            $fonts_dir = "fontmonofont/";

        if ($type == "font10")
            $fonts_dir = "fontplaydough/";

        if ($type == "font11")
            $fonts_dir = "fontratty/";

        if ($type == "font12")
            $fonts_dir = "fontswirled/";
        // $fonts_dir;
        // if ($captcha_type == "Case Sensitive")
        //   $fonts_dir = "fontsCaseSensitive/";
        // else
        //   $fonts_dir = "fontsCaseSensitive/";

        // if ($type == "normal") {
        //   $fonts_dir = "fontsCaseSensitive/";
        // }

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
        $c1 = $captcha->generate($generated_text);
        //$c1->file("includes/uploads/".$fileName,"png",50); //Save Captcha to PNG File

        ob_start();
        imagejpeg($c1->image);
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
            $keyName = 'earneasy-captchas/' . $fileName;
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

        $captchaText = $captcha_type == "Calculative" ? $result : $c1->text;

        $createdCaptcha = array();
        $createdCaptcha['image'] = $pathInS3;
        $createdCaptcha['captcha_type'] = $captcha_type;
        $createdCaptcha['captcha_text'] = $captchaText;
        $createdCaptcha['terminal'] = $terminal;

        array_push($captchas, $createdCaptcha);
    }
    $jsonstring = json_encode($captchas);
    echo $jsonstring;
}


function getRandomStringAlphaNumeric($length)
{
    $characters = '123456789abcdefghijkmnpqrstuvwxyz';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringSpecialAlpha($length)
{
    $characters = 'abcdefghijkmnpqrstuvwxyz@#$%=*';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringSpecialNumeric($length)
{
    $characters = '123456789@#$%=*';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringSpecialAlphaNumeric($length)
{
    $characters = 'abcdefghijkmnpqrstuvwxyz123456789@#$%=*ABCDEFGHJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringNormal($length)
{
    $characters = 'abcdefghijkmnpqrstuvwxyz';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringCaseSensitive($length)
{
    $characters = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getRandomStringNumeric($length)
{
    $characters = '123456789';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getCalculativeCaptcha()
{
    $numbers = array();
    for ($i = 1; $i <= 20; $i++) {
        array_push($numbers, $i);
    }

    $operators = array('+', '-', '*');
    $firstIndex = rand(0, 19);
    $secondIndex = rand(0, 19);
    $opIndex = rand(0, 2);

    $result = 0;
    switch ($operators[$opIndex]) {
        case '+':
            $result = $numbers[$firstIndex] + $numbers[$secondIndex];
            break;
        case '-':
            $result = $numbers[$firstIndex] - $numbers[$secondIndex];
            break;
        case '*':
            $result = $numbers[$firstIndex] * $numbers[$secondIndex];
            break;
    }
    $expression = $numbers[$firstIndex] . " " . $operators[$opIndex] . " " .     $numbers[$secondIndex];

    return array($expression, $result);
}