<?php

class DbOperations
{

    private $con;

    public function __construct()
    {
        require_once dirname(__FILE__) . "/DbConnect.php";
        $db = new DbConnect;
        $this->con = $db->connect();
    }

    public function saveFile($file, $extension, $captcha_type, $captcha_text)
    {
        $name = round(microtime(true) * 1000) . '.' . $extension;
        $filedest = dirname(__FILE__) . UPLOAD_PATH . $name;
        move_uploaded_file($file, $filedest);

        $stmt = $this->con->prepare("INSERT INTO captchas (image, captcha_type, captcha_text) VALUES (?,?,?)");
        $stmt->bind_param("sss", $name, $captcha_type, $captcha_text);
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function createAdmin($username, $password)
    {
        if (!$this->isAdminExist($username)) {
            $stmt = $this->con->prepare("insert into admin (username, password) values (?,?)");
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                return ADMIN_CREATED;
            } else {
                return ADMIN_FAILURE;
            }
        } else {
            return ADMIN_EXISTS;
        }
    }

    public function register($user_id, $password, $captcha_time, $captcha_count, $captcha_rate)
    {

        if (!$this->isUserExist($user_id)) {
            $stmt = $this->con->prepare("insert into users (user_id, password, captcha_time, captcha_count, captcha_rate, unique_id) values (?,?,?,?,?,'not_init')");
            $stmt->bind_param("sssss", $user_id, $password, $captcha_time, $captcha_count, $captcha_rate);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_FAILURE;
            }
        } else {
            return USER_EXISTS;
        }
    }

    public function setRates($captcha_count, $captcha_rate)
    {

        $stmt = $this->con->prepare("update rates set captcha_count = ?, captcha_rate = ?");
        $stmt->bind_param("ss", $captcha_count, $captcha_rate);
        if ($stmt->execute()) {
            return RATE_CREATED;
        } else {
            return RATE_FAILURE;
        }
    }

    public function createProfile($user_id)
    {
        $stmt = $this->con->prepare("insert into profile (user_id) values (?)");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            return PROFILE_CREATED;
        } else {
            return PROFILE_FAILURE;
        }
    }

    public function updateUserCount($user_id, $right_count, $wrong_count, $skip_count)
    {
        $stmt = $this->con->prepare("update users set right_count = ?, wrong_count = ?, skip_count = ? where user_id = ?");
        $stmt->bind_param("ssss", $right_count, $wrong_count, $skip_count, $user_id);
        if ($stmt->execute()) {
            return COUNT_UPDATED;
        } else {
            return COUNT_NOT_UPDATED;
        }
    }

    public function updateReadCount($msg_id)
    {
        $stmt = $this->con->prepare("update demo_messages set read_count = read_count + 1 where id = ?");
        $stmt->bind_param("s", $msg_id);
        if ($stmt->execute()) {
            return COUNT_UPDATED;
        } else {
            return COUNT_NOT_UPDATED;
        }
    }

    public function updateUniqueId($user_id, $unique_id)
    {
        $stmt = $this->con->prepare("update users set unique_id = ? where user_id = ?");
        $stmt->bind_param("ss", $unique_id, $user_id);
        if ($stmt->execute()) {
            return UNIQUE_ID_UPDATED;
        } else {
            return UNIQUE_ID_NOT_UPDATED;
        }
    }

    public function getOrderHistory($user_id)
    {

        $stmt = $this->con->prepare("select id, order_date, approval_date, total_earning, paid_amount, status from order_history where user_id = ? order by id desc");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($id, $order_date, $approval_date, $total_earning, $paid_amount, $status);
        $orders = array();
        while ($stmt->fetch()) {
            $order = array();
            $order['id'] = $id;
            $order['order_date'] = $order_date;
            $order['approval_date'] = $approval_date;
            $order['total_earning'] = $total_earning;
            $order['paid_amount'] = $paid_amount;
            $order['status'] = $status;
            array_push($orders, $order);
        }
        return $orders;
    }

    public function getMessages()
    {

        $stmt = $this->con->prepare("select id, title, body, date_time from messages order by id desc limit 10");
        $stmt->execute();
        $stmt->bind_result($id, $title, $body, $date_time);
        $messages = array();
        while ($stmt->fetch()) {
            $message = array();
            $message['id'] = $id;
            $message['title'] = $title;
            $message['body'] = $body;
            $message['date_time'] = $date_time;
            array_push($messages, $message);
        }
        return $messages;
    }

    public function getDemoMessages()
    {

        $stmt = $this->con->prepare("select id, title, image, body, date_time from demo_messages order by id desc limit 10");
        $stmt->execute();
        $stmt->bind_result($id, $title, $image, $body, $date_time);
        $messages = array();
        while ($stmt->fetch()) {
            $message = array();
            $message['id'] = $id;
            $message['title'] = $title;
            $message['body'] = $body;
            $message['image'] = $image;
            $message['date_time'] = $date_time;
            array_push($messages, $message);
        }
        return $messages;
    }

    public function getLastMessage()
    {

        $stmt = $this->con->prepare("select id, title, image, body, date_time from demo_messages order by id desc limit 1");
        $stmt->execute();
        $stmt->bind_result($id, $title, $image, $body, $date_time);
        $message = array();
        while ($stmt->fetch()) {
            $message['id'] = $id;
            $message['title'] = $title;
            $message['body'] = $body;
            $message['image'] = $image;
            $message['date_time'] = $date_time;
        }
        return $message;
    }

    public function getUserCount($user_id)
    {

        $stmt = $this->con->prepare("select right_count, wrong_count, skip_count, captcha_count, captcha_rate, unique_id, auto_approve, total_earning from users where user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($right_count, $wrong_count, $skip_count, $captcha_count, $captcha_rate, $unique_id, $auto_approve, $total_earning);
        $counts = array();
        while ($stmt->fetch()) {

            $counts['right_count'] = $right_count;
            $counts['wrong_count'] = $wrong_count;
            $counts['skip_count'] = $skip_count;
            $counts['captcha_count'] = $captcha_count;
            $counts['captcha_rate'] = $captcha_rate;
            $counts['unique_id'] = $unique_id;
            $counts['auto_approve'] = $auto_approve;
            $counts['total_earning'] = $total_earning;
        }
        return $counts;
    }

    public function getRates()
    {

        $stmt = $this->con->prepare("select captcha_count, captcha_rate from rates");
        $stmt->execute();
        $stmt->bind_result($captcha_count, $captcha_rate);
        $rates = array();
        while ($stmt->fetch()) {

            $rates['captcha_count'] = $captcha_count;
            $rates['captcha_rate'] = $captcha_rate;
        }
        return $rates;
    }

    public function getDemoCompletedMessage()
    {

        $stmt = $this->con->prepare("select message from demo_complete_message");
        $stmt->execute();
        $stmt->bind_result($message);

        while ($stmt->fetch()) {
        }
        return $message;
    }


    public function getCaptchaFirst($user_id)
    {

        $sql2 = $this->con->prepare("select terminal, right_count, wrong_count, skip_count, extra_time, unique_id, platform, on_hold from users where user_id = ?");
        $sql2->bind_param("s", $user_id);
        $sql2->execute();
        $result3 = $sql2->get_result();
        $row3 = $result3->fetch_assoc();

        $terminal = $row3['terminal'];

        $stmt = $this->con->prepare("select id, image, captcha_type from captchas where terminal in (?) order by RAND() limit 1");
        $stmt->bind_param("s", $terminal);

        $stmt->execute();
        $result2 = $stmt->get_result();
        $row2 = $result2->fetch_assoc();

        $captcha = array();

        $captcha['logout'] = "0";
        if ($row3['platform'] == "web" || $row3['on_hold'] == 1) {
            $captcha['logout'] = "1";
        }

        $captcha['id'] = $row2["id"];
        $captcha['image'] = $row2["image"];
        $captcha['captcha_type'] = $row2["captcha_type"];
        $captcha['right_count'] = $row3["right_count"];
        $captcha['wrong_count'] = $row3["wrong_count"];
        $captcha['skip_count'] = $row3["skip_count"];
        $captcha['extra_time'] = $row3["extra_time"];
        $captcha['unique_id'] = $row3["unique_id"];
        $captcha['terminal'] = $row3["terminal"];

        return $captcha;
    }

    public function getCaptchaFirstDemo()
    {

        $stmt = $this->con->prepare("select id, image, captcha_type, captcha_text from captchas where terminal = 999 order by RAND() limit 1");

        $stmt->execute();
        $result2 = $stmt->get_result();
        $row2 = $result2->fetch_assoc();

        $captcha = array();

        $captcha['id'] = $row2["id"];
        $captcha['image'] = $row2["image"];
        $captcha['captcha_type'] = $row2["captcha_type"];
        $captcha['length'] = strlen($row2["captcha_text"]);

        return $captcha;
    }



    public function getCaptcha($user_id, $is_right = 0, $captcha_type = "Normal", $captcha_id = 1)
    {

        $sql = $this->con->prepare("select terminal, total_earning, right_count, wrong_count, skip_count, extra_time, unique_id, platform, on_hold from users where user_id = ?");
        $sql->bind_param("s", $user_id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $terminal = $row['terminal'];
        $total_earning = $row['total_earning'];
        $temp_right_count = $row['right_count'];

        $captcha = array();

        $captcha['logout'] = "0";
        if ($row['platform'] == "web" || $row['on_hold'] == 1) {
            $captcha['logout'] = "1";
        }

        if ($captcha_type == "Calculative" && $is_right == 0) {
            $stmt = $this->con->prepare("select id, image, captcha_type from captchas where id = ?");
            $stmt->bind_param("s", $captcha_id);

            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();

            $captcha['id'] = $row2["id"];
            $captcha['image'] = $row2["image"];
            $captcha['captcha_type'] = $row2["captcha_type"];
            $captcha['right_count'] = $row["right_count"];
            $captcha['wrong_count'] = $row["wrong_count"];
            $captcha['skip_count'] = $row["skip_count"];
            $captcha['extra_time'] = $row["extra_time"];
            $captcha['unique_id'] = $row["unique_id"];
            $captcha['is_right'] = $is_right;

            return $captcha;
        } else {
            $stmt = $this->con->prepare("select id, image, captcha_type from captchas where terminal in (?) order by RAND() limit 1");
            $stmt->bind_param("s", $terminal);

            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();

            $captcha['id'] = $row2["id"];
            $captcha['image'] = $row2["image"];
            $captcha['captcha_type'] = $row2["captcha_type"];
            $captcha['right_count'] = $row["right_count"];
            $captcha['wrong_count'] = $row["wrong_count"];
            $captcha['skip_count'] = $row["skip_count"];
            $captcha['extra_time'] = $row["extra_time"];
            $captcha['unique_id'] = $row["unique_id"];
            $captcha['is_right'] = $is_right;

            return $captcha;
        }
    }



    public function getCaptchaDemo($is_right = 0, $captcha_type = "Normal", $captcha_id = 1)
    {

        $terminal = "999";


        if ($captcha_type == "Calculative" && $is_right == 0) {
            $stmt = $this->con->prepare("select id, image, captcha_text, captcha_type from captchas where id = ?");
            $stmt->bind_param("s", $captcha_id);

            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();


            $captcha = array();

            $captcha['id'] = $row2["id"];
            $captcha['image'] = $row2["image"];
            $captcha['captcha_type'] = $row2["captcha_type"];
            $captcha['is_right'] = $is_right;
            $captcha['length'] = strlen($row2["captcha_text"]);

            return $captcha;
        } else {
            $stmt = $this->con->prepare("select id, image, captcha_text, captcha_type from captchas where terminal in (?) order by RAND() limit 1");
            $stmt->bind_param("s", $terminal);

            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();


            $captcha = array();

            $captcha['id'] = $row2["id"];
            $captcha['image'] = $row2["image"];
            $captcha['captcha_type'] = $row2["captcha_type"];
            $captcha['is_right'] = $is_right;
            $captcha['length'] = strlen($row2["captcha_text"]);

            return $captcha;
        }
    }



    public function skipCaptcha($user_id, $captcha_id, $captcha_type)
    {

        $stmt = $this->con->prepare("update users set skip_count = skip_count+1 where user_id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
        }

        return $this->getCaptcha($user_id, 0, $captcha_type, $captcha_id);
    }

    public function skipCaptchaDemo($captcha_id, $captcha_type)
    {
        return $this->getCaptchaDemo(0, $captcha_type, $captcha_id);
    }


    public function submitCaptcha($user_id, $captcha_id, $captcha_text, $captcha_type)
    {
        $is_right = 0;

        if ($captcha_id == null || $captcha_text == null) {
            $stmt = $this->con->prepare("update users set wrong_count = wrong_count+1 where user_id = ?");
            $stmt->bind_param("s", $user_id);
            if ($stmt->execute()) {
            }
            return $this->getCaptcha($user_id, $is_right, $captcha_type, $captcha_id);
        }

        $sql = $this->con->prepare("select captcha_text from captchas where id = ?");
        $sql->bind_param("s", $captcha_id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        $captcha_text_orig = $row['captcha_text'];

        if ($captcha_type == "Case Sensitive" || $captcha_type == "Special Alpha Numeric Case Sensitive") {

            if ($captcha_text_orig == $captcha_text) {

                $stmt = $this->con->prepare("update users set right_count = right_count+1 where user_id = ?");
                $stmt->bind_param("s", $user_id);
                if ($stmt->execute()) {

                    $is_right = 1;
                }
            } else {
                $stmt = $this->con->prepare("update users set wrong_count = wrong_count+1 where user_id = ?");
                $stmt->bind_param("s", $user_id);
                if ($stmt->execute()) {
                }
            }
        } else {

            if (!strcasecmp($captcha_text_orig, $captcha_text)) {

                $stmt = $this->con->prepare("update users set right_count = right_count+1 where user_id = ?");
                $stmt->bind_param("s", $user_id);
                if ($stmt->execute()) {

                    $is_right = 1;
                }
            } else {
                $stmt = $this->con->prepare("update users set wrong_count = wrong_count+1 where user_id = ?");
                $stmt->bind_param("s", $user_id);
                if ($stmt->execute()) {
                }
            }
        }

        return $this->getCaptcha($user_id, $is_right, $captcha_type, $captcha_id);
    }


    public function submitCaptchaDemo($captcha_id, $captcha_text, $captcha_type)
    {
        $is_right = 0;

        if ($captcha_id == null || $captcha_text == null) {
            return $this->getCaptchaDemo($is_right, $captcha_type, $captcha_id);
        }

        $sql = $this->con->prepare("select captcha_text from captchas where id = ?");
        $sql->bind_param("s", $captcha_id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        $captcha_text_orig = $row['captcha_text'];

        if ($captcha_type == "Case Sensitive" || $captcha_type == "Special Alpha Numeric Case Sensitive") {

            if ($captcha_text_orig == $captcha_text) {
                $is_right = 1;
            }
        } else {

            if (!strcasecmp($captcha_text_orig, $captcha_text)) {
                $is_right = 1;
            }
        }

        return $this->getCaptchaDemo($is_right, $captcha_type, $captcha_id);
    }



    public function createNextOrder($user_id)
    {
        if (!$this->isAlreadyRequested($user_id)) {
            $sql = "SET time_zone = '+05:30'";
            $this->con->query($sql);

            $stmt2 = $this->con->prepare("select right_count, captcha_count from users where user_id = ?");
            $stmt2->bind_param("s", $user_id);
            $stmt2->execute();
            $result = $stmt2->get_result();
            $row = $result->fetch_assoc();

            if ($row['right_count'] >= $row['captcha_count']) {

                $stmt = $this->con->prepare("insert into order_requests(user_id, order_date) values (?,now())");
                $stmt->bind_param("s", $user_id);
                if ($stmt->execute()) {
                    return ORDER_REQUEST_CREATED;
                } else {
                    return ORDER_REQUEST_NOT_CREATED;
                }
            }
        }
    }

    public function autoApproveOrder($user_id)
    {
        $sql = "SET time_zone = '+05:30'";
        $this->con->query($sql);
        $stmt = $this->con->prepare("select captcha_rate from users where user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $captcha_rate = $row['captcha_rate'];

        $sql2 = $this->con->prepare("update users set right_count = 0, wrong_count = 0, skip_count = 0, total_earning = total_earning + ? where user_id = ?");

        $sql2->bind_param("ss", $captcha_rate, $user_id);
        if ($sql2->execute()) {

            $sql5 = $this->con->prepare("select total_earning from users where user_id = ?");
            $sql5->bind_param("s", $user_id);
            $sql5->execute();
            $result2 = $sql5->get_result();
            $row2 = $result2->fetch_assoc();
            $total_earning = $row2['total_earning'];

            $sql4 = $this->con->prepare("insert into order_history (user_id, order_date, approval_date, total_earning, paid_amount, auto_approve) values(?, now(), now(), ?,?,1)");
            $sql4->bind_param("sss", $user_id, $total_earning, $captcha_rate);
            if ($sql4->execute()) {

                return USER_AUTO_APPROVED;
            }
        } else {
            return USER_NOT_AUTO_APPROVED;
        }
    }

    public function deleteUser($user_id)
    {
        $stmt = $this->con->prepare("delete from users where user_id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            return USER_DELETED;
        } else {
            return USER_NOT_DELETED;
        }
    }

    public function login($user_id, $password, $unique_id)
    {

        if (!$this->isAppLocked()) {
            if ($this->isUserExist($user_id)) {

                $stmt = $this->con->prepare("select user_id, total_earning, captcha_count, captcha_rate, auto_approve, captcha_time, extra_time, unique_id, password from users where user_id = ? and platform IN ('app', 'both') and on_hold = 0");
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if (password_verify($password, $row["password"])) {

                   if ($user_id == "nkhunters500") {
                        $user = array();
                        $user['user_id'] = $row["user_id"];
                        $user['total_earning'] = $row["total_earning"];
                        $user['captcha_time'] = $row["captcha_time"];
                        $user['extra_time'] = $row["extra_time"];
                        $user['captcha_count'] = $row["captcha_count"];
                        $user['captcha_rate'] = $row["captcha_rate"];
                        $user['auto_approve'] = $row["auto_approve"];
                        $user['message'] = "Device Id Matched";
                        return $user;
                    }
                    
                   else if ($row["unique_id"] == $unique_id) {
                        $user = array();
                        $user['user_id'] = $row["user_id"];
                        $user['total_earning'] = $row["total_earning"];
                        $user['captcha_time'] = $row["captcha_time"];
                        $user['extra_time'] = $row["extra_time"];
                        $user['captcha_count'] = $row["captcha_count"];
                        $user['captcha_rate'] = $row["captcha_rate"];
                        $user['auto_approve'] = $row["auto_approve"];
                        $user['message'] = "Device Id Matched";
                        return $user;
                    } else if ($row["unique_id"] == "not_init") {

                        $sql = $this->con->prepare("update users set unique_id = ? where user_id = ?");
                        $sql->bind_param("ss", $unique_id, $user_id);
                        if ($sql->execute()) {

                            $user = array();
                            $user['user_id'] = $row["user_id"];
                            $user['total_earning'] = $row["total_earning"];
                            $user['captcha_time'] = $row["captcha_time"];
                            $user['extra_time'] = $row["extra_time"];
                            $user['captcha_count'] = $row["captcha_count"];
                            $user['captcha_rate'] = $row["captcha_rate"];
                            $user['auto_approve'] = $row["auto_approve"];
                            $user['message'] = "Device Id Created";
                            return $user;
                        }
                    } else {

                        $user = array();
                        $user['user_id'] = $row["user_id"];
                        $user['total_earning'] = $row["total_earning"];
                        $user['captcha_time'] = $row["captcha_time"];
                        $user['extra_time'] = $row["extra_time"];
                        $user['captcha_count'] = $row["captcha_count"];
                        $user['captcha_rate'] = $row["captcha_rate"];
                        $user['auto_approve'] = $row["auto_approve"];
                        $user['message'] = "Device Not Matched";
                        return $user;
                    }
                } else {
                    return AUTHENTICATION_FAILED;
                }
            } else {
                return USER_NOT_FOUND;
            }
        } else {
            return USER_NOT_FOUND;
        }
    }

    public function getSupportDetails()
    {

        $stmt = $this->con->prepare("select * from support_details where id = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $support = array();
        $support['mobile'] = $row["mobile"];
        $support['email'] = $row["email"];
        $support['isWhatsappEnabled'] = $row["isWhatsappEnabled"];
        $support['isWhatsappEnabledDemo'] = $row["isWhatsappEnabledDemo"];
        $support['isInstaEnabled'] = $row["isInstaEnabled"];
        $support['isInstaEnabledDemo'] = $row["isInstaEnabledDemo"];
        $support['isFacebookEnabled'] = $row["isFacebookEnabled"];
        $support['isFacebookEnabledDemo'] = $row["isFacebookEnabledDemo"];
        $support['showDemoMessage'] = $row["showDemoMessage"];
        $support['showDemoCompletedMessage'] = $row["showDemoCompletedMessage"];
        $support['appLatestVersionCode'] = $row["appLatestVersionCode"];

        return $support;
    }

    public function saveWhatsappNumber($mobile)
    {
        $stmtTime = $this->con->prepare("SET time_zone = '+05:30'");
        $stmtTime->execute();

        $stmt = $this->con->prepare("insert into demo_whatsapp_contacts (mobile) values (?)");
        $stmt->bind_param("s", $mobile);
        if ($stmt->execute()) {
            return "success";
        } else {
            return "failed";
        }
    }

    private function isAlreadyRequested($user_id)
    {

        $stmt = $this->con->prepare("select order_id from order_requests where user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    private function isUserExist($user_id)
    {

        $stmt = $this->con->prepare("select user_id from users where user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    private function isAppLocked()
    {

        $stmt = $this->con->prepare("select app_status from websitestatus");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['app_status'] == 0)
            return true;
        else return false;
    }


    private function isAdminExist($usernname)
    {

        $stmt = $this->con->prepare("select id from admin where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
