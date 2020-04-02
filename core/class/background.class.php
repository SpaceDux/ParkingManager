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
       $this->external = new External;

       $campus = $this->user->Info("Site");
       // $this->user = null;
       $expiry = date("Y-m-d H:i:s");

       $anpr = $this->mssql->dbc->prepare("SELECT TOP 10 * FROM ANPR_REX_Archive WHERE Lane_ID = 2 ORDER BY Capture_Date DESC");
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
           $Booking = $result['Bookingref'];
           $parked_expiry = date("Y-m-d H:i:s", strtotime($time.' +135 minutes'));
           if($parked_expiry >= $expiry) {
             $query = $this->mysql->dbc->prepare("SELECT * FROM automated_exit WHERE ANPRRef = ? AND Site = ?");
             $query->bindParam(1, $anpr_key);
             $query->bindParam(2, $campus);
             $query->execute();
             $count = $query->rowCount();
             if($count < 1) {
               if($Booking != '' OR $Booking != null) {
                 $return = $this->external->ModifyStatus_Portal($Booking, '3');
                 $result = json_decode($return, true);
                 if($result['Status'] > 0) {
                   $query = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = '2' WHERE Uniqueref = ?");
                   $query->bindParam(1, $date);
                   $query->bindParam(2, $id);
                   $query->execute();
                   $query2 = $this->mysql->dbc->prepare("INSERT INTO automated_exit VALUES ('', ?, ?, ?, ?)");
                   $query2->bindParam(1, $id);
                   $query2->bindParam(2, $anpr_key);
                   $query2->bindParam(3, $expiry);
                   $query2->bindParam(4, $campus);
                   $query2->execute();
                   if($query2->execute()) {
                     echo json_encode(array("Result" => "1", "Message" => 'ParkingManager has automatically exit and notified Portal for vehicle: '.$plate));
                   }
                 } else {
                   echo json_encode(array("Result" => "0", "Message" => 'ParkingManager could not communicate with the Portal, vehicle has not been exit.'.$plate));
                 }
               } else {
                 $query = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = '2' WHERE Uniqueref = ?");
                 $query->bindParam(1, $date);
                 $query->bindParam(2, $id);
                 $query->execute();
                 $query2 = $this->mysql->dbc->prepare("INSERT INTO automated_exit VALUES ('', ?, ?, ?, ?)");
                 $query2->bindParam(1, $id);
                 $query2->bindParam(2, $anpr_key);
                 $query2->bindParam(3, $expiry);
                 $query2->bindParam(4, $campus);
                 $query2->execute();
                 if($query2->execute()) {
                   echo json_encode(array("Result" => "1", "Message" => 'ParkingManager has automatically exit vehicle: '.$plate));
                 }
               }
             }
           } else {
               //do nothing
           }
         } else {
           // Do nothing
         }
       }
       $this->mssql = null;
       $this->mysql = null;
       $this->user = null;
       $this->pm = null;
       $this->external = null;
     }
     function Parking_Reinstate()
     {
       $this->mssql = new MSSQL;
       $this->mysql = new MySQL;
       $this->pm = new PM;

       $stmt = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
       $stmt->execute();
       foreach($stmt->fetchAll() as $row) {
         $anpr_timein = $row['Capture_Date'];
         $anpr_plate = $row['Plate'];
         $anpr_ref = $row['Uniqueref'];
         $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 2 ORDER BY Departure DESC LIMIT 1");
         $stmt->bindParam(1, $anpr_plate);
         $stmt->execute();
         $result = $stmt->fetchAll();
         if($stmt->rowCount() > 0) {
           foreach($result as $row) {
             $Departed = $row['Departure'];
             $Uniqueref = $row['Uniqueref'];
             $Expiry = $row['Expiry'];
             $Departure = date("Y-m-d H:i:s", strtotime($Departed.'+ 3 hours'));
             if($anpr_timein <= $Departure AND $Departed < $anpr_timein) {
               // Reinstate parking record.
               $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Parked_Column = 1, Departure = '', ANPRRef = ? WHERE Uniqueref = ?");
               $stmt->bindParam(1, $anpr_ref);
               $stmt->bindParam(2, $Uniqueref);
               $stmt->execute();
               $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
               $stmt->bindParam(1, $Expiry);
               $stmt->bindParam(2, $anpr_ref);
               $stmt->execute();
               $this->pm->LogWriter('ParkingManager has reinstated parking record for: '.$anpr_plate, "1", "");
               echo json_encode(array("Result" => "1", "Message" => 'Left within 2 hours. Reinstated parking record for: '.$anpr_plate));
             }
           }
         }
       }

       $this->mysql = null;
       $this->mssql = null;
       $this->pm = null;
     }
     function Blacklist_Check()
     {
       $this->mssql = new MSSQL;
       $this->mysql = new MySQL;

       $Date = date("Y-m-d H:i:s");

       $stmt = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
       $stmt->execute();
       foreach($stmt->fetchAll() as $row) {
         $stmt = $this->mysql->dbc->prepare("SELECT * FROM blacklists WHERE Plate = ?");
         $stmt->bindValue(1, $row['Plate']);
         $stmt->execute();
         if($stmt->rowCount() > 0) {
           $result = $stmt->fetch(\PDO::FETCH_ASSOC);
           if($Date > $result['Reminder']) {
             if($result['Type'] == "1") {
               $Type = "Alert";
             } else if($result['Type'] == "2") {
               $Type = "Banned";
             }
             echo json_encode(array('Uniqueref' => $result['Uniqueref'], 'Plate' => $row['Plate'], 'Type' => $Type, 'Message' => $result['Message']));
           }
         }
       }
       $this->mssql = null;
       $this->mysql = null;
     }
     // Update Portal > Status = Arrived.
     function ANPR_PortalCheck()
     {
      $this->mssql = new MSSQL;
      $this->external = new External;

      $Bookings = $this->external->ReturnBookingsAsArray();

      $stmt = $this->mssql->dbc->prepare("SELECT TOP 200 Plate FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
      $stmt->execute();
      foreach($stmt->fetchAll() as $row) {
        foreach($Bookings['Data'] as $Portal) {
          if($Portal['Plate'] == $row['Plate']) {
            if($Portal['Status'] < 1) {
              // Modify Status
              $return = $this->external->ModifyStatus_Portal($Portal['Uniqueref'], "1");
              $result = json_decode($return);
              if($result['Status'] == 1) {
                echo json_encode(array('Result' => '1', 'Message' => 'Prebooked: '.$row['Plate'].', has arrived on site. The portal has been notified.'));
              }
            }
          }
        }
      }

       $this->mssql = null;
       $this->external = null;
     }
  }
?>
