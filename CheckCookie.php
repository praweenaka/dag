<?php

session_start();
date_default_timezone_set('Asia/Colombo');

function chk_cookie($UserName) {
    include './connection_sql.php';

    $sql = "SELECT * FROM user_mast WHERE user_name =  '" . $UserName . "'";
    $result = $conn->query($sql);

    if ($row = $result->fetch()) {

        $sessionId = session_id();
        $_SESSION['sessionId'] = session_id();
        session_regenerate_id();
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['UserName'] = $UserName;    
        $_SESSION["CURRENT_USER"] = $UserName;
        
        $action = "ok";

        $cookie_name = "user";
        $cookie_value = $UserName;

        $token = substr(hash('sha512', mt_rand() . microtime()), 0, 50);
        $extime = time() + 160000000;
        $domain = $_SERVER['HTTP_HOST'];
        setcookie('user', $cookie_value, $extime, "/", $domain);

        $time = date("H:i:s");
        $today = date('Y-m-d');
        clearstatcache();
        
        return $action;
    } else {

        return "not";
        echo 'not';
    }
}
