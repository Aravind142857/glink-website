<?php
require_once 'db.inc.php';

$email = $_GET['email'];
$username = $_GET['username'];
$password = $_GET['password'];
$id = rand(0,99999999);

$hash = password_hash($password,PASSWORD_BCRYPT);

$session = init_cass_db();

$statement = $session->prepare('SELECT id FROM users WHERE email=? OR username=? ALLOW FILTERING;');
$result = $session->execute($statement, array('arguments' => array($email,$username)));

if ($result->count() != 0) {
	echo('The username or email address already exists. Please try another username/email address.');
	exit();
}

$statement = $session->prepare('INSERT INTO users (id,email_addr,username,password_hash) VALUES (?,?,?,?);');
$result = $session->execute($statement, array('arguments' => array($id,$email,$username,$hash)));

echo('Registration successful.');


?>
