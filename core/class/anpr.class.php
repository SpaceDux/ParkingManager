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
                  <th scope="col">Patch</th>
                </tr>
              </thead>
            ';
            $html .= '<tbody>';
            foreach($result as $row) {
              if($this->user->userInfo("campus") == 1) {
                $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $row['Patch']);
              } else if($this->user->userInfo("campus") == 2) {
                $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $row['Patch']);
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
      //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID, BarcodeExpression)
      $this->mssql = new MSSQL;

      $plate = strtoupper($plate);

      $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, null, 'RoadKing - Parc Cybi Holyhead', '0', null, '0', :plate2, null, null, :capDate2, null, '')");
      $stmt->bindParam(':plate', $plate);
      $stmt->bindParam(':capDate', $time);
      $stmt->bindParam(':plate2', $plate);
      $stmt->bindParam(':capDate2', $time);
      $stmt->execute();

      $this->mssql = null;
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
    function ANPR_GetImage($id) {
      global $_CONFIG;
      $this->mssql = new MSSQL;
      $this->user = new User;

      $stmt = $this->mssql->dbc->prepare("SELECT Patch, Overview FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $id);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if($this->user->userInfo("campus") == 1) {
        $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $result['Patch']);
        $patch2 = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_holyhead']['imgdir'], $result['Overview']);
      } else if($this->user->userInfo("campus") == 2) {
        $patch = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $result['Patch']);
        $patch2 = str_replace("D:\ETP ANPR\images", $_CONFIG['anpr_cannock']['imgdir'], $result['Overview']);
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
    }
    //Get ANPR rec
    function getANPR_Record($key) {
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
  }

?>
