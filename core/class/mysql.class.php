<?php
  namespace ParkingManager;
  class MySQL
  {
    #Variables
    public $dbc;

    public function __construct() {
      try {
        $this->dbc = new \PDO("mysql:host=127.0.0.1;dbname=new_rkpm;", 'root', '');
      } catch (\PDOException $e) {
        echo "ParkingManager: MySQL Engine Error ::".$e->getMessage();
        die();
      }
    }
  }
?>
