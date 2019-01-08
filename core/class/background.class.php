<?php
  namespace ParkingManager;

  class Background {
    private $mssql;
    private $mysql;
    private $pm;

    //Automated Exit
    function Automation_Exit() {
      $this->mssql = new MSSQL;
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      // $this->user = null;
      $expiry = date("Y-m-d H:i:s");

      $anpr = $this->mssql->dbc->prepare("SELECT TOP 30 * FROM ANPR_REX WHERE Lane_ID = 2 ORDER BY Capture_Date DESC");
      $anpr->execute();
      foreach ($anpr->fetchAll() as $row) {
        $plate = $row['Plate'];
        $anpr_key = $row['Uniqueref'];
        $date = $row['Capture_Date'];
        echo '<br>'.$plate;
        $parking = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_plate = ? AND parked_column = 1 AND parked_campus = ? ORDER BY parked_timein DESC");
        $parking->bindParam(1, $plate);
        $parking->bindParam(2, $campus);
        $parking->execute();
        $result = $parking->fetch(\PDO::FETCH_ASSOC);
        $time = $result['parked_expiry'];
        $id = $result['id'];
        $parked_expiry = date("Y-m-d H:i:s", strtotime($time.' +135 minutes'));
        if($parked_expiry >= $expiry) {
          $query = $this->mysql->dbc->prepare("SELECT * FROM pm_exit_log WHERE exit_anpr_key = ? AND exit_site = ?");
          $query->bindParam(1, $anpr_key);
          $query->bindParam(2, $campus);
          $query->execute();
          $count = $query->rowCount();
          if($count < 1) {
            $query = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_timeout = ?, parked_column = '2' WHERE id = ?");
            $query->bindParam(1, $expiry);
            $query->bindParam(2, $id);
            $query->execute();

            $query2 = $this->mysql->dbc->prepare("INSERT INTO pm_exit_log (exit_id, exit_time, exit_anpr_key, exit_site) VALUES (?, ?, ?, ?)");
            $query2->bindParam(1, $id);
            $query2->bindParam(2, $expiry);
            $query2->bindParam(3, $anpr_key);
            $query2->bindParam(4, $campus);
            $query2->execute();
            // if($query2->execute()) {
            //   $this->pm->PM_Notification_Create("ParkingManager has automatically EXIT the vehicle $plate");
            // }
          } else {
            //do nothing
          }
        } else {
          echo " FALSE ";
        }
      }
      $this->mssql = null;
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    //Keypad Exit
    
  }
?>
