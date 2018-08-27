<?php
  namespace ParkingManager;

  class AJAX
  {
    #Variables
    private $mysql;
    private $vehicle;

    public function __construct() {
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
    }
    //Ajax Request Exit Vehicle (SENT VIA Ajax Handler)
    public function exitVehicle($key) {
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '3', veh_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      $stmt->execute();
    }
    //Ajax Request Mark Renewal
    public function markRenewal($key) {
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '2' WHERE id = :id");
      $stmt->bindParam(':id', $key);
      $stmt->execute();
    }
    //Ajax Request un-Mark Renewal
    public function unmarkRenewal($key) {
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '1' WHERE id = :id");
      $stmt->bindParam(':id', $key);
      $stmt->execute();
    }

  }
?>
