<?php
  namespace ParkingManager;

  class Payment
  {
    #Variables
    protected $mysql;
    protected $mssql;
    private $user;
    private $vehicle;
    private $campus;

    function __construct() {
        //Initialize Class'
        $this->mysql = new MySQL;
        //$this->anpr = new MSSQL;
        $this->user = new User;
        $this->vehicles = new Vehicles;

        $this->campus = $this->user->userInfo('campus');
    }
    function listTransactions() {
      $query = $this->mysql->dbc->prepare("SELECT * FROM payments WHERE campus = ? ORDER BY service_date DESC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $table = "<tr>";
        $table .= "";
      }
    }
  }

?>
