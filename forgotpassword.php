<?php
session_start();
require_once 'db.inc.php';
$email = $_POST['email'];
$session = init_cass_db();

// Create a hash of the email and the timestamp, and send an email with a link that contains the hash as a GET variable.


?>
