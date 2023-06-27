<?php

if (session_status() != PHP_SESSION_ACTIVE) {
	header('Location: https://glink.zip');
}

session_start();

// Unset all session variables
session_unset();
$_SESSION = array();

// Delete the session cookie by setting an equivalent one with a blank value
$params = session_get_cookie_params();

setcookie(session_name(),'', time()-42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Destroy the session
session_destroy();

header('Location: https://glink.zip/');
?>

