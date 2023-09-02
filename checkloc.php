<?php
	session_start();
	require_once 'db.inc.php';
	if (isset($_SESSION['glink']) && !empty($_SESSION['glink'])) {
		session_unset();
		session_destroy();
	} else {
		http_response_code(403);
		die('Forbidden.');
	}
	// FUNCTION TO CALCULATE HAVERSINE DISTANCE GIVEN COORDINATES OF
	// TWO POINTS, AND RADIUS (IN KM)
	function haversine_distance($lat1, $long1, $lat2, $long2, $radius) {
		$term_1 = $lat2 - $lat1;
		$term_1 = $term_1 / 2;
		$term_1 = sin($term_1);
		$term_1 = pow($term_1, 2);

		$term_2 = $long2 - $long1;
		$term_2 = $term_2 / 2;
		$term_2 = sin($term_2);
		$term_2 = pow($term_2, 2);
		$term_2 = $term_2 * cos($lat1);
		$term_2 = $term_2 * cos($lat2);

		$distance = $term_1 + $term_2;
		$distance = sqrt($distance);
		$distance = asin($distance);
		$distance = $distance * 2;
		$distance = $distance * $radius;

		return $distance;
	}


	function km_to_miles($distance) {
		return $distance * 0.62137119;
	}


	$user_lat = $_POST["latitude"];
	$user_lat = $user_lat * (M_PI / 180);
	$user_long = $_POST["longitude"];
	$user_long = $user_long * (M_PI / 180);
	$glink = $_POST["glink"];

	$session = init_cass_db();

	$statement = $session->prepare('SELECT latitude,longitude,radius,url FROM data WHERE shortlink=? ALLOW FILTERING;');
	$result = $session->execute($statement,array('arguments' => array($glink)));

	$link_lat = floatval($result[0]['latitude']);
	$link_lat = $link_lat * (M_PI / 180);
	$link_long = floatval($result[0]['longitude']);
	$link_long = $link_long * (M_PI / 180);
	$target_radius = intval($result[0]['radius']);

	$url = $result[0]['url'];

	$distance = haversine_distance($link_lat, $link_long, $user_lat, $user_long, 6371.009);
	$distance = km_to_miles($distance);

	if ($distance <= $target_radius) {
		printf("%s",$url);
	} else {
		printf("B");
	}

	// Check the database to see if user is allowed to access the URL. If they are, respond 'Yes' (for the time being), if they are not, respond 'No' (for the time being).

	// To check if the user is allowed to access the URL, check if the distance between their location and the location in the database is less than the radius. To compute the
	// distance, use something like Haversine Forumla.


?>
