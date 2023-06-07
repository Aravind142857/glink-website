<?php
ini_set('display_errors', 1);
use Casssandra;

$cluster = Cassandra::cluster()->build();
$keyspace = 'glink';

$url = $_GET["url"];
$shortlink = $_GET["glink"];

$session = $cluster->connect($keyspace);

//$statement = new Cassandra\SimpleStatement('SELECT name FROM data WHERE id=5');
$rand_num = rand(0,999999);

$values = array(
	'id' => $rand_num,
	'url' => $url,
	'shortlink' => $shortlink,
);

$statement = new Cassandra\SimpleStatement('INSERT INTO data (id, url, shortlink, when_created) VALUES (?,?,?,toTimestamp(now()))');
$options = array('arguments' => $values);

$future = $session->executeAsync($statement,$options);
$result = $future->get();

printf('Successful');

?>
