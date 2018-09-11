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
    public function exitVehicle($key) {
      //Prep Class
      $this->mysql = new MySQL;
      //Query
      $date = date('Y-m-d H:i:s');
      $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '3', veh_timeout = :timeout WHERE id = :id");
      $stmt->bindParam(':timeout', $date);
      $stmt->bindParam(':id', $key);
      $stmt->execute();
      $this->mysql = null;
    }
    //Ajax Request Mark Renewal
    public function markRenewal($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $renewalResult = $this->vehicle->vehInfo("veh_column", $key);
      if($renewalResult == 1) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '2' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_column = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax setFlag
    public function setFlag($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $flagResult = $this->vehicle->vehInfo("veh_flagged", $key);
      if($flagResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_flagged = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_flagged = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Ajax deleteVehicle
    public function deleteVehicle($key) {
      //Prep class;
      $this->mysql = new MySQL;
      $this->vehicle = new Vehicles;
      //Query
      $deleteResult = $this->vehicle->vehInfo("veh_deleted", $key);
      if($deleteResult == 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_deleted = '1' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE veh_log SET veh_deleted = '0' WHERE id = :id");
        $stmt->bindParam(':id', $key);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->vehicle = null;
    }
    //Delete Notice
    public function deleteNotice($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM notices WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $this->mysql = null;
    }
    //Search MSSQL (Unfinished)
    public function searchMSSQL($key) {
      $html = "";
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Plate LIKE ? OR Original_Plate LIKE ? ORDER BY Capture_Date DESC");
      $stmt->bindParam(1, '%'.$key.'%');
      $stmt->bindParam(2, '%'.$key.'%');
      $stmt->execute();
      $result = $stmt->fetchAll();

      if($result->rowCount() > 0) {
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
          $html .= "<tbody>";
          foreach ($result as $row) {
            $html .= "<tr>";
            $html .= "<td>".$row['Plate']."</td>";
            $html .= "<td>".$row['Original_Plate']."</td>";
            $html .= "<td>".$row['Capture_Date']."</td>";
            $html .= "<td>".$row['Lane_Name']."</td>";
            $html .= "<td>".$row['Expiry']."</td>";
            $html .= "</tr>";
          }
          $html .= "</tbody></table>";
          echo $html;
      } else {
        $html = 'No Data Found';
      }
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
    function ANPR_Update_Get($key) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      echo json_encode($result);

      $this->mssql = null;
    }
    function ANPR_Update($key, $plate, $time) {
      $this->mssql = new MSSQL;
      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Plate = ? AND Capture_Date = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, strtoupper($plate));
      $stmt->bindParam(2, $time);
      $stmt->bindParam(3, $key);
      $stmt->execute();

      $this->mssql = null;
    }

  }
?>
