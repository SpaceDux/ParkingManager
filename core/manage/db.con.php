<?php
	
	require_once(__DIR__.'/core/manage/config.php'); //require the config file for sql dets
	
	try {
		$dbConn = new pdo("mysql:host=$dbHost;dbname=$dbSel;", $dbU, $dbPw);
	} catch(PDOException $e) {
		die("Failed to Connect: " . $e->getMessage());
	}
	
?>