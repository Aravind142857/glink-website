<?php
ini_set('display_errors', 1);
use Casssandra;

$cluster = Cassandra::cluster()->build();
$keyspace = 'glink';

$url = $_GET["url"];
$shortlink = $_GET["glink"];

$session = $cluster->connect($keyspace);

//$statement = new Cassandra\SimpleStatement('SELECT name FROM data WHERE id=5');
$rand_num = rand(0,99999999);

$values = array(
	'id' => $rand_num,
	'url' => $url,
	'shortlink' => $shortlink,
);
$statement = new Cassandra\SimpleStatement('INSERT INTO data (id, url, shortlink, when_created) VALUES (?,?,?,toTimestamp(now()))');
$options = array('arguments' => $values);
$result = $session->execute($statement,$options);

$statement = new Cassandra\SimpleStatement('SELECT url,shortlink FROM data WHERE id=?');
$options = array('arguments' => array('id' => $rand_num));
$result = $session->execute($statement,$options);

//$stringRepresentation= json_encode($result[0]);

//printf("%s\n\n\n",$stringRepresentation);

foreach($result as $row) {
	if (is_null($row)) {
		printf('Unsuccessful');
	} else {
		printf('Successful: The URL you entered was: %s and your GLink is: https://glink.zip/%s', $row['url'],$row['shortlink']);
	}
}
//printf('Done');

?>
