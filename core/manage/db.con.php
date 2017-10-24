<?php
	
	require_once(__DIR__.'/config.php');
	
	try {
		$dbConn = new PDO("mysql:host=$dbHost;dbname=$dbSel;", $dbU, $dbPw);
	} catch(PDOException $e) {
		die("Failed to Connect: " . $e->getMessage());
	}
	
?>