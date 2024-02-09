<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
session_start();
if (!isset($_SESSION['admin_username'])) {
  echo "<script>window.location = 'adminLogin.php';</script>";
}

include("phptextClass.php");
include("RealCaptcha.php");
include "db.php";
require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// AWS Info
$bucketName = 'captchas-new';
$IAM_KEY = 'AKIASKNODFAMRJ5O7B27';
$IAM_SECRET = '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';


if (isset($_POST['submit'])) {

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

  $color_hex = $_POST['color_hex'];
  $color_rgb_1 = $_POST['color_rgb_1'];
  $color_rgb_2 = $_POST['color_rgb_2'];
  $color_rgb_3 = $_POST['color_rgb_3'];

  $color_text_hex = $_POST['color_text_hex'];
  $color_text_rgb_1 = $_POST['color_text_rgb_1'];
  $color_text_rgb_2 = $_POST['color_text_rgb_2'];
  $color_text_rgb_3 = $_POST['color_text_rgb_3'];

  $terminal = $_POST['terminal'];
  //$captcha_text = $_POST['captcha_text'];
  $captcha_type = $_POST['captcha_type'];
  $type = $_POST['type'];
  $captcha_length = $_POST['captcha_length'];
  $_SESSION['captcha_length'] = $captcha_length;
  $_SESSION['captcha_type'] = $captcha_type;
  $_SESSION['terminal'] = $terminal;

  $_SESSION['color_hex'] = $color_hex;
  $_SESSION['color_rgb_1'] = $color_rgb_1;
  $_SESSION['color_rgb_2'] = $color_rgb_2;
  $_SESSION['color_rgb_3'] = $color_rgb_3;

  $_SESSION['color_text_hex'] = $color_text_hex;
  $_SESSION['color_text_rgb_1'] = $color_text_rgb_1;
  $_SESSION['color_text_rgb_2'] = $color_text_rgb_2;
  $_SESSION['color_text_rgb_3'] = $color_text_rgb_3;

  $colors = array("#DCDCDC", "#D3D3D3", "#C0C0C0", "#A9A9A9", '#fff', '#fb3958');

  $captcha_count = $_POST['captcha_count'];

  $type = $_POST['type'];
  $_SESSION['type'] = $type;

  //$text = substr($captcha_text ,0 ,$captcha_length);


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
      $keyName = 'captchas/' . $fileName;
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

    $sql = "insert into captchas (image, captcha_type, captcha_text, terminal) values ('$pathInS3', '$captcha_type', '$captchaText', '$terminal')";
    if ($conn->query($sql)) {
      //$colors = array("#DCDCDC","#D3D3D3","#C0C0C0","#A9A9A9",'#fff');
      //$random_keys = array_rand($colors);
    }
  }
  echo "<script>window.location = 'createCaptchaTerminal2.php';</script>";
}

?>


<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="jscolor.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontSize: {
                    9: "9px",
                    13: "13px",
                    15: "15px",
                },
                spacing: {
                    3.5: "0.875rem",
                    7.5: "1.875rem",
                    six: "6px",
                },
                colors: {
                    clifford: "#da373d",
                    blueviolet: "#9134f5",
                    darkslateblue: "#5B7742",
                    //darkslateblue: "#372495",
                    slateblue: "#7d55db",
                    mediumslateblue: "#8655e0",
                    mediumpurpule: "#a059f5",
                    primary: "#fd3a55",
                    primaryLight: "#6F97FF",
                    primaryNormal: "#4037B3",
                    coolGray: "#8493A8",
                    midGray: "#ADB9CA",
                    lightGray: "#CAD3DF",
                    deepBlue: "#18288D",
                    brightYellow: "#FFC13D",
                    lilac: "#95B4FF",
                    indigo: "#4169e1",
                    darkBlue: "#1167b1",
                    EB5757: "#EB5757",
                    DEE8FF: "#DEE8FF",
                    EFEEFB: "#EFEEFB",
                    D7D4F5: "#D7D4F5",
                    B9B6EC: "#B9B6EC",
                    white: "#ffffff",
                    C6D7FF: "#C6D7FF",
                    F5F8FF: "#F5F8FF",
                    BG1364A3: "#1364A3",
                    C4c4c4c: "#4c4c4c",
                    green: "#23A455",
                    lightPink: "#D02F68",
                    semiBlack: "#252424",
                    darkGray: "#4E4E4E",
                    bgWhite: "#f8f8ff",
                    bgBlue: "#0e0e52",
                    DFEFFF: "#DFEFFF",
                    E61A89: "#E61A89",
                    Gold: "#B4833E",
                    lightGold: "#EDD87D",
                    Platinum: "#C7C6C4",
                    lightPlatinum: "#F4F3F1",
                    Brown: "#925F36",
                },
                outline: {
                    gray: {
                        400: "#CBCBCB",
                    },
                },
                borderWidth: {
                    12: "12px",
                    1: "1px",
                    6: "6px",
                },
            },
        },
    };
    </script>

    <style>
    @font-face {
        font-family: monofont;
        src: url("fontsCaseSensitive/monofont.ttf");
    }

    @font-face {
        font-family: carbontype;
        src: url("fontsCaseSensitive/carbontype.ttf");
    }

    @font-face {
        font-family: swirled;
        src: url("fontsCaseSensitive/Swirled2.ttf");
    }

    @font-face {
        font-family: ratty;
        src: url("fontsCaseSensitive/RattyTatty.ttf");
    }

    @font-face {
        font-family: play;
        src: url("fontsCaseSensitive/Playdough.ttf");
    }

    @font-face {
        font-family: configur;
        src: url("fontsCaseSensitive/CONFIGUR.TTF");
    }

    @font-face {
        font-family: bonbon;
        src: url("fontsCaseSensitive/Bonbon.ttf");
    }

    @font-face {
        font-family: batmos;
        src: url("fontsCaseSensitive/BATMOS.TTF");
    }

    @font-face {
        font-family: arizonia;
        src: url("fontsCaseSensitive/Arizonia.ttf");
    }

    @font-face {
        font-family: allura;
        src: url("fontsCaseSensitive/Allura.ttf");
    }

    @font-face {
        font-family: ass;
        src: url("fontsCaseSensitive/ASS.TTF");
    }

    @font-face {
        font-family: font1942;
        src: url("fontsCaseSensitive/1942.ttf");
    }
    </style>

    <script>
    $(document).ready(function() {

        $("#captcha").focus();

    });
    </script>
