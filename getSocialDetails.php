<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
include "db.php";
$social = array();
$sql = "select * from main_website_social_details where id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$social['whatsapp'] = $row['whatsapp'];
$social['email'] = $row['email'];
$social['facebook'] = $row['facebook'];
$social['instagram'] = $row['instagram'];
$social['google'] = $row['google'];
$social['youtube'] = $row['youtube'];
$social['justdial'] = $row['justdial'];
$social['formDemoVideoEng'] = $row['formDemoVideoEng'];
$social['formTrainingVideoEng'] = $row['formTrainingVideoEng'];
$social['captchaDemoVideoEng'] = $row['captchaDemoVideoEng'];
$social['captchaTrainingVideoEng'] = $row['captchaTrainingVideoEng'];

$social['formDemoVideoHindi'] = $row['formDemoVideoHindi'];
$social['formTrainingVideoHindi'] = $row['formTrainingVideoHindi'];
$social['captchaDemoVideoHindi'] = $row['captchaDemoVideoHindi'];
$social['captchaTrainingVideoHindi'] = $row['captchaTrainingVideoHindi'];

$social['formDemoVideoMarathi'] = $row['formDemoVideoMarathi'];
$social['formTrainingVideoMarathi'] = $row['formTrainingVideoMarathi'];
$social['captchaDemoVideoMarathi'] = $row['captchaDemoVideoMarathi'];
$social['captchaTrainingVideoMarathi'] = $row['captchaTrainingVideoMarathi'];

$social['formDemoWork'] = $row['formDemoWork'];
$social['captchaDemoWork'] = $row['captchaDemoWork'];
$social['captchaDemoApp'] = $row['captchaDemoApp'];


$sqlContent = "select * from main_website_content where id = 1";
$resultContent = $conn->query($sqlContent);
$rowContent = $resultContent->fetch_assoc();

$social['servicesFormEng'] = $rowContent["servicesFormEng"];
$social['servicesFormHindi'] = $rowContent["servicesFormHindi"];
$social['servicesFormMarathi'] = $rowContent["servicesFormMarathi"];

$social['servicesCaptchaEng'] = $rowContent["servicesCaptchaEng"];
$social['servicesCaptchaHindi'] = $rowContent["servicesCaptchaHindi"];
$social['servicesCaptchaMarathi'] = $rowContent["servicesCaptchaMarathi"];

$social['whyUsContentEng'] = $rowContent["whyUsContentEng"];
$social['whyUsContentHindi'] = $rowContent["whyUsContentHindi"];
$social['whyUsContentMarathi'] = $rowContent["whyUsContentMarathi"];

$social['whyUsTagLineEng'] = $rowContent["whyUsTagLineEng"];
$social['whyUsTagLineHindi'] = $rowContent["whyUsTagLineHindi"];
$social['whyUsTagLineMarathi'] = $rowContent["whyUsTagLineMarathi"];

$social['aboutUsContentEng'] = $rowContent["aboutUsContentEng"];
$social['aboutUsContentHindi'] = $rowContent["aboutUsContentHindi"];
$social['aboutUsContentMarathi'] = $rowContent["aboutUsContentMarathi"];

$social['offerMainTextEng'] = $rowContent["offerMainTextEng"];
$social['offerMainTextHindi'] = $rowContent["offerMainTextHindi"];
$social['offerMainTextMarathi'] = $rowContent["offerMainTextMarathi"];

$social['offerSubTextEng'] = $rowContent["offerSubTextEng"];
$social['offerSubTextHindi'] = $rowContent["offerSubTextHindi"];
$social['offerSubTextMarathi'] = $rowContent["offerSubTextMarathi"];

$social['aboutUsTagLineEng'] = $rowContent["aboutUsTagLineEng"];
$social['aboutUsTagLineHindi'] = $rowContent["aboutUsTagLineHindi"];
$social['aboutUsTagLineMarathi'] = $rowContent["aboutUsTagLineMarathi"];
$social['formFillingEnabled'] = $rowContent['formFillingEnabled'];
$social['captchaFillingEnabled'] = $rowContent['captchaFillingEnabled'];
$social['defaultLanguage'] = $rowContent['defaultLanguage'];
$social['singleLanguage'] = $rowContent['singleLanguage'];
$social['showChat'] = $rowContent['showChat'];
$social['showAddress'] = $rowContent['showAddress'];
$social['showGst'] = $rowContent['showGst'];
$social['showWhatsapp'] = $rowContent['showWhatsapp'];
$social['showOffer'] = $rowContent['showOffer'];
$social['showContactUsOnSide'] = $rowContent['showContactUsOnSide'];
$social['showContactUsOnPageLoad'] = $rowContent['showContactUsOnPageLoad'];

$howItWorks = array();

$sqlHowItWorks = "select * from main_website_how_it_works";
$resultHowItWorks = $conn->query($sqlHowItWorks);
while ($rowHowItWorks = $resultHowItWorks->fetch_assoc()) {
    $item = array();
    $item['contentEng'] = $rowHowItWorks['contentEng'];
    $item['contentHindi'] = $rowHowItWorks['contentHindi'];
    $item['contentMarathi'] = $rowHowItWorks['contentMarathi'];
    $item['type'] = $rowHowItWorks['type'];

    array_push($howItWorks, $item);
}
$social['howItWorks'] = $howItWorks;

$jsonstring = json_encode($social);
echo $jsonstring;

die();