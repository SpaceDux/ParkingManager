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
      //Start Class files
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");

      if(isset($campus)) {
          try {
            $this->dbc = new \PDO('sqlsrv:Server='.$this->pm->PM_SiteInfo($campus, 'site_anpr_ip').';Database='.$this->pm->PM_SiteInfo($campus,'site_anpr_db').'', $this->pm->PM_SiteInfo($campus, 'site_anpr_user'), $this->pm->PM_SiteInfo($campus, 'site_anpr_pass'));
          } catch (\PDOException $e) {
            die("MSSQL Engine Error: ".$e->getMessage());
          }
        } else {
        //Do nothing, no need to establish any connection
        //as user is not logged in.
      }
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
  }

?>
