<?php
  class Account {
    function getVehicles($acc, $sDate, $eDate) {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE company = ? AND col < 4 AND timein BETWEEN ? AND ? ORDER BY type ASC";
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
    function reportTimeCalc($time1, $time2) {
      try {
        if(isset($time1)) {
          $d1 = new DateTime($time1);
          $d2 = new DateTime($time2);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);
          echo $h." : ".$int->format('%i');
        }
      } catch(Exception $e) {
        echo "<red>Time Construction error, please correct</red>";
      }
    }
  }
?>
