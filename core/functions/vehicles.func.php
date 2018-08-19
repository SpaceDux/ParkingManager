<?php
  namespace ParkingManager;

  class Vehicles implements iVehicles {
    #Variables
    private $dbc;
    private $anpr;
    private $user;

    public function __construct() {
      $this->dbc = new MySQL;
      $this->anpr = new MSSQL;
      $this->user = new User;
    }
    
  }
 ?>
