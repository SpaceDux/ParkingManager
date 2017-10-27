<?php
	class fetchParked {
		function fetchBreak() {
			global $dbConn;
			$sql = "SELECT * FROM parking WHERE col = 1 ORDER BY timein DESC";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
		function fetchPaid() {
			global $dbConn;
			$sql = "SELECT * FROM parking WHERE col = 2 ORDER BY timein asc";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
		function fetchExit() {
			global $dbConn;
			$sql = "SELECT * FROM parking WHERE col = 3 ORDER BY timeout DESC LIMIT 20";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
	}	
	
?>