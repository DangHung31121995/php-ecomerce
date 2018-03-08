<?php
if (!isset($_SESSION)){
    session_start();
}
if ($_SESSION['last_session_request'] > (time() - 5)){
    if (empty($_SESSION['last_request_count'])){
        $_SESSION['last_request_count'] = 1;
    } elseif ($_SESSION['last_request_count'] < 5){
        $_SESSION['last_request_count'] = $_SESSION['last_request_count'] + 1;
    } elseif ($_SESSION['last_request_count'] >= 5){
        echo "Ban dang truy cap bat thuong";
        exit;
    }
} else{
    $_SESSION['last_request_count'] = 1;
}
$_SESSION['last_session_request'] = time();