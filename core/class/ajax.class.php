<?php
  namespace ParkingManager;

  class AJAX
  {
    #Variables
    protected $mysql;
    private $vehicle;
    private $user;
    protected $mssql;
    //Ajax Request Exit Vehicle (SENT VIA Ajax Handler)
    public function exitVehicle($key) {
      //Prep Class
      $this->mysql = new MySQL;
      //Query
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '3', veh_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      $stmt->execute();
      $this->mysql = null;
    }
    //Ajax Request Mark Renewal
    public function markRenewal($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $renewalResult = $this->vehicle->vehInfo("veh_column", $key);
      if($renewalResult == 1) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '2' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax setFlag
    public function setFlag($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $flagResult = $this->vehicle->vehInfo("veh_flagged", $key);
      if($flagResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_flagged = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_flagged = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax deleteVehicle
    public function deleteVehicle($key) {
      //Prep class;
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $deleteResult = $this->vehicle->vehInfo("veh_deleted", $key);
      if($deleteResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_deleted = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_deleted = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Add vehicle to ANPR dB
    public function addVehicleANPR() {
      $this->mssql = new MSSQL();

      $query = $this->mssql->prepare("INSERT INTO ANPR_REX () VALUES() ");
    }
    //Delete Notice
    public function deleteNotice($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM notices WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $this->mysql = null;
    }
  }
?>
