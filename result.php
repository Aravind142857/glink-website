<?php
session_start();
require_once 'db.inc.php';

function gen_base62_rand_shortlink($len) {
	$rand_bytes = random_bytes(intval(($len * 2) / 3));
        $rand_string = base64_encode($rand_bytes);
	$rand_string = str_replace("+","",$rand_string);
        $rand_string = str_replace("/","",$rand_string);
        $rand_string = str_replace("=","",$rand_string);

	if (mb_strlen($rand_string) < $len) {
		$curlen = mb_strlen($rand_string);
		$rand_string = $rand_string . gen_rand_shortlink($len - $curlen);
	}

	return $rand_string;
}

function gen_rand_shortlink($len) {
	$to_return = '';
	$possible_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	while (mb_strlen($to_return) < $len) {
		$to_return = $to_return . $possible_chars[rand(0, mb_strlen($possible_chars)-1)];
	}

	return $to_return;

}


ini_set('display_errors', 1);

$session = init_cass_db();

$url = $_GET["url"];

if (isset($_GET["restricted"])) {
	$is_geo = 1;
} else {
	$is_geo = 0;
}

if ($is_geo == 1) {
	$radius = $_GET["radius"];

	$latitude = $_GET["latitude"];
	$latitude = doubleval($latitude);

	$longitude = $_GET["longitude"];
	$longitude = doubleval($longitude);
}

$matches = preg_match('/^http(s)*:\\/\\/[a-zA-Z0-9\\-]+(\\.[a-zA-Z0-9\\-]+)+[\\/_#a-zA-Z0-9\\-]*$/',$url);
if (($matches == 0) || ($matches == false)) {
	printf("The URL entered was invalid. Please try again.");
	return;
}

$shortlink = $_GET["glink"];

if (isset($_GET["ttl"])) {
	$ttl = $_GET["ttl"];
} else {
	$ttl = 0;
}

if ($shortlink != '') {
	$matches_shortlink = preg_match('/^[a-zA-Z]+$/',$shortlink);
	if (($matches_shortlink == 0) || ($matches_shortlink == false)) {
	        printf("The GLink entered was invalid. The GLink can only contain letters. Please try again.");
	        return;
	}
} else {
	/* generate a random shortlink */
	gen_shortlink:
		$rand_string = gen_rand_shortlink(6);  /* the function is defined at the start of this file */
		$shortlink = $rand_string;

		/* Check if shortlink is already taken by querying the database */
		$statement = $session->prepare('SELECT url FROM data WHERE shortlink=? ALLOW FILTERING');
		$result = $session->execute($statement,array('arguments' => array($shortlink)));

		if ($result->count() != 0) {
			goto gen_shortlink;
		}

}

//$statement = new Cassandra\SimpleStatement('SELECT name FROM data WHERE id=5');

$statement = $session->prepare('SELECT url FROM data WHERE shortlink=? ALLOW FILTERING');
$options = array('arguments' => array($shortlink));
$result = $session->execute($statement,$options);

if ($result->count() != 0) {
	printf('That GLink is already taken. Please try another one.');
	exit;
}


$statement = $session->prepare('INSERT INTO data (id, url, shortlink, is_geo, radius, latitude, longitude, user, when_created) VALUES (now(),?,?,?,?,?,?,?,toTimestamp(now())) USING TTL ?;');

if ($is_geo == 1) {
	$options = array($url,$shortlink,boolval($is_geo),intval($radius), $latitude, $longitude, $_SESSION['user'], intval($ttl));
} else {
	$options = array($url,$shortlink,boolval($is_geo),null,null,null,$_SESSION['user'],intval($ttl));
}

$result = $session->execute($statement,array('arguments' => $options));

//$stringRepresentation= json_encode($result[0]);

//printf("%s\n\n\n",$stringRepresentation);

//foreach($result as $row) {
//	if (is_null($row)) {
//		printf('Unsuccessful');
//	} else {
		printf('Successful: The URL you entered was: %s and your GLink is: https://glink.zip/%s', $url,$shortlink);
//	}
//}
//printf('Done');

?>
