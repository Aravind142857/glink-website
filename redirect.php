<?php
	use Cassandra;

	$uri = $_SERVER['REQUEST_URI'];
	$uri = substr($uri,1);

	$matches_uri = preg_match('/^[a-zA-Z]+$/',$uri);

	if (($matches_uri == 0) || ($matches_uri == false)) {
		header("Location: http://glink.zip/");
	        exit;
	} else {

		$cluster = Cassandra::cluster()->withPersistentSessions(true)->build();
		$keyspace = 'glink';
		$session = $cluster->connect($keyspace);

		$statement = $session->prepare('SELECT url,is_geo FROM data WHERE shortlink=? ALLOW FILTERING;');
		$result = $session->execute($statement,array('arguments' => array($uri)));

		if ($result->count() == 0) {
			printf('The given GLink was invalid, and doesn\'t point to a specific web page.');
			exit;
		}

		foreach($result as $row) {
			if (is_null($row)) {
				printf('The given GLink was invalid, and doesn\'t point to a specific web page.');
				exit;
			} else {
				if ($row['is_geo'] == true) {
					header("Location: https://glink.zip/reqloc.html?glink=" . $uri);
					exit;
				} else {
					header("Location: " . $row['url']);
					exit;
				}
			}
		}
	}

?>
