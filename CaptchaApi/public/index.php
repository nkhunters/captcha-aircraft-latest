<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/DbOperations.php';

$app = new \Slim\App;

/*
    endpoint: insertEnquiry
    parameters: instname,studname,mobile,batchname,batchtime,coursefee,paidamt,remainamt,remarks,modeofpayment,enqdate,joindate
    method: POST
*/


$app->post('/uploadCaptcha', function (Request $request, Response $response) {


    $request_data = $request->getParsedBody();

    $file = $_FILES['captcha_image']['tmp_name'];
    $captcha_type = $request_data['captcha_type'];
    $captcha_text = $request_data['captcha_text'];
    $db = new DbOperations;

    if ($db->saveFile($file, getFileExtension($_FILES['captcha_image']['name']), $captcha_type, $captcha_text)) {
        $response_data = array();
        $response_data["error"] = false;
        $response_data["message"] = "Captcha uploaded successfully";
        $response->write(json_encode($response_data));
        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(201);
    } else {
        $response_data = array();
        $response_data["error"] = true;
        $response_data["message"] = "Captcha not uploaded";
        $response->write(json_encode($response_data));
        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(422);
    }
});


$app->post('/createAdmin', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('username', 'password'), $response)) {

        $request_data = $request->getParsedBody();

        $username = $request_data['username'];
        $password = $request_data['password'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $db = new DbOperations;
        $result = $db->createAdmin($username, $hash_password);

        if ($result == ADMIN_CREATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Admin created successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == ADMIN_FAILURE) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Admin not created";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        } else if ($result == ADMIN_EXISTS) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Admin already exists";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});



