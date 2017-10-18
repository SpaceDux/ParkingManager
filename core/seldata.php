<?php
  $db = new PDO("mysql:host=localhost;dbname=rkpm;", 'root', '1123');
  class Parking {
    function fetchParked1() {
      global $db;

      $sql = "SELECT * FROM parking WHERE col = 1 ORDER BY timein";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();

    }
    function fetchParked2() {
      global $db;

      $sql = "SELECT * FROM parking WHERE col = 2 ORDER BY timein";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();

    }
    function fetchParked3() {
      global $db;

      $sql = "SELECT * FROM parking WHERE col = 3 ORDER BY timeout DESC LIMIT 20";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();

    }

  }
?>
