<?php
  namespace ParkingManager;
  class MSSQL
  {
    #Variables
    public $dbc;
    private $mysql;
    private $user;
    private $campus;
    private $useANPR;

    public function __construct() {
      global $_CONFIG;
      //Start Class files
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->campus = $this->user->userInfo("campus");

      if(isset($this->campus)) {
        if($this->campus == 1) {
          try {
            $this->dbc = new \PDO('sqlsrv:Server='.$_CONFIG['anpr_holyhead']['ip'].';Database='.$_CONFIG['anpr_holyhead']['database'].'', $_CONFIG['anpr_holyhead']['user'], $_CONFIG['anpr_holyhead']['pass']);
          } catch (\PDOException $e) {
            die("MSSQL Engine Error: ".$e->getMessage());
          }
        } else if($this->campus == 2) {
          //Run ANPR-MSSQL Connection (Hollies)
          try {
            $this->dbc = new \PDO('sqlsrv:Server='.$_CONFIG['anpr_cannock']['ip'].';Database='.$_CONFIG['anpr_cannock']['database'].'', $_CONFIG['anpr_cannock']['user'], $_CONFIG['anpr_cannock']['pass']);
          } catch (\PDOException $e) {
            die("MSSQL Engine Error: ".$e->getMessage());
          }
        }
      } else {
        //Do nothing, no need to establish any connection
        //as user is not logged in.
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
  }

?>
