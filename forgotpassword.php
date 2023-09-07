<?php
session_start();
require_once 'db.inc.php';
require 'rand_string.inc.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];
$session = init_cass_db();

// Compute hash for the link, and store in database
$rand_val = gen_base62_rand_shortlink(30);
$statement = $session->prepare('SELECT id FROM users where email=? ALLOW FILTERING;');
$result = $session->execute($statement,array('arguments' => array($email)));
$row_id = $result[0]['id'];
$statement = $session->prepare('UPDATE users SET forgot_pass_id=? WHERE id=?;');
$result = $session->execute($statement,array('arguments' => array($rand_val,$row_id)));
//TODO - Don't throw an error if the email address does not exist. Instead, silently skip everything and print the last line.

$env = parse_ini_file("../../variables.env");

$mail = new PHPMailer(false);
$mail->isSMTP();
$mail->Host = $env['EMAIL_HOST'];
$mail->SMTPAuth = 'true';
$mail->Username = $env['EMAIL_ADDRESS'];
$mail->Password = $env['EMAIL_PASSWORD'];
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom($env['EMAIL_ADDRESS'], 'GLink Support');
$mail->addAddress($email);

$mail->Subject = 'Password Reset';
$mail->Body = 'Your password reset link is https://glink.zip/passwordreset.html?val=' . $rand_val;

$mail->send();

echo("If you have an account with us, you should have received an email with a link to reset your password.");
?>
