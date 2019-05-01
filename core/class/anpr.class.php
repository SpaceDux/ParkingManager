<?php
  namespace ParkingManager;

  class ANPR
  {
    protected $mssql;
    protected $mysql;
    private $user;

    //Search ANPR records
    function ANPR_Search($key) {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
      if($this->user->userInfo("anpr") > 0) {
        $campus = $this->user->userInfo("campus");
        $string = '%'.$key.'%';
        $html = '';
        $this->mssql = new MSSQL;
        $stmt = $this->mssql->dbc->prepare("SELECT TOP 20 * FROM ANPR_REX WHERE Plate LIKE ? OR Original_Plate LIKE ? OR Uniqueref LIKE ? ORDER BY Capture_Date DESC");
        $stmt->bindParam(1, $string);
        $stmt->bindParam(2, $string);
        $stmt->bindParam(3, $string);
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
                  <th scope="col">Patch</th>
                </tr>
              </thead>
            ';
            $html .= '<tbody>';
            foreach($result as $row) {
              if($this->user->userInfo("campus") == 1) {
                $patch = str_replace("D:\ETP ANPR\images", $this->pm->PM_SiteInfo($campus, 'site_anpr_img'), $row['Patch']);
              } else if($this->user->userInfo("campus") == 2) {
                $patch = str_replace("D:\ETP ANPR\images", $this->pm->PM_SiteInfo($campus, 'site_anpr_img'), $row['Patch']);
              } else if ($this->user->userInfo("campus") == 0) {
                $patch = "";
              }
              $html .= '
                <tr>
                  <td>'.$row['Plate'].'</td>
                  <td>'.$row['Original_Plate'].'</td>
                  <td>'.date("d/m/y H:i", strtotime($row['Capture_Date'])).'</td>
                  <td>'.$row['Lane_Name'].'</td>
                  <td>'.date("d/m/y H:i", strtotime($row['Expiry'])).'</td>
                  <td><img src="'.$patch.'"></img></td>
                </tr>';
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
      $this->pm = null;
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
    function ANPR_Update_Save($key, $plate, $time, $trl) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Plate = ?, Capture_Date = ?, Notes = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, strtoupper($plate));
      $stmt->bindParam(2, $time);
      $stmt->bindParam(3, $trl);
      $stmt->bindParam(4, $key);
      $stmt->execute();

      $this->mssql = null;
    }
    //ANPR Add Vehicle
    function ANPR_AddPlate($plate, $time) {
      //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID, BarcodeExpression)
      $this->user = new User;
      $this->mssql = new MSSQL;

      $plate = strtoupper($plate);

      if($this->user->userInfo("campus") == 1) {
        if(!empty($plate)) {
          $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, null, 'RoadKing - Parc Cybi Holyhead', '0', null, '0', :plate2, null, null, :capDate2, null, '')");
          $stmt->bindParam(':plate', $plate);
          $stmt->bindParam(':capDate', $time);
          $stmt->bindParam(':plate2', $plate);
          $stmt->bindParam(':capDate2', $time);
          $stmt->execute();
        } else {
          die("Must contain a valid plate");
        }
      } else if($this->user->userInfo("campus") == 2) {
        if(!empty($plate)) {
          //Includes latest anpr update.
          $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, :createdDate, null, 'RoadKing - The New Hollies', '0', null, '0', :plate2, null, null, :capDate2, null, '', '', '')");
          $stmt->bindParam(':plate', $plate);
          $stmt->bindParam(':capDate', $time);
          $stmt->bindParam(':createdDate', $time);
          $stmt->bindParam(':plate2', $plate);
          $stmt->bindParam(':capDate2', $time);
          $stmt->execute();
        } else {
          die("Must contain a valid plate");
        }
      }


      $this->mssql = null;
      $this->user = null;
    }
    //Toggle Barrier
    function ToggleBarrier($key) {
      $this->user = new User;
      $this->pm = new PM;
      $site = $this->user->userInfo("campus");
      if($key == 1) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->pm->PM_SiteInfo($site, "site_barrier_in"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
      } else if ($key == 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->pm->PM_SiteInfo($site, "site_barrier_out"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
          echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
      }
      $this->user = null;
      $this->pm = null;
    }
    //Toggle Exit Barrier via keypad
    function Barrier_Controller($site, $barrier) {
      $this->pm = new PM;
      if($barrier == "EN") {
        $barrier = $this->pm->PM_SiteInfo($site, "site_barrier_in");
      } else if ($barrier == "EX") {
        $barrier = $this->pm->PM_SiteInfo($site, "site_barrier_out");
      }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $barrier);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);
      if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
      }
      curl_close($ch);
      $this->pm = null;
    }
    //ANPR Images
    function ANPR_GetImage($id) {
      global $_CONFIG;
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $stmt = $this->mssql->dbc->prepare("SELECT Patch, Overview FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $id);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if($this->user->userInfo("campus") == 1) {
        $patch = str_replace("D:\ETP ANPR\images", $this->pm->PM_SiteInfo("1", 'site_anpr_img'), $result['Patch']);
        $patch2 = str_replace("D:\ETP ANPR\images", $this->pm->PM_SiteInfo("1", 'site_anpr_img'), $result['Overview']);
      } else if($this->user->userInfo("campus") == 2) {
        $patch = str_replace("F:\ETP ANPR\images", $this->pm->PM_SiteInfo("2", 'site_anpr_img'), $result['Patch']);
        $patch2 = str_replace("F:\ETP ANPR\images", $this->pm->PM_SiteInfo("2", 'site_anpr_img'), $result['Overview']);
      } else if ($this->user->userInfo("campus") == 0) {
        $patch = "";
        $patch2 = "";
      }
      if($patch != null && $patch2 != null) {
        $html = '';
        $html = '<img src="'.$patch.'" alt="..." class="img-thumbnail">';
        $html .= '<img src="'.$patch2.'" alt="..." class="img-thumbnail">';
      } else {
        $html = "";
      }

      echo $html;

      $this->mssql = null;
      $this->user = null;
      $this->pm = null;
    }
    //Get ANPR rec
    function ANPR_GetRecord($key) {
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
    //Set Time
    function ANPR_Expiry_Set($key, $time) {
      $this->mssql = new MSSQL;

      $query = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Expiry = ? WHERE Uniqueref = ?");
      $query->bindParam(1, $time);
      $query->bindParam(2, $key);
      $query->execute();

      $this->mssql = null;
    }
    //ANPR Filter Search
    function ANPR_FilterSearch($key) {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      global $_CONFIG;
      $key = '%'.$key.'%';
      $this->user = new User;
      if($this->user->userInfo("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        $query = $this->mssql->dbc->prepare("SELECT TOP 5 * FROM ANPR_REX WHERE Plate LIKE ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
        $query->bindParam(1, $key);
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
        </thead>';

        foreach ($result as $row) {
          //Get The right Path now.
          if($this->user->userInfo("campus") == 1) {
            $patch = str_replace("D:\ETP ANPR\images", $this->pm->PM_SiteInfo(1, 'site_anpr_img'), $row['Patch']);
          } else if($this->user->userInfo("campus") == 2) {
            $patch = str_replace("F:\ETP ANPR\images", $this->pm->PM_SiteInfo(2, 'site_anpr_img'), $row['Patch']);
          } else if ($this->user->userInfo("campus") == 0) {
            $patch = "";
          }

          $number = $this->vehicles->findHour($row['Capture_Date'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          //Begin Table.
          $table .= '<tbody>';
          $table .= '<tr class="'.$style.'">';
          $table .= '<td>'.$row['Plate'].'</td>';
          $table .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
          $table .= '<td><img src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <a href="'.URL.'/new_transaction/'.$row['Uniqueref'].'" class="btn btn-danger"><i class="fa fa-pound-sign"></i></a>
                        <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
          $table .= '</tr>';

        }
        $table .= '</tbody></table>';
        echo $table;

        $this->mssql = null;
        $this->pm = null;
        $this->vehicles = null;
      } else if ($this->user->userInfo("anpr") == 0) {
        echo "ANPR is disabled for this user, please contact your manager.";
      }
      $this->user = null;
    }
  }

?>
