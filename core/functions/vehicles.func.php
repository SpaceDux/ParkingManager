<?php
  namespace ParkingManager;

  class Vehicles implements iVehicles {
    #Variables
    private $dbc;
    private $anpr;
    private $user;
    protected $paid;

    public function __construct() {
      $this->dbc = new MySQL;
      //$this->anpr = new MSSQL;
      $this->user = new User;
    }
    public function get_anprFeed() {
      //Code for anpr table
    }
    public function get_paidFeed() {
      $campus = $this->user->userInfo('campus');
      $query = $this->dbc->dbc->prepare("SELECT * FROM veh_log WHERE veh_column = 1 AND campus = ?");
      $query->bindParam(1, $campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        //Determine Type & echo name type.
        if($result['veh_type'] == 1) {
          $result_type = "C/T";
        } else if($result['veh_type'] == 2) {
          $result_type = "CAB";
        } else if($result['veh_type'] == 3) {
          $result_type =  "TRL";
        } else if($result['veh_type'] == 4) {
          $result_type = "RIGID";
        } else if($result['veh_type'] == 5) {
          $result_type = "COACH";
        } else if($result['veh_type'] == 7) {
          $result_type = "CAR";
        } else if($result['veh_type'] == 8) {
          $result_type = "M/H";
        } else if($result['veh_type'] == 0) {
          $result_type = "N/A";
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$result_type.'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timein'])).'</td>';
        $table .= '<td>TICKET ID</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>
            <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Exit Vehicle</a>
                <a class="dropdown-item" href="#">Mark Renewal</a>
                <a class="dropdown-item" href="#">Flag Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">View ANPR Record</a>
              </div>
            </div>
          </div>
        </td>';
        echo $table;
      }
    }
    public function get_renewalFeed() {
      $campus = $this->user->userInfo('campus');
      $query = $this->dbc->dbc->prepare("SELECT * FROM veh_log WHERE veh_column = 2 AND campus = ?");
      $query->bindParam(1, $campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        //Determine Type & echo name type.
        if($result['veh_type'] == 1) {
          $result_type = "C/T";
        } else if($result['veh_type'] == 2) {
          $result_type = "CAB";
        } else if($result['veh_type'] == 3) {
          $result_type =  "TRL";
        } else if($result['veh_type'] == 4) {
          $result_type = "RIGID";
        } else if($result['veh_type'] == 5) {
          $result_type = "COACH";
        } else if($result['veh_type'] == 7) {
          $result_type = "CAR";
        } else if($result['veh_type'] == 8) {
          $result_type = "M/H";
        } else if($result['veh_type'] == 0) {
          $result_type = "N/A";
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$result_type.'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timein'])).'</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Exit Vehicle</a>
                <a class="dropdown-item" href="#">Mark Renewal</a>
                <a class="dropdown-item" href="#">Flag Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">View ANPR Record</a>
              </div>
            </div>
          </div>
        </td>';
        echo $table;
      }
    }
    public function get_exitFeed() {
      $campus = $this->user->userInfo('campus');
      $query = $this->dbc->dbc->prepare("SELECT * FROM veh_log WHERE veh_column = 3 AND campus = ?");
      $query->bindParam(1, $campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        //Determine Type & echo name type.
        if($result['veh_type'] == 1) {
          $result_type = "C/T";
        } else if($result['veh_type'] == 2) {
          $result_type = "CAB";
        } else if($result['veh_type'] == 3) {
          $result_type =  "TRL";
        } else if($result['veh_type'] == 4) {
          $result_type = "RIGID";
        } else if($result['veh_type'] == 5) {
          $result_type = "COACH";
        } else if($result['veh_type'] == 7) {
          $result_type = "CAR";
        } else if($result['veh_type'] == 8) {
          $result_type = "M/H";
        } else if($result['veh_type'] == 0) {
          $result_type = "N/A";
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$result_type.'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timeout'])).'</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Exit Vehicle</a>
                <a class="dropdown-item" href="#">Mark Renewal</a>
                <a class="dropdown-item" href="#">Flag Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">View ANPR Record</a>
              </div>
            </div>
          </div>
        </td>';
        echo $table;
      }
    }
    public function veh_exit($key) {
      $query = $this->dbc->dbc->prepare("UPDATE veh_log SET veh_column = 3, veh_timeout = ? WHERE id = ?");
      $query->bindParam(1, date("Y-m-d H:i:s"));
      $query->bindParam(2, $key);
      $query->execute();
    }
    public function vehicle_count_anor() {
      //Code
    }
    public function vehicle_count_paid() {
      $query = $this->dbc->dbc->prepare("SELECT * FROM veh_log WHERE veh_column < 3");
      $query->execute();
      return $query->rowCount();
    }
    public function vehicle_count_renewals() {
      $query = $this->dbc->dbc->prepare("SELECT * FROM veh_log WHERE veh_column = 2");
      $query->execute();
      return $query->rowCount();
    }
  }
 ?>
