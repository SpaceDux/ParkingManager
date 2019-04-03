<?php
  namespace ParkingManager;
  class Kiosk {
    //Return the Parking Page with relevant forms
    function Kiosk_Search($Plate) {
      $this->mssql = new MSSQL;
      $this->mysql = new MySQL;

      $mssql = $this->mssql->dbc->prepare("SELECT TOP 1 * FROM ANPR_REX WHERE Plate = ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
      $mssql->bindParam(1, $Plate);
      $mssql->execute();
      $result = $mssql->fetchAll();
      $count = count($result);
      if($count > 0) {
        foreach($result as $result) {
          $return = array (
            "Type" => "ANPR",
            "Uniqueref" => $result['Uniqueref'],
            "Plate" => $result['Plate']
          );
          echo json_encode($return);
        }
      } else {
        $mysql = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_plate = ? AND parked_column < 2 AND parked_deleted < 1 ORDER BY parked_timein DESC");
        $mysql->bindParam(1, $Plate);
        $mysql->execute();
        $result = $mysql->fetchAll();
        $count = count($result);
        if($count > 0) {
          foreach($result as $result) {
            $return = array (
              "Type" => "PM",
              "Uniqueref" => $result['id'],
              "Plate" => $result['parked_plate']
            );
            echo json_encode($return);
          }
        } else {
          echo "FALSE";
        }
      }

      $this->anpr = null;
      $this->vehicles = null;
    }
  }
?>
