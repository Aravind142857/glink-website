<?php
session_start();
require_once 'db.inc.php';

$session = init_cass_db();

//GET ROW ID
$statement = $session->prepare('SELECT * FROM DATA WHERE user=? AND shortlink=? ALLOW FILTERING;');
$result = $session->execute($statement,array('arguments' => array($_SESSION['user'],$_POST['old_link'])));
$row_id = $result[0]['id'];



$statement = $session->prepare('UPDATE data SET url=? WHERE id=?;');
$new_result = $session->execute($statement,array('arguments' => array($_POST['url'], $row_id)));

http_response_code(204);
?>