</head>

<body style="background-color:#F0F0F0;">

    <?php include 'nav.php'; ?>

    <div class="flex flex-row p-8 gap-6">
        <div class="w-1/2 p-4 bg-white rounded-xl shadow-xl">

            <h3 class="font-bold text-xl ">CREATE CAPTCHA (TERMINAL)</h3>
            <hr class="my-1" />

            <form action="" method="post">
                <div class="grid grid-cols-2 gap-x-4 items-center">
                    <div class="form-group">
                        <label for="exampleFormControlFile1" class="-mb-1">Select Terminal</label>
                        <select class="form-control" name="terminal">
                            <option value="1" selected>1</option>

                            <?php
              $stmt = "select terminal from terminals";
              $result = $conn->query($stmt);
              while ($row = $result->fetch_assoc()) {
                if ($row['terminal'] == 1)
                  continue;
              ?>

                            <option value="<?= $row['terminal']; ?>"><?= $row['terminal']; ?></option>

                            <?php
              }
              ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1" class="-mb-1">Captcha Length</label>
                        <input type="number" class="form-control" name="captcha_length" value="<?php
                                                                                    if (isset($_SESSION['captcha_length']))
                                                                                      echo $_SESSION['captcha_length'];
                                                                                    else
                                                                                      echo 12;
                                                                                    ?>" />
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1" class="-mb-1">Enter Captcha Count</label>
                            <input type="number" class="form-control" name="captcha_count" value="500" />
                        </div>

                        <input type="hidden" id="hex-str" name="color_hex" value="<?php
                                                                      if (isset($_SESSION['color_hex']))
                                                                        echo $_SESSION['color_hex'];
                                                                      else echo "#FFFCFC";
                                                                      ?>" />

                        <input type="hidden" id="rgb-1" name="color_rgb_1" value="<?php
                                                                      if (isset($_SESSION['color_rgb_1']))
                                                                        echo $_SESSION['color_rgb_1'];
                                                                      else echo "255";
                                                                      ?>" />

                        <input type="hidden" id="rgb-2" name="color_rgb_2" value="<?php
                                                                      if (isset($_SESSION['color_rgb_2']))
                                                                        echo $_SESSION['color_rgb_2'];
                                                                      else echo "252"; ?>" />

                        <input type="hidden" id="rgb-3" name="color_rgb_3" value="<?php
                                                                      if (isset($_SESSION['color_rgb_3']))
                                                                        echo $_SESSION['color_rgb_3'];
                                                                      else echo "252"; ?>" />

                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1" class="-mb-1">Select Type</label>
                        <select class="form-control" name="type">
                            <option value="normal" selected>Normal</option>
                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "normal") {
              ?>
                            <option value="normal" selected>Normal</option>
                            <?php
              } else {
              ?>
                            <option value="normal">Normal</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "mix") {
              ?>
                            <option value="mix" selected>Mix</option>
                            <?php
              } else {
              ?>
                            <option value="mix">Mix</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font1") {
              ?>
                            <option value="font1" selected>Font 1</option>
                            <?php
              } else {
              ?>
                            <option value="font1">Font 1</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font2") {
              ?>
                            <option value="font2" selected>Font 2
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font2">Font 2</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font3") {
              ?>
                            <option value="font3" selected>Font 3
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font3">Font 3</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font4") {
              ?>
                            <option value="font4" selected>Font 4
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font4">Font 4</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font5") {
              ?>
                            <option value="font5" selected>Font 5
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font5">Font 5</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font6") {
              ?>
                            <option value="font6" selected>Font 6
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font6">Font 6</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font7") {
              ?>
                            <option value="font7" selected>Font 7
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font7">Font 7</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font8") {
              ?>
                            <option value="font8" selected>Font 8
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font8">Font 8</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font9") {
              ?>
                            <option value="font9" selected>Font 9
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font9">Font 9</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font10") {
              ?>
                            <option value="font10" selected>Font 10
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font10">Font 10</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font11") {
              ?>
                            <option value="font11" selected>Font 11
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font11">Font 11</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['type']) && $_SESSION['type'] == "font12") {
              ?>
                            <option value="font12" selected>Font 12
                            </option>
                            <?php
              } else {
              ?>
                            <option value="font12">Font 12</option>
                            <?php
              }
              ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1" class="-mb-1">Select Background Colour</label>
                        <input
                            class="jscolor {onFineChange:'update(this)'} w-full rounded-lg border border-gray-200 px-3 py-2 cursor-pointer"
                            value="<?php
                                                                                                                                          if (isset($_SESSION['color_hex']))
                                                                                                                                            echo $_SESSION['color_hex'];
                                                                                                                                          else echo "fffcfc"; ?>">
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
                                                                                else echo "#170414";
                                                                                ?>" />
                        <input type="hidden" id="text-rgb-1" name="color_text_rgb_1" value="<?php
                                                                                if (isset($_SESSION['color_text_rgb_1']))
                                                                                  echo $_SESSION['color_text_rgb_1'];
                                                                                else echo "23";
                                                                                ?>" />
                        <input type="hidden" id="text-rgb-2" name="color_text_rgb_2" value="<?php
                                                                                if (isset($_SESSION['color_text_rgb_2']))
                                                                                  echo $_SESSION['color_text_rgb_2'];
                                                                                else echo "4"; ?>" />
                        <input type="hidden" id="text-rgb-3" name="color_text_rgb_3" value="<?php
                                                                                if (isset($_SESSION['color_text_rgb_3']))
                                                                                  echo $_SESSION['color_text_rgb_3'];
                                                                                else echo "20"; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1" class="-mb-1">Select Text Colour</label>
                        <input
                            class="jscolor {onFineChange:'updateText(this)'} w-full rounded-lg border border-gray-200 px-3 py-2 cursor-pointer"
                            value="<?php
                                                                                                                                              if (isset($_SESSION['color_text_hex']))
                                                                                                                                                echo $_SESSION['color_text_hex'];
                                                                                                                                              else echo "170414"; ?>">

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
                        <label for="exampleFormControlFile1" class="-mb-1">Select Captcha Type</label>
                        <select class="form-control" name="captcha_type">
                            <option value="Special Alpha Numeric Case Sensitive" selected>Special characters
                                +
                                Number + Alpha + Case Sensitive
                            </option>
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
              if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Special Alpha Numeric Case Sensitive") {
              ?>
                            <option value="Special Alpha Numeric Case Sensitive" selected>Special characters
                                +
                                Number + Alpha + Case Sensitive
                            </option>
                            <?php
              } else {
              ?>
                            <option value="Special Alpha Numeric Case Sensitive">Special characters + Number
                                +
                                Alpha + Case Sensitive</option>
                            <?php
              }
              ?>

                            <?php
              if (isset($_SESSION['captcha_type']) && $_SESSION['captcha_type'] == "Calculative") {
              ?>
                            <option value="Calculative" selected>
                                Calculative
                            </option>
                            <?php
              } else {
              ?>
                            <option value="Calculative">Calculative</option>
                            <?php
              }
              ?>

                        </select>
                    </div>
                </div>

                <div class="form-group px-20">
                    <button type="submit"
                        class="form-control float-right bg-darkslateblue px-20 rounded-full shadow-xl mt-3 py-2 text-lg text-white mt-4"
                        value="submit" name="submit">Submit</button>
                </div>

            </form>
        </div>
        <div class="w-1/2 flex flex-col bg-white shadow-xl rounded-xl p-4 gap-3 text-xl">
            <h4>Font 1 - <span style="font-family: font1942;">This is test font one</span></h4>
            <h4>Font 2 - <span style="font-family: allura;">This is test font two</span></h4>
            <h4>Font 3 - <span style="font-family: arizonia;">This is test font three</span></h4>
            <h4>Font 4 - <span style="font-family: ass;">This is test font four</span></h4>
            <h4>Font 5 - <span style="font-family: batmos;">This is test font five</span></h4>
            <h4>Font 6 - <span style="font-family: bonbon;">This is test font six</span></h4>
            <h4>Font 7 - <span style="font-family: carbontype;">This is test font seven</span></h4>
            <h4>Font 8 - <span style="font-family: configur;">This is test font eight</span></h4>
            <h4>Font 9 - <span style="font-family: monofont;">This is test font nine</span></h4>
            <h4>Font 10 - <span style="font-family: play;">This is test font ten</span></h4>
            <h4>Font 11 - <span style="font-family: ratty;">This is test font eleven</span></h4>
            <h4>Font 12 - <span style="font-family: swirled;">This is test font twelve</span></h4>
        </div>
    </div>
</body>

</html>