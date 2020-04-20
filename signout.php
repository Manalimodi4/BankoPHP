<?php
session_start();
require 'connection.php';
$query = "UPDATE `accounts` SET `roomID` = NULL WHERE `username` =".db_quote($_SESSION['player']['username']);
$response = db_query($query);
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
// unset($_SESSION);
header('Location: index.php');
?>