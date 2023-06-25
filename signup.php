<?php
require_once 'db.inc.php';

$email = $_GET['email'];
$email = strval($email);
$username = $_GET['username'];
$password = $_GET['password'];
$id = rand(0,99999999);

$hash = password_hash($password,PASSWORD_BCRYPT);

$session = init_cass_db();

$statement = $session->prepare("SELECT id FROM users WHERE email=? ALLOW FILTERING;");
$result = $session->execute($statement, array('arguments' => array($email)));

if ($result->count() != 0) {
	echo('The username or email address already exists. Please try another email address.');
	exit();
}

$statement = $session->prepare('INSERT INTO users (id,email,username,password_hash) VALUES (?,?,null,?);');
$result = $session->execute($statement, array('arguments' => array($id,$email,$hash)));

echo('Registration successful.');


?>
