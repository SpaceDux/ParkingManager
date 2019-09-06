<?php
  namespace ParkingManager;
  class MSSQL
  {
    #Variables
    public $dbc;
    public $dbc2;
    private $mysql;
    private $user;
    private $campus;

    public function __construct() {
      $this->Connection_Primary();
      $this->Connection_Secondary();
    }
    public function Connection_Primary() {
      //Start Class files
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->Info("Site");
      if(isset($campus)) {
        try {
          $this->dbc = new \PDO('sqlsrv:Server='.$this->pm->Site_Info($campus, 'ANPR_IP').';Database='.$this->pm->Site_Info($campus,'ANPR_DB').'', $this->pm->Site_Info($campus, 'ANPR_User'), $this->pm->Site_Info($campus, 'ANPR_Password'));
        } catch (\PDOException $e) {
          die("MSSQL Engine Error: ".$e->getMessage());
        }
      } else {
        // Do nothing
      }
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    public function Connection_Secondary() {
      //Start Class files
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->Info("Site");
      if($this->pm->Site_Info($campus, "Secondary_ANPR") == 1) {
        $this->dbc2 = new \PDO('sqlsrv:Server='.$this->pm->Site_Info($campus, 'Secondary_ANPR_IP').';Database='.$this->pm->Site_Info($campus,'Secondary_ANPR_DB').'', $this->pm->Site_Info($campus, 'Secondary_ANPR_User'), $this->pm->Site_Info($campus, 'Secondary_ANPR_Pass'));
        $this->dbc2->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        if(!$this->dbc2) {
          echo json_encode(array("Status" => 0, "Msg" => "Data Connection issue"));
        } else {
          echo json_encode(array("Status" => 1, "Msg" => "Successful Connection"));
        }
      }
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
  }
?>
