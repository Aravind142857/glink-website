<?php
$email = $_GET['email'];
$password = $_GET['password'];

$session = init_cass_db();

$statement = $session->prepare('SELECT password FROM users WHERE email=? ALLOW FILTERING;');

$result = $session->execute($statement,array('arguments' => array($email)));

if ($result->count() <= 0) {
	echo('Invalid email address or password.');
	exit();
} else {
	$hash = $row[0]['password'];

	if (password_verify($password,$hash) != true) {
		echo('Invalid email address or password.');
		exit();
	} else {
		session_start();
		$_SESSION['user'] = $email;
		echo('Logged in successfully. You are ' . $_SESSION['user']);
	}
}

?>
