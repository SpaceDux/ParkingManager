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
			$sql = "SELECT * FROM parking WHERE col = 2 AND h_light != 1 ORDER BY timein asc";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();
		}
		function fetchExit() {
			global $dbConn;
			$sql = "SELECT * FROM parking WHERE col = 3 ORDER BY timeout desc LIMIT 30";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();
		}
		function fetchRenewal() {
			global $dbConn;
			$sql = "SELECT * FROM parking WHERE h_light = 1 AND col != '3' ORDER BY timein asc";
			$stmt = $dbConn->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();
		}
	}

?>
