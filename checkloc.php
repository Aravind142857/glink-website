<?php
	$latitude = $_GET["latitude"];
	$longitude = $_GET["longitude"];
	$glink = $_GET["glink"];

	printf("Lat is %s, Long is %s, and glink is %s",$latitude,$longitude,$glink);

	// Check the database to see if user is allowed to access the URL. If they are, respond 'Yes' (for the time being), if they are not, respond 'No' (for the time being).

	// To check if the user is allowed to access the URL, check if the distance between their location and the location in the database is less than the radius. To compute the
	// distance, use something like Haversine Forumla.


?>
