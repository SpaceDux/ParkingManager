<?php
  namespace ParkingManager;
  class Background {
      //Automated Exit
     function Automation_Exit()
     {
       $this->mssql = new MSSQL;
       $this->mysql = new MySQL;
       $this->user = new User;
       $this->pm = new PM;
       $campus = $this->user->Info("Site");
       // $this->user = null;
       $expiry = date("Y-m-d H:i:s");

       $anpr = $this->mssql->dbc->prepare("SELECT TOP 20 * FROM ANPR_REX_Archive WHERE Lane_ID = 2 ORDER BY Capture_Date DESC");
       $anpr->execute();
       foreach ($anpr->fetchAll() as $row) {
         $plate = $row['Plate'];
         $anpr_key = $row['Uniqueref'];
         $date = $row['Capture_Date'];
         // echo '<br>'.$plate.' '.$date;
         $parking = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 1 AND Site = ? ORDER BY Arrival DESC");
         $parking->bindParam(1, $plate);
         $parking->bindParam(2, $campus);
         $parking->execute();
         $result = $parking->fetch(\PDO::FETCH_ASSOC);
         $timein = $result['Arrival'];
         if($date > $timein) {
           $time = $result['Expiry'];
           $id = $result['Uniqueref'];
           $parked_expiry = date("Y-m-d H:i:s", strtotime($time.' +135 minutes'));
           echo 'Plate: '.$plate.' | Time IN: '.$timein.' ANPR Date: '.$date.'<br>';
           if($parked_expiry >= $expiry) {
             $query = $this->mysql->dbc->prepare("SELECT * FROM exit_log WHERE exit_anpr_key = ? AND exit_site = ?");
             $query->bindParam(1, $anpr_key);
             $query->bindParam(2, $campus);
             $query->execute();
             $count = $query->rowCount();
             if($count < 1) {
               $query = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = '2' WHERE Uniqueref = ?");
               $query->bindParam(1, $date);
               $query->bindParam(2, $id);
               $query->execute();

               $query2 = $this->mysql->dbc->prepare("INSERT INTO exit_log (exit_id, exit_time, exit_anpr_key, exit_site) VALUES (?, ?, ?, ?)");
               $query2->bindParam(1, $id);
               $query2->bindParam(2, $expiry);
               $query2->bindParam(3, $anpr_key);
               $query2->bindParam(4, $campus);
               $query2->execute();
               if($query2->execute()) {
                 $this->pm->PM_Notification_Create("ParkingManager has automatically EXIT the vehicle".$plate."", "0");
               }
             }
           } else {
               //do nothing
           }
         } else {
           echo 'FALSE - Plate: '.$plate.' | Time IN: '.$timein.' ANPR Date: '.$date.'<br>';
         }
       }
       $this->mssql = null;
       $this->mysql = null;
       $this->user = null;
       $this->pm = null;
     }
  }
?>
