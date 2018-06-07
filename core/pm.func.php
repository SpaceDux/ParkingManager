<?php
  require __DIR__.'/manage/config.php';
  class ParkingManager {
    function fetchNotices() {
      global $dbConn;
      $stmt = $dbConn->prepare("SELECT * FROM notices WHERE active = 1 ORDER BY id DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    function newNotice($short, $body, $type) {
      global $dbConn;
      $short = strtoupper($short);
      $stmt = $dbConn->prepare("INSERT INTO notices VALUES ('', ?, ?, '1', ?)");
      $stmt->bindParam(1, $short);
      $stmt->bindParam(2, $body);
      $stmt->bindParam(3, $type);#
      $stmt->execute();
    }
  }

?>
