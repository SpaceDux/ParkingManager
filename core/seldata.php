<?php
  $db = new PDO("mysql:host=localhost;dbname=rkpm;", 'root', '1123');
  class Parking {
    function fetchParked() {
      global $db;

      $sql = "SELECT * FROM parking WHERE col = 1";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();

    }

  }
?>
