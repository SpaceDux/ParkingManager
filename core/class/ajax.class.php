<?php
  namespace ParkingManager;

  class AJAX
  {
    #Variables
    protected $mysql;
    private $vehicle;
    private $user;
    protected $mssql;
    //Ajax Request Exit Vehicle (SENT VIA Ajax Handler)
    function exitVehicle($key) {
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
    function markRenewal($key) {
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
    function setFlag($key) {
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
    function deleteVehicle($key) {
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
    //Delete Notice
    function deleteNotice($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM notices WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $this->mysql = null;
    }
    //Search ANPR
    function ANPR_Search($key) {
      $this->user = new User;
      if($this->user->userInfo("anpr") > 0) {
        $string = '%'.$key.'%';
        $html = '';
        $this->mssql = new MSSQL;
        $stmt = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Plate LIKE ? OR Original_Plate LIKE ? ORDER BY Capture_Date DESC");
        $stmt->bindParam(1, $string);
        $stmt->bindParam(2, $string);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(count($result) > 0) {
          $html .= '
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Plate</th>
                  <th scope="col">Original Plate</th>
                  <th scope="col">Capture Date</th>
                  <th scope="col">Lane Name</th>
                  <th scope="col">Expiry</th>
                </tr>
              </thead>
            ';
            $html .= '<tbody>';
            foreach($result as $row) {
              $html .= '
                <tr>
                  <td>'.$row['Plate'].'</td>
                  <td>'.$row['Original_Plate'].'</td>
                  <td>'.$row['Capture_Date'].'</td>
                  <td>'.$row['Lane_Name'].'</td>
                  <td>'.$row['Expiry'].'</td>
                </tr>
              ';
            }
            $html .= '</tbody></table>';
            echo $html;
        } else {
            echo 'No Data Found';
        }
      } else {
        echo 'ANPR is disabled';
      }
      $this->user = null;
      $this->mssql = null;
    }
    //Search PM Logs
    function PM_Search($key) {
      $string = '%'.$key.'%';
      $html = '';
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->campus = $this->user->userInfo("campus");
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_parkedlog WHERE veh_registration LIKE ? OR veh_trlno LIKE ? AND campus = ? ORDER BY veh_timein DESC LIMIT 200");
      $stmt->bindParam(1, $string);
      $stmt->bindParam(2, $string);
      $stmt->bindParam(3, $this->campus);
      $stmt->execute();
      $result = $stmt->fetchAll();

      if(count($result) > 0) {
        $html .= '
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Company</th>
                <th scope="col">Registration</th>
                <th scope="col">Trailer Number</th>
                <th scope="col">Time IN</th>
                <th scope="col">Expiry</th>
              </tr>
            </thead>
          ';
          $html .= '<tbody>';
          foreach($result as $row) {
            $html .= '
              <tr>
                <td>'.$row['veh_company'].'</td>
                <td>'.$row['veh_registration'].'</td>
                <td>'.$row['veh_trlno'].'</td>
                <td>'.$row['veh_timein'].'</td>
                <td>'.$row['veh_expires'].'</td>
              </tr>
            ';
          }
          $html .= '</tbody></table>';
          echo $html;
      } else {
          echo 'No Data Found';
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Delete ANPR (Duplicate)
    function ANPR_Duplicate($key) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 11 WHERE Uniqueref = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();

      $this->mssql = null;
    }
    //ANPR Get Details for update
    function ANPR_Update_Get($key) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      echo json_encode($result);

      $this->mssql = null;
    }
    //ANPR Update Details
    function ANPR_Update($key, $plate, $time) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Plate = ?, Capture_Date = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, strtoupper($plate));
      $stmt->bindParam(2, $time);
      $stmt->bindParam(3, $key);
      $stmt->execute();

      $this->mssql = null;
    }
    //ANPR Add Vehicle
    function ANPR_Add($plate, $time) {
      //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID)
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, null, '5858', '0', null, '0', :plate2, null, null, :capDate2, null, '')");
      $stmt->bindParam(':plate', strtoupper($plate));
      $stmt->bindParam(':capDate', $time);
      $stmt->bindParam(':plate2', strtoupper($plate));
      $stmt->bindParam(':capDate2', $time);
      $stmt->execute();

      $this->mssql = null;
    }
    //ANPR Get Images
    function ANPR_Image_Get($key) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();
      $return = $stmt->fetchAll();

      $html = '<img src="'.$return['Patch'].'" alt="..." class="img-thumbnail">';
    }
    //Toggle Barrier
    function ToggleBarrier($key) {
      global $_CONFIG;
      if($key == 1) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_CONFIG['gate_holyhead']['in']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
      } else if ($key == 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_CONFIG['gate_holyhead']['out']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
      }
    }
    //Update User GET
    function Update_User_Get($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);
      $this->mysql = null;
    }
    //Update User Details
    function Update_User($id, $first_name, $last_name, $email, $campus, $anpr, $rank) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("UPDATE pm_users SET first_name = ?, last_name = ?, email = ?, campus = ?, anpr = ?, rank = ? WHERE id = ?");
      $query->bindParam(1, $first_name);
      $query->bindParam(2, $last_name);
      $query->bindParam(3, $email);
      $query->bindParam(4, $campus);
      $query->bindParam(5, $anpr);
      $query->bindParam(6, $rank);
      $query->bindParam(7, $id);
      $query->execute();

      $this->mysql = null;
    }
    //Register User
    function Register_User($first_name, $last_name, $email, $password, $campus, $anpr, $rank) {
      $this->mysql = new MySQL;
      if(isset($password)) {
          $query = $this->mysql->dbc->prepare("INSERT INTO pm_users (id, first_name, last_name, email, password, seckey, anpr, rank, campus, active, last_log) VALUES ('', ?, ?, ?, ?, null, ?, ?, ?, '0', ?)");
          $query->bindParam(1, $first_name);
          $query->bindParam(2, $last_name);
          $query->bindParam(3, $email);
          $query->bindParam(4, password_hash($password, PASSWORD_BCRYPT));
          $query->bindParam(5, $campus);
          $query->bindParam(6, $anpr);
          $query->bindParam(7, $rank);
          $query->bindParam(8, date("Y-m-d H:i:s"));
          $query->execute();
      } else {

        }
      $this->mysql = null;
    }
    //User delete
    function User_Delete($id) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM pm_users WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();

      $this->mysql = null;
    }
    //Force Logout
    function adminLogout($id) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();

      $this->mysql = null;
    }
  }
?>
