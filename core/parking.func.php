<?php
  class Parking {
    //Fetch Breaks
    function fetchBreak() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '1' ORDER BY timein DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Paid
    function fetchPaid() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '2' AND h_light != '1' ORDER BY timein ASC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Renewals
    function fetchRenewals() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE h_light = '1' AND col < 3 ORDER BY timein DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Exits
    function fetchExits() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '3' ORDER BY timeout DESC LIMIT 50";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }

    //Fetch Payments
    function fetchPayments($row_id) {
      global $dbConn;
      $sql = "SELECT * FROM payments WHERE veh_id = ? ORDER BY id DESC LIMIT 1";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $row_id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //Get Details
    function fetchVehicle($veh_id) {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE id = ?";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $veh_id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  }
?>
