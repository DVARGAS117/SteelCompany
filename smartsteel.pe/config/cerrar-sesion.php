<?php
require("conexion.php");
session_start();
session_destroy();
$_SESSION = array();
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['domain'], $params['secure'], $params['httponly']);
}
header("location:../index.php");
