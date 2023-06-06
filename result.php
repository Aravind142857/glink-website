<?php
ini_set('display_errors', 1);
use Casssandra;

$cluster = Cassandra::cluster()->build();
$keyspace = 'glink';

$session = $cluster->connect($keyspace);

$statement = new Cassandra\SimpleStatement('SELECT name FROM data WHERE id=5');

$future = $session->executeAsync($statement);
$result = $future->get();

foreach ($result as $row) {
	printf("The name is %s",$row['name']);
}

?>
