<?php
  namespace Krypton;

  class Parked
  {
    function getBreaks()
    {
      global $mysql;
      $sql = "SELECT * FROM parking WHERE col = '1'";
      $stmt = $mysql->Connect->prepare($sql);

      $stmt->execute();

      $return = $stmt->fetchAll();

      foreach ($return as $data) {

      }
    }
  }
?>
