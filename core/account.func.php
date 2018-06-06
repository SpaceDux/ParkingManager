<?php
  require(__DIR__.'/manage/config.php');

  class Account {
    function getVehicles($acc, $sDate, $eDate) {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE company = ? AND col < 4 AND timein BETWEEN ? AND ?";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $acc);
      $stmt->bindParam(2, $sDate);
      $stmt->bindParam(3, $eDate);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    function getTickets($veh_id) {
      global $dbConn;
      $sql = "SELECT * FROM payments WHERE veh_id = ? ORDER BY tot DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $veh_id);
      $stmt->execute();

      return $stmt->fetchAll();
    }
  }
?>
