<?php
  namespace ParkingManager_API;
  class MSSQL
  {
    #Variables
    public $dbc;
    private $_CONFIG;

    public function __construct() {
      $this->Connection_Primary();
    }
    public function Connection_Primary() {
      global $_CONFIG;
      try {
        $this->dbc = new \PDO('sqlsrv:Server='.$_CONFIG['mssql']['host'].';Database='.$_CONFIG['mssql']['db'].'', $_CONFIG['mssql']['user'], $_CONFIG['mssql']['pass']);
      } catch (\PDOException $e) {
        die("MSSQL Engine Error: ".$e->getMessage());
      }
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
  }
?>
