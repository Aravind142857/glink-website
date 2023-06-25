<?php
	function init_cass_db() {
		$cluster = Cassandra::cluster()->withPersistentSessions(true)->build();
		$keyspace = 'glink';
		$session = $cluster->connect($keyspace);

		return $session;
	}
?>
