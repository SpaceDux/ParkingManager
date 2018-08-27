<?php
  namespace ParkingManager;

  class AJAX
  {
    #Variables
    private $mysql;
    public function __construct() {
      $this->mysql = new MySQL;
    }
    //Ajax Request Exit Vehicle (SENT VIA Ajax Handler)
    public function exitVehicle($key) {
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '3', veh_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      $stmt->execute();
    }


  }
?>
