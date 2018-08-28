<?php
  namespace ParkingManager;
  class MySQL
  {
    #Variables
    public $dbc;

    public function __construct() {
      global $_CONFIG;
      try {
        $this->dbc = new \PDO('mysql:host='.$_CONFIG['mysql']['ip'].':'.$_CONFIG['mysql']['port'].';dbname='.$_CONFIG['mysql']['database'].';', $_CONFIG['mysql']['user'], $_CONFIG['mysql']['pass']);
      } catch (\PDOException $e) {
        echo "ParkingManager: MySQL Engine Error ::".$e->getMessage();
        die();
      }
    }
  }
?>
