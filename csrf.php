<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function csrf_token() {
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token'];
}

function validate_csrf_token($token) {
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        return false;
    }
    return true;
}
?>
