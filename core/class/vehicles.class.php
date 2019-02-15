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
    protected $background;

    //ANPR Feed
    function get_anprFeed() {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      global $_CONFIG;
      $this->user = new User;
      if($this->user->userInfo("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->pm = new PM;
        $query = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
        $query->execute();
        $result = $query->fetchAll();
        $table = '<table class="table table-dark table-bordered table-hover">
        <thead>
          <tr>
            <th scope="col">Registration</th>
            <th scope="col">Time IN</th>
            <th scope="col">Patch</th>
            <th scope="col"><i class="fa fa-cog"></i></th>
          </tr>
          </thead>
        <tbody>';
        foreach ($result as $row) {
          //Get The right Path now.
          if($this->user->userInfo("campus") == 1) {
            $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $row['Patch']);
          } else if($this->user->userInfo("campus") == 2) {
            $patch = str_replace("F:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $row['Patch']);
          } else if ($this->user->userInfo("campus") == 0) {
            $patch = "";
          }
          $number = $this->findHour($row['Capture_Date'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          //Begin Table.
          $table .= '<tr class="'.$style.'">';
          $table .= '<td>'.$row['Plate'].'</td>';
          $table .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
          $table .= '<td><img style="max-width: 140px; max-height: 50px;" src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" id="ANPR_Edit" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                        <a href="'.URL.'/new_transaction/'.$row['Uniqueref'].'" class="btn btn-danger"><i class="fa fa-pound-sign"></i></a>
                        <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
          $table .= '</tr>';
        }
        $table .= '</tbody>
                </table>';

        echo $table;

        $this->mssql = null;
        $this->pm = null;
      } else if ($this->user->userInfo("anpr") == 0) {
        //nothing yet.
      }
      $this->user = null;
    }
    //Paid Feed
    function get_paidFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->payment = new Payment;

      $current_timestamp = date("Y-m-d H:i:s");
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column = 1 AND parked_campus = ? AND parked_deleted < 1 ORDER BY parked_expiry ASC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
        $table = '<table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">Company</th>
                          <th scope="col">Registration</th>
                          <th scope="col">Type</th>
                          <th scope="col">Time IN</th>
                          <th scope="col float"><i class="fa fa-cog"></i></th>
                        </tr>
                      </thead>
                      <tbody>';
        foreach ($key as $result) {
          if($result['parked_flag'] == 1) {
            $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
          } else {
            $flag = '';
          }
          if($result['parked_expiry'] > $current_timestamp) {
            //Begin Table content
            $table .= '<tr>';
            $table .= '<td>'.$flag.$result['parked_company'].'</td>';
            $table .= '<td>'.$result['parked_plate'].'</td>';
            $table .= '<td>'.$this->Vehicle_Type_Info($result['parked_type'], "type_shortName").'</td>';
            $table .= '<td>'.date("d/H:i", strtotime($result['parked_timein'])).'</td>';
            $table .= '<td>'.$this->payment->PaymentInfo($result['payment_ref'], "id").'</td>';
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
                    <a class="dropdown-item" onClick="setFlag('.$result['id'].')" href="#">Flag Vehicle</a>
                  </div>
                </div>
              </div>
            </td>';
        }
      }
      $table .= '  </tbody>
      </table>';
      echo $table;
      $this->mysql = null;
      $this->user = null;
      $this->payment = null;
      $this->campus = null;
    }
    //Renewal Feed
    function get_renewalFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      $current_timestamp = date("Y-m-d H:i:s");
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column = 1 AND parked_campus = ? AND parked_deleted < 1 ORDER BY parked_expiry ASC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
      $table = '<table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Company</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Type</th>
                        <th scope="col">Time IN</th>
                        <th scope="col"><i class="fa fa-cog"></i></th>
                      </tr>
                    </thead>
                    <tbody>';
      foreach ($key as $result) {
        $number = $this->findHour($result['parked_expiry'], "");
        $style = "";
        if($number >= 2 && $number < 4) {
          $style = "table-warning";
        } else if ($number >= 4) {
          $style = "table-danger";
        }
        if($result['parked_flag'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
        } else {
          $flag = '';
        }
        //Begin Table content
        $table .= '<tr class="'.$style.'">';
        $table .= '<td>'.$flag.$result['parked_company'].'</td>';
        $table .= '<td>'.$result['parked_plate'].'</td>';
        $table .= '<td>'.$this->Vehicle_Type_Info($result['parked_type'], "type_shortName").'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['parked_timein'])).'</td>';
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
          <a href="'.$_CONFIG['pm']['url']."/update/".$result['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
          <a href="'.$_CONFIG['pm']['url']."/transaction/".$result['id'].'" class="btn btn-danger"><i class="fa fa-pound-sign"></i></a>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a id="exit" class="dropdown-item" onClick="exit('.$result['id'].')" href="#">Exit Vehicle</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onClick="setFlag('.$result['id'].')" href="#">Flag Vehicle</a>
              </div>
            </div>
          </div>
        </td>';
      }
      $table .= '   </tbody>
                  </table>';

      echo $table;
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Exit Feed
    function get_exitFeed() {
      global $_CONFIG;
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column = 2 AND parked_campus = ? AND parked_deleted < 1 ORDER BY parked_timeout DESC LIMIT 40");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $key = $query->fetchAll();
      $table = '<table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Company</th>
                      <th scope="col">Registration</th>
                      <th scope="col">Type</th>
                      <th scope="col">Time OUT</th>
                      <th scope="col"><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>';
      foreach ($key as $result) {
        if($result['parked_flag'] == 1) {
          $flag = '<i class="fa fa-flag" style="color: red;"></i> ';
        } else {
          $flag = '';
        }
        //Begin Table content
        $table .= '<tr>';
        $table .= '<td>'.$flag.$result['parked_company'].'</td>';
        $table .= '<td>'.$result['parked_plate'].'</td>';
        $table .= '<td>'.$this->Vehicle_Type_Info($result['parked_type'], "type_shortName").'</td>';
        $table .= '<td>'.date("d/H:i", strtotime($result['parked_timeout'])).'</td>';
        $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <a href="'.$_CONFIG['pm']['url']."/update/".$result['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
                      </div>
                    </td></tr>';
      }
      $table .= '</tbody>
              </table>';

      echo $table;
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Count ANPR
    function vehicle_count_anpr() {
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
    function vehicle_count_paid() {
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column < 2 AND parked_campus = ? AND parked_deleted < 1 AND parked_expiry > CURRENT_TIMESTAMP");
      $query->bindParam(1, $this->campus);
      $query->execute();

      return $query->rowCount();

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Count Renewals
    function vehicle_count_renewals() {
      //Prepare Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      //Set Campus.
      $this->campus = $this->user->userInfo('campus');
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column = 1 AND parked_campus = ? AND parked_deleted < 1 AND parked_expiry < CURRENT_TIMESTAMP");
      $query->bindParam(1, $this->campus);
      $query->execute();
      return $query->rowCount();

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Vehicle Info query
    function vehInfo($what, $id) {
      //Prep Class'
      $this->mysql = new MySQL;
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE id = ? OR parked_anprkey = ?");
      $query->bindParam(1, $id);
      $query->bindParam(2, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];

      $this->mysql = null;
    }
    //Get Vehicle via id
    function getVehicle($key) {
      global $_CONFIG;
      //Prep Class'
      $this->mysql = new MySQL;
      //Query
      if(isset($key)) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
        $this->mysql = null;
      } else {
        //If they visit "update.php" without a vehicle ID, return to dashboard
        header("Location: ".$_CONFIG['pm']['url']."/main");
      }
    }
    //Time Calculation, displays in a msg
    function timeCalc($time1, $time2) {
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
      $this->pm = new PM;
      $this->user = new User;

      $vehicle = $this->vehInfo("parked_plate", $key);
      $name = $this->user->userInfo("first_name");

      //Query
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_column = '2', parked_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      if($stmt->execute()) {
        $this->pm->PM_Notification_Create("$vehicle has been successfully marked EXIT by $name", "0");
        echo "DONE";
      } else {
        echo "NEY";
      }

      $this->mysql = null;
      $this->pm = null;
      $this->user = null;
    }
    //Ajax setFlag
    function Vehicle_Flag($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $flagResult = $this->vehicle->vehInfo("parked_flag", $key);
      if($flagResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_flag = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_flag = '0' WHERE id = :id");
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
      $deleteResult = $this->vehicle->vehInfo("parked_deleted", $key);
      if($deleteResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_deleted = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_deleted = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Update vehicle record
    function updateVehicle($key) {
      global $_CONFIG;
      // Prep Class'
      $this->mysql = new MySQL;
      //Query
      if(isset($_POST['upd_reg'])) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_plate = ?, parked_company = ?, parked_trailer = ?, parked_type = ?, parked_timein = ?, parked_timeout = ?, parked_column = ?, parked_comment = ? WHERE id = ?");
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
    //Vehicle Type info
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
    function isFlagged($key) {
      if($key == 1) {
        echo '<div class="alert alert-warning" role="alert"><i class="fa fa-flag"></i> This vehicle appears to be <b>flagged</b>, please see Comment\'s / Notes</div>';
      }
    }
    //Check if deleted
    function isDeleted($key) {
      if($key == 1) {
        echo '<div class="alert alert-danger" role="alert"><i class="fa fa-times"></i> This vehicle has been <b>deleted</b></div>';
      }
    }
    //Return timecalc hour only
    function findHour($time1, $time2) {
      if(isset($time1)) {
        $d1 = new \DateTime($time1);
        $d2 = new \DateTime($time2);
        $int = $d2->diff($d1);
        $h = $int->h;
        $h = $h + ($int->days*24);
        return $h;
      } else {
        echo "ERROR!";
      }
    }
    //Yard Check
    function yardCheck() {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");
      $html = "";

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_column < 2 AND parked_deleted < 1 AND parked_campus = ? ORDER BY parked_expiry ASC");
      $query->bindParam(1, $campus);
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['parked_company'].'</td>';
        $html .= '<td>'.$row['parked_plate'].'</td>';
        $html .= '<td>'.$this->Vehicle_Type_Info($row['parked_type'], "type_shortName").'</td>';
        $html .= '<td>'.$row['parked_trailer'].'</td>';
        $html .= '<td>'.date("d/H:s", strtotime($row['parked_timein'])).'</td>';
        $html .= '<td>'.date("d/H:s", strtotime($row['parked_expiry'])).'</td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-danger" onClick="exit('.$row['id'].')"><i class="fa fa-times"></i></button>
                    <a target="_blank" href="'.URL."/update/".$row['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>

                  </div>
                  <input type="checkbox" style="-ms-transform: scale(4); /* IE */-moz-transform: scale(4); /* FF */-webkit-transform: scale(4); /* Safari and Chrome */-o-transform: scale(4); /* Opera */ margin-left: 25px">
                  </td>';
        $html .= '</tr>';
      }
      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Yard Check ANPR
    function yardCheckANPR() {
      global $_CONFIG;
      $this->mssql = new MSSQL;
      $this->user = new User;
      $html = "";

      $query = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
      $query->execute();
      $result = $query->fetchAll();


      foreach ($result as $row) {
        //Get The right Path now.
        if($this->user->userInfo("campus") == 1) {
          $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $row['Patch']);
        } else if($this->user->userInfo("campus") == 2) {
          $patch = str_replace("F:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $row['Patch']);
        } else if ($this->user->userInfo("campus") == 0) {
          $patch = "";
        }
        $html .= '<tr>';
        $html .= '<td>'.$row['Plate'].'</td>';
        $html .= '<td>'.date("d/H:s", strtotime($row['Capture_Date'])).'</td>';
        $html .= '<td><img src="'.$patch.'"></img></td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" id="ANPR_Edit" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                    <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                  </div>
                  <input type="checkbox" style="-ms-transform: scale(4); /* IE */-moz-transform: scale(4); /* FF */-webkit-transform: scale(4); /* Safari and Chrome */-o-transform: scale(4); /* Opera */ margin-left: 25px">
                  </td>';
        $html .= '</tr>';
      }
      echo $html;

      $this->mssql = null;
      $this->user = null;
    }
    //Set Expiry after Payment
    function Parking_Log_Expiry_Update($key, $time) {
      $this->mysql = new MySQL;
      $sql_parkedLog = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_expiry = ? WHERE payment_ref = ?");
      $sql_parkedLog->bindParam(1, $time);
      $sql_parkedLog->bindParam(2, $key);
      $sql_parkedLog->execute();
      $this->mysql = null;
    }
    //Set new Veh Type
    function Vehicle_Update_Type($id, $type) {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_type = ? WHERE id = ?");
      $stmt->bindParam(1, $type);
      $stmt->bindParam(2, $id);
      $stmt->execute();

      $this->mysql = null;
    }
    //Check duplicate
    function Vehicle_IsDup($plate) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_plate = ? AND parked_column = 1 AND parked_deleted = 0 AND parked_campus = ? ORDER BY id DESC LIMIT 1");
      $stmt->bindParam(1, $plate);
      $stmt->bindParam(2, $campus);
      $stmt->execute();
      $res = $stmt->fetchAll();

      if(count($res) > 0) {
        return TRUE;
      } else {
        return FALSE;
      }

      $this->mysql = null;
      $this->user = null;
    }
    //Add new Parking Record
    function Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey) {
      $this->mysql = new MySQL;
      //SQL for Parking Log 15
      $Trailer = strtoupper($Trailer);
      $sql_parkedLog = $this->mysql->dbc->prepare("INSERT INTO pm_parking_log (parked_anprkey, payment_ref, parked_plate, parked_trailer, parked_type, parked_company, parked_column, parked_timein, parked_timeout, parked_expiry, parked_flag, parked_deleted, parked_account_id, parked_author, parked_campus, parked_comment, parked_exitKey) VALUES (:ANPRKey, :PayRef, :Plate, :Trailer, :Vehicle_Type, :Company, '1', :TimeIN, '', :Expiry, '0', '0', null, :Name, :Campus, '', :ExitKey)");
      $sql_parkedLog->bindParam(':ANPRKey', $ANPRKey);
      $sql_parkedLog->bindParam(':PayRef', $ref);
      $sql_parkedLog->bindParam(':Plate', $Plate);
      $sql_parkedLog->bindParam(':Trailer', $Trailer);
      $sql_parkedLog->bindParam(':Vehicle_Type', $Vehicle_Type);
      $sql_parkedLog->bindParam(':Company', $Company);
      $sql_parkedLog->bindParam(':TimeIN', $ANPR_Date);
      $sql_parkedLog->bindParam(':Expiry', $expiry);
      $sql_parkedLog->bindParam(':Name', $name);
      $sql_parkedLog->bindParam(':Campus', $campus);
      $sql_parkedLog->bindParam(':ExitKey', $exitKey);
      $sql_parkedLog->execute();

      $this->mysql = null;
    }
  }
 ?>
