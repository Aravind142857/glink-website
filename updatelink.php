<?php
session_start();
require_once 'db.inc.php';

$session = init_cass_db();

//GET ROW ID
$statement = $session->prepare('SELECT * FROM DATA WHERE user=? AND shortlink=? AND url=? ALLOW FILTERING;');
$result = $session->execute($statement,array('arguments' => array($_SESSION['user'],$_POST['old_link'], $_POST['old_url'])));
$row_id = $result[0]['id'];



$statement = $session->prepare('UPDATE data SET shortlink=?, url=?, user=? WHERE id=?;');
$new_result = $session->execute($statement,array('arguments' => array($_POST['link'], $result[0]['url'], $result[0]['user'], $row_id)));

http_response_code(204);
?>
