<?php
  namespace ParkingManager;

  class Background {
    private $mssql;
    private $mysql;

    function Automation_Exit()
    {
      $this->mssql = new MSSQL;
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $anpr = $this->mssql->dbc->prepare("SELECT TOP 5 * FROM ANPR_REX WHERE Direction_Travel = 1 AND Lane_ID = 2 ORDER BY Capture_Date DESC");
      $anpr->execute();
      $anpr_result = $anpr->fetchAll();
      foreach ($anpr_result as $row) {
        $plate = $row['Plate'];
        $anpr_key = $row['Uniqueref'];

        $pm_log = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_plate = ? AND parked_column = 1 AND parked_campus = ? AND parked_expiry > CURRENT_TIMESTAMP ORDER BY parked_timein DESC LIMIT 5");
        $pm_log->bindParam(1, $plate);
        $pm_log->bindParam(2, $campus);
        $pm_log->execute();
        $result = $pm_log->fetch(\PDO::FETCH_ASSOC);
        echo '<br>'.$plate.' '.$result['id'].'';
        $date = date("Y-m-d H:i:s");
        $id = $result['id'];
        $payref = $result['payment_ref'];

        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_exit_log WHERE exit_anpr_key = ? AND exit_site = ?");
        $query->bindParam(1, $anpr_key);
        $query->bindParam(2, $campus);
        $query->execute();
        $count = $query->rowCount();

        if($count < 1) {
          $query = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_timeout = ?, parked_column = '2' WHERE id = ?");
          $query->bindParam(1, $date);
          $query->bindParam(2, $id);
          $query->execute();

          $query2 = $this->mysql->dbc->prepare("INSERT INTO pm_exit_log VALUES ('', ?, ?, ?, ?)");
          $query2->bindParam(1, $id);
          $query2->bindParam(2, $date);
          $query2->bindParam(3, $anpr_key);
          $query2->bindParam(4, $campus);
          $query2->execute();
        } else {
          //do nothing
        }
      }

      $this->mssql = null;
      $this->mysql = null;
      $this->user = null;
    }
  }
?>
