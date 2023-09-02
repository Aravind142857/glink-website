<?php
require_once 'db.inc.php';

$email = $_POST['email'];
$password = $_POST['password'];

$session = init_cass_db();

$statement = $session->prepare('SELECT password_hash FROM users WHERE email=? ALLOW FILTERING;');

$result = $session->execute($statement,array('arguments' => array($email)));

if ($result->count() <= 0) {
	echo('Invalid email address or password.');
	exit();
} else {
	$hash = $result[0]['password_hash'];

	if (password_verify($password,$hash) != true) {
		echo('Invalid email address or password.');
		exit();
	} else {
		session_start();
		$_SESSION['user'] = $email;
		header('Location: https://glink.zip?res=success');
	}
}

?>
