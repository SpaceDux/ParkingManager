<?php
  namespace ParkingManager;

  class Vehicles
  {
    protected $mysql;

    //Add vehicles to your account
    function Vehicles_AddPlate($Plate, $Name)
    {
      $this->mysql = new MySQL;

      $Date = date("Y-m-d H:i:s");
      $Ref = mt_rand(1111, 9999).date("YmdHis").mt_rand(1111, 9999);
      $Plate = strtoupper($Plate);
      $Plate = str_replace(" ", "", $Plate);
      $Plate = str_replace("-", "", $Plate);

      if(!empty($Plate) AND !empty($Name)) {
        $stmt = $this->mysql->dbc->prepare("SELECT Uniqueref FROM vehicles WHERE Plate = ? AND Owner = ? AND Status < 1");
        $stmt->bindParam(1, $Plate);
        $stmt->bindValue(2, $_SESSION['ID']);
        $stmt->execute();
        if($stmt->rowCount() < 1) {
          $stmt = $this->mysql->dbc->prepare("INSERT INTO vehicles VALUES('', ?, ?, ?, '', ?, ?, ?, '0')");
          $stmt->bindParam(1, $Ref);
          $stmt->bindParam(2, $Plate);
          $stmt->bindParam(3, $Name);
          $stmt->bindParam(4, $Date);
          $stmt->bindParam(5, $Date);
          $stmt->bindValue(6, $_SESSION['ID']);
          if($stmt->execute()) {
            echo json_encode(array('Result' => 1, 'Message' => 'Plate added to your account.'));
          }
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'This plate is already assigned to your account.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please supply all required fields.'));
      }

      $this->mysql = null;
    }
    // Display active plates in a table via user update
    function Vehicles_MyPlatesAsTbl()
    {
      $this->mysql = new MySQL;

      $html = '<table class="table table-hover table-bordered table-dark">
                <thead>
                  <th>Name</th>
                  <th>Plate</th>
                  <th><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>';

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM vehicles WHERE Owner = ? AND Status < 1");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        foreach($result as $row) {
          $Ref = '\''.$row['Uniqueref'].'\'';
          $html .= '<tr>';
          $html .= '<td>'.$row['Name'].'</td>';
          $html .= '<td>'.$row['Plate'].'</td>';
          $html .= '<td><button class="btn btn-danger" onClick="Vehicles_DeletePlate('.$Ref.')"><i class="fa fa-trash"></i></button></td>';
          $html .= '</tr>';
        }
      } else {
        $html .= '<tr>';
        $html .= '<td colspan="3">No plates found.</td>';
        $html .= '</tr>';
      }

      echo json_encode($html);

      $this->mysql = null;
    }
    // Delete vehicle from my account
    function Vehicles_DeletePlate($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE vehicles SET Status = '1' WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        echo json_encode(array('Result' => 1, 'Message' => 'Plate has been removed from your account.'));
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Plate could not be removed from your account.'));
      }

      $this->mysql = null;
    }
    // Vehicle dropdown selection
    function Vehicles_DropdownOpts()
    {
      $this->mysql = new MySQL;
      $html = '';
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM vehicles WHERE Status = 0 AND Owner = ?");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        foreach($stmt->fetchAll() as $row) {
          $html .= '<option value="'.$row['Uniqueref'].'">'.$row['Plate'].' - '.$row['Name'].'</option>';
        }
      } else {
        $html .= '<option value="0">YOU HAVE NO VEHICLES</option>';
      }

      return $html;

      $this->mysql = null;
    }
    // Vehicle Info
    function Vehicles_Info($Ref, $What)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM vehicles WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res[$What];
      }

      $this->mysql = null;
    }
  }

?>