$app->post('/register', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id', 'password', 'captcha_time'), $response)) {

        $request_data = $request->getParsedBody();

        $user_id = $request_data['user_id'];
        $password = $request_data['password'];
        $captcha_count = $request_data['captcha_count'];
        $captcha_rate = $request_data['captcha_rate'];
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $captcha_time = $request_data['captcha_time'];

        $db = new DbOperations;
        $result = $db->register($user_id, $hash_password, $captcha_time, $captcha_count, $captcha_rate);
        if ($result == USER_CREATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "User registered successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == USER_FAILURE) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "User not registered";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        } else if ($result == USER_EXISTS) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "User already exists";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});


$app->post('/setRates', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('captcha_count', 'captcha_rate'), $response)) {

        $request_data = $request->getParsedBody();

        $captcha_count = $request_data['captcha_count'];
        $captcha_rate = $request_data['captcha_rate'];

        $db = new DbOperations;
        $result = $db->setRates($captcha_count, $captcha_rate);
        if ($result == RATE_CREATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Rate created successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == RATE_FAILURE) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Rate not created";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});


$app->get('/saveWhatsappNumber', function (Request $request, Response $response) {

    $request_data = $request->getQueryParams();
    $mobile = $request_data['mobile'];

    $db = new DbOperations;
    $result = $db->saveWhatsappNumber($mobile);
    if ($result == "success") {
        $response_data = array();
        $response_data["error"] = false;
        $response_data["message"] = "Saved successfully";
        $response->write(json_encode($response_data));
        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(201);
    } else if ($result == "failed") {
        $response_data = array();
        $response_data["error"] = true;
        $response_data["message"] = "Not saved";
        $response->write(json_encode($response_data));
        return $response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(422);
    }
});

$app->post('/autoApproveOrder-v2', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id'), $response)) {

        $request_data = $request->getParsedBody();

        $user_id = $request_data['user_id'];

        $db = new DbOperations;
        $result = $db->autoApproveOrder($user_id);
        if ($result == USER_AUTO_APPROVED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Order auto approved successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == USER_NOT_AUTO_APPROVED) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Order not auto approved";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});

$app->post('/createNextOrder-v2', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id'), $response)) {

        $request_data = $request->getParsedBody();

        $user_id = $request_data['user_id'];
        date_default_timezone_set('Asia/Kolkata');
        $db = new DbOperations;
        $result = $db->createNextOrder($user_id);
        if ($result == ORDER_REQUEST_CREATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Next Order request created successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == ORDER_REQUEST_NOT_CREATED) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Next Order request not created";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});


$app->get('/deleteUser', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id'), $response)) {

        $request_data = $request->getParsedBody();

        $user_id = $request_data['user_id'];

        $db = new DbOperations;
        $result = $db->deleteUser($user_id);
        if ($result == USER_DELETED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "User deleted successfully";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
            header("Location: http://www.amazingkart.com/viewuser.php");
            die();
        } else if ($result == USER_NOT_DELETED) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "User not Deleted";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});


$app->get('/getMessages-v2', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $db = new DbOperations;
    $messages = $db->getMessages();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["messages"] = $messages;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/getDemoMessages', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $db = new DbOperations;
    $messages = $db->getDemoMessages();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["messages"] = $messages;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/getSupportDetails-v2', function (Request $request, Response $response) {

    $db = new DbOperations;
    $support = $db->getSupportDetails();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["support"] = $support;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/getLastMessage', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $db = new DbOperations;
    $message = $db->getLastMessage();
    /* $response_data = array();
    $response_data["error"] = false;
    $response_data["message"] = $message;*/
    $response->write(json_encode($message));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});


$app->post('/getOrderHistory-v2', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $db = new DbOperations;
    $orders = $db->getOrderHistory($user_id);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["orders"] = $orders;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});


$app->get('/getCaptchaDemo', function (Request $request, Response $response) {

    $db = new DbOperations;
    $captchas = $db->getCaptchaFirstDemo();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->post('/submitCaptchaDemo', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $captcha_id = $request_data['captcha_id'];
    $captcha_text = $request_data['captcha_text'];
    $captcha_type = $request_data['captcha_type'];

    $db = new DbOperations;
    $captchas = $db->submitCaptchaDemo($captcha_id, $captcha_text, $captcha_type);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->post('/skipCaptchaDemo', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $captcha_id = $request_data['captcha_id'];
    $captcha_type = $request_data['captcha_type'];

    $db = new DbOperations;
    $captchas = $db->skipCaptchaDemo($captcha_id, $captcha_type);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});


$app->get('/getRates', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $db = new DbOperations;
    $rates = $db->getRates();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["rates"] = $rates;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->get('/getDemoCompletedMessage', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $db = new DbOperations;
    $message = $db->getDemoCompletedMessage();
    $response_data = array();
    $response_data["error"] = false;
    $response_data["message"] = $message;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->post('/getUserCount', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $db = new DbOperations;
    $counts = $db->getUserCount($user_id);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["counts"] = $counts;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});


$app->post('/updateUserCount', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id', 'right_count', 'wrong_count'), $response)) {

        $request_data = $request->getParsedBody();

        $user_id = $request_data['user_id'];
        $right_count = $request_data['right_count'];
        $wrong_count = $request_data['wrong_count'];
        $skip_count = $request_data['skip_count'];

        $db = new DbOperations;
        $result = $db->updateUserCount($user_id, $right_count, $wrong_count, $skip_count);
        if ($result == COUNT_UPDATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Count Updated";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == COUNT_NOT_UPDATED) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Count not Updated";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});

$app->post('/updateReadCount', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('msg_id'), $response)) {

        $request_data = $request->getParsedBody();

        $msg_id = $request_data['msg_id'];

        $db = new DbOperations;
        $result = $db->updateReadCount($msg_id);
        if ($result == COUNT_UPDATED) {
            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = "Count Updated";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        } else if ($result == COUNT_NOT_UPDATED) {
            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Count not Updated";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        }
    }
});

$app->post('/login-v2', function (Request $request, Response $response) {

    if (!haveEmptyParameters(array('user_id', 'password', 'unique_id'), $response)) {

        $request_data = $request->getParsedBody();
        $user_id = $request_data['user_id'];
        $password = $request_data['password'];
        $unique_id = $request_data['unique_id'];

        $db = new DbOperations;
        $result = $db->login($user_id, $password, $unique_id);

        if ($result == AUTHENTICATION_FAILED) {

            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "Invalid username or password";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        } else if ($result == USER_NOT_FOUND) {

            $response_data = array();
            $response_data["error"] = true;
            $response_data["message"] = "User not found";
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(422);
        } else {

            $response_data = array();
            $response_data["error"] = false;
            $response_data["message"] = $result;
            $response->write(json_encode($response_data));
            return $response
                ->withHeader('Content-type', 'application/json')
                ->withStatus(201);
        }
    }
});



$app->post('/getCaptcha-v2', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $db = new DbOperations;
    $captchas = $db->getCaptchaFirst($user_id);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->post('/submitCaptcha-v2', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $captcha_id = $request_data['captcha_id'];
    $captcha_text = $request_data['captcha_text'];
    $captcha_type = $request_data['captcha_type'];

    $db = new DbOperations;
    $captchas = $db->submitCaptcha($user_id, $captcha_id, $captcha_text, $captcha_type);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});

$app->post('/skipCaptcha-v2', function (Request $request, Response $response) {

    $request_data = $request->getParsedBody();
    $user_id = $request_data['user_id'];
    $captcha_id = $request_data['captcha_id'];
    $captcha_type = $request_data['captcha_type'];

    $db = new DbOperations;
    $captchas = $db->skipCaptcha($user_id, $captcha_id, $captcha_type);
    $response_data = array();
    $response_data["error"] = false;
    $response_data["captcha"] = $captchas;
    $response->write(json_encode($response_data));

    return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
});



function getFileExtension($file)
{
    $path_parts = pathinfo($file);
    return $path_parts['extension'];
}

function haveEmptyParameters($required_params, $response)
{
    $error = false;
    $error_params = '';
    $request_params = $_REQUEST;

    foreach ($required_params as $param) {
        if (!isset($request_params[$param]) || strlen($request_params[$param]) <= 0) {
            $error = true;
            $error_params .= $param . ',';
        }
    }

    if ($error) {
        $error_detail = array();
        $error_detail['error'] = true;
        $error_detail['message'] = "Required parameters " . substr($error_params, 0, -1) . " are missing";
        $response->write(json_encode($error_detail));
    }

    return $error;
}

$app->run();
