<?php
ini_set('display_errors', 1);
use Casssandra;

$cluster = Cassandra::cluster()->build();
$keyspace = 'glink';

$url = $_GET["url"];
$matches = preg_match('/^http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+$/',$url);
if (($matches == 0) || ($matches == false)) {
	printf("The URL entered was invalid. Please try again.");
	return;
}

$shortlink = $_GET["glink"];
$matches_shortlink = preg_match('/^[a-zA-Z]+$/',$shortlink);
if (($matches_shortlink == 0) || ($matches_shortlink == false)) {
        printf("The GLink entered was invalid. The GLink can only contain letters. Please try again.");
        return;
}


$session = $cluster->connect($keyspace);

//$statement = new Cassandra\SimpleStatement('SELECT name FROM data WHERE id=5');
$rand_num = rand(0,99999999);

$statement = $session->prepare('INSERT INTO data (id, url, shortlink, when_created) VALUES (?,?,?,toTimestamp(now()))');
$result = $session->execute($statement,array('arguments' => array($rand_num,$url,$shortlink)));

$statement = $session->prepare('SELECT url,shortlink FROM data WHERE id=?');
$options = array('arguments' => array($rand_num));
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
