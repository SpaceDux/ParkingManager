<?php
  namespace ParkingManager;

  class Vehicles
  {
    #Variables
    private $mysql;
    private $user;
    private $campus;
    private $mssql;
    private $anprCount;
    private $pm;

    //ANPR Feed
    public function get_anprFeed() {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      global $_CONFIG;
      $this->user = new User;
      if($this->user->userInfo("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->pm = new PM;
        $query = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status = 0 ORDER BY Capture_Date DESC");
        $query->execute();
        $result = $query->fetchAll();
        foreach ($result as $row) {
          //Get The right Path now.
          if($this->user->userInfo("campus") == 1) {
            $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $row['Patch']);
          } else if($this->user->userInfo("campus") == 2) {
            $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $row['Patch']);
          } else if ($this->user->userInfo("campus") == 0) {
            $patch = "";
          }
          $number = $this->pm->findHour($row['Capture_Date'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          //Begin Table.
          $table = '<tr class="'.$style.'">';
          $table .= '<td>'.$row['Plate'].'</td>';
          $table .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
          $table .= '<td><img src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" id="ANPR_Edit" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                        <a href="'.URL.'/new_transaction/'.$row['Uniqueref'].'" class="btn btn-danger"><i class="fa fa-pound-sign"></i></a>
                        <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
          $table .= '</tr>';

          echo $table;
        }
        $this->mssql = null;
        $this->pm = null;
      } else if ($this->user->userInfo("anpr") == 0) {
        //nothing yet.
      }
      $this->user = null;
    }
    //Paid Feed
    public function get_paidFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column = 1 AND campus = ? AND veh_deleted < 1");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        if($result['veh_flagged'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
        } else {
          $flag = '';
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$flag.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$this->Vehicle_Type_Info($result['veh_type'], "type_shortName").'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timein'])).'</td>';
        $table .= '<td>TICKET ID</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <a href="'.$_CONFIG['pm']['url']."/update/".$result['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
            <button type="button" class="btn btn-danger" onClick="exit('.$result['id'].')"><i class="fa fa-times"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a id="exit" class="dropdown-item" onClick="exit('.$result['id'].')" href="#">Exit Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onClick="markRenewal('.$result['id'].')" href="#">Mark Renewal</a>
                <a class="dropdown-item" onClick="setFlag('.$result['id'].')" href="#">Flag Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">View ANPR Record</a>
              </div>
            </div>
          </div>
        </td>';
        echo $table;
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Renewal Feed
    public function get_renewalFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column = 2 AND campus = ? AND veh_deleted < 1");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        if($result['veh_flagged'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
        } else {
          $flag = '';
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$flag.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$this->Vehicle_Type_Info($result['veh_type'], "type_shortName").'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timein'])).'</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
          <a href="'.$_CONFIG['pm']['url']."/update/".$result['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a id="exit" class="dropdown-item" onClick="exit('.$result['id'].')" href="#">Exit Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onClick="markRenewal('.$result['id'].')" href="#">Mark Renewal</a>
                <a class="dropdown-item" onClick="setFlag('.$result['id'].')" href="#">Flag Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">View ANPR Record</a>
              </div>
            </div>
          </div>
        </td>';
        echo $table;
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Exit Feed
    public function get_exitFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column = 3 AND campus = ? AND veh_deleted < 1 LIMIT 30");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
      foreach ($key as $result) {
        if($result['veh_flagged'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
        } else {
          $flag = '';
        }
        //Begin Table content
        $table = '<tr>';
        $table .= '<td>'.$flag.$result['veh_company'].'</td>';
        $table .= '<td>'.$result['veh_registration'].'</td>';
        $table .= '<td>'.$this->Vehicle_Type_Info($result['veh_type'], "type_shortName").'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['veh_timeout'])).'</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <a href="'.$_CONFIG['pm']['url']."/update/".$result['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
          </div>
        </td>';
        echo $table;
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Count ANPR
    public function vehicle_count_anpr() {
      $this->user = new User;
      if($this->user->userInfo("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->anprCount = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status = 0 ORDER BY Capture_Date DESC");
        $this->anprCount->execute();
        return count($this->anprCount->fetchAll());

        $this->mssql = null;
        $this->anprCount = null;
        $this->user = null;
      } else {
        return $this->anprCount = 0;
      }
    }
    //Count Paid
    public function vehicle_count_paid() {
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column < 3 AND campus = ? AND veh_deleted < 1");
      $query->bindParam(1, $this->campus);
      $query->execute();

      return $query->rowCount();

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Count Renewals
    public function vehicle_count_renewals() {
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column = 2 AND campus = ? AND veh_deleted < 1");
      $query->bindParam(1, $this->campus);
      $query->execute();
      return $query->rowCount();

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Yard Check list
    public function yardCheck() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_column < 3 AND campus = ? AND veh_deleted < 1");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        if($row['veh_flagged'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i>';
        } else {
          $flag = '';
        }
        $table = "<tr>";
        $table .= "<td>".$flag .$row['veh_company']."</td>";
        $table .= "<td>".$row['veh_registration']."</td>";
        $table .= "<td>".$this->Vehicle_Type_Info($result['veh_type'], "type_shortName")."</td>";
        $table .= '<td>'.date("d/H:i", strtotime($row['veh_timein'])).'</td>';
        $table .= "<td>MOST RECENT TICKET</td>";
        $table .= '<td><input style="height: 30px;width: 30px; line-height: 30px;" type="checkbox">
          <div class="btn-group" role="group" aria-label="Options">
            <a target="_blank" href="'.$_CONFIG['pm']['url']."/update/".$row['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Exit Vehicle</a>
                <div class="dropdown-divider"></div>
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
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Vehicle Info query
    public function vehInfo($what, $id) {
      //Prep Class'
      $this->mysql = new MySQL;
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];

      $this->mysql = null;
    }
    //Get Vehicle via id
    public function getVehicle($key) {
      global $_CONFIG;
      //Prep Class'
      $this->mysql = new MySQL;
      //Query
      if(isset($key)) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
        $this->mysql = null;
      } else {
        //If they visit "update.php" without a vehicle ID, return to dashboard
        header("Location: ".$_CONFIG['pm']['url']."/main");
      }
    }
    //Get ANPR rec
    public function getANPR_Record($key) {
      global $_CONFIG;
      //Prep Class'
      $this->mssql = new MSSQL;
      //Query
      if(isset($key)) {
        $query = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
        $query->bindParam(1, $key);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
        $this->mssql = null;
      } else {
        header("Location: ".$_CONFIG['pm']['url']."/main");
      }
    }
    //Time Calculation, displays in a msg
    public function timeCalc($time1, $time2) {
      try {
        if(isset($time1)) {
          $d1 = new \DateTime($time1);
          $d2 = new \DateTime($time2);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);
          echo "Parked for <b>".$h."</b> hours and <b>".$int->format('%i')."</b> minutes";
        }
      } catch (\Exception $e) {
        echo "<red>Time Construction error, please check & correct</red>";
      }
    }
    //Ajax Request Exit Vehicle (SENT VIA Ajax Handler)
    function Vehicle_Exit($key) {
      //Prep Class
      $this->mysql = new MySQL;
      //Query
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_column = '3', veh_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      $stmt->execute();
      $this->mysql = null;
    }
    //Ajax Request Mark Renewal
    function Vehicle_MarkRenewal($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $renewalResult = $this->vehicle->vehInfo("veh_column", $key);
      if($renewalResult == 1) {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_column = '2' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_column = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax setFlag
    function Vehicle_Flag($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $flagResult = $this->vehicle->vehInfo("veh_flagged", $key);
      if($flagResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_flagged = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_flagged = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax deleteVehicle
    function Vehicle_Delete($key) {
      //Prep class;
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $deleteResult = $this->vehicle->vehInfo("veh_deleted", $key);
      if($deleteResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_deleted = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_deleted = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Update vehicle record
    public function updateVehicle($key) {
      global $_CONFIG;
      // Prep Class'
      $this->mysql = new MySQL;
      //Query
      if(isset($_POST['upd_reg'])) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_parkedlog SET veh_registration = ?, veh_company = ?, veh_trlno = ?, veh_type = ?, veh_timein = ?, veh_timeout = ?, veh_column = ?, veh_comment = ? WHERE id = ?");
        $query->bindParam(1, strtoupper($_POST['upd_reg']));
        $query->bindParam(2, strtoupper($_POST['upd_company']));
        $query->bindParam(3, strtoupper($_POST['upd_trl']));
        $query->bindParam(4, $_POST['upd_type']);
        $query->bindParam(5, $_POST['upd_timein']);
        $query->bindParam(6, $_POST['upd_timeout']);
        $query->bindParam(7, $_POST['upd_col']);
        $query->bindParam(8, $_POST['upd_comment']);
        $query->bindParam(9, $key);
        if($query->execute()) {
          //Return refreshed state
          header("Location: ".$_CONFIG['pm']['url']."/update/".$key);
          $this->mysql = null;
        }
      } else {
        //Do nothing
      }
      $this->mysql = null;
    }
    function Vehicle_Type_Info($id, $what) {
      $this->mysql = new MySQL;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types WHERE id = ?");
      $stmt->bindParam(1, $id);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //check if flagged
    public function isFlagged($key) {
      if($key == 1) {
        echo '<div class="alert alert-warning" role="alert"><i class="fa fa-flag"></i> This vehicle appears to be <b>flagged</b>, please see Comment\'s / Notes</div>';
      }
    }
    //Check if deleted
    public function isDeleted($key) {
      if($key == 1) {
        echo '<div class="alert alert-danger" role="alert"><i class="fa fa-times"></i> This vehicle has been <b>deleted</b></div>';
      }
    }
  }
 ?>
