<?php
session_start();
require_once 'db.inc.php';

$session = init_cass_db();

//GET ROW ID
$statement = $session->prepare('SELECT * FROM DATA WHERE user=? AND shortlink=? ALLOW FILTERING;');
$result = $session->execute($statement,array('arguments' => array($_SESSION['user'],$_POST['link'])));
$row_id = $result[0]['id'];



$statement = $session->prepare('UPDATE data USING TTL 8 SET hell=true, shortlink=?, url=?, user=?, latitude=?, longitude=?, radius=? WHERE id=?;');
$new_result = $session->execute($statement,array('arguments' => array($_POST['link'], $result[0]['url'], $result[0]['user'], $result[0]['latitude'], $result[0]['longitude'], $result[0]['radius'], $row_id)));


http_response_code(204);
?>
