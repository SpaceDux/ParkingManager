<?php
  namespace ParkingManager_API;

  class Vehicles
  {
    protected $mysql;
    protected $mssql;

    function Initial_Search($Plate, $Site)
    {
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->checks = new Checks;
      if($this->checks->Check_Site_Exists($_POST['Site']) == TRUE)
      {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 1 AND Site = ? AND Deleted < 1 AND Flagged < 1");
        $stmt->bindValue(1, $_POST['Plate']);
        $stmt->bindValue(2, $_POST['Site']);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          if($result['Expiry'] >= date("Y-m-d H:i:s"))
          {
            $ref = $result['Uniqueref'];
            $stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Parkingref = ? AND Site = ? AND Service_Group = 2 AND Ticket_Printed < 1 OR Parkingref = ? AND Site = ? AND Service_Group = 3 AND Ticket_Printed < 1 ORDER BY Processed_Time ASC");
            $stmt->bindParam(1, $ref);
            $stmt->bindParam(2, $Site);
            $stmt->bindParam(3, $ref);
            $stmt->bindParam(4, $Site);
            $stmt->execute();

            $response = array('ID' => $ref,
            'Time' => $result['Arrival'],
            'Img_Patch' => $result['Img_Patch'],
            'Img_Overview' => $result['Img_Overview'],
            'Accept_Account' => $this->checks->Check_On_Account($Plate),
            'Accept_SNAP' => $this->checks->Check_On_SNAP($Plate)
            );
            if($stmt->rowCount() > 0)
            {
              // Has a valid transaction
              echo json_encode(array(
                "Status" => '101',
                "Message" => 'Vehicle Record has been found for this registration plate, also indicates vehicle has a valid transaction.',
                "System" => "1",
                "ResponseCode" => "1",
                "Response" => $response
              ));
            }
            else
            {
              // Has no valid tickets (All redeemed)
              echo json_encode(array(
                                "Status" => '101',
                                "Message" => 'Vehicle Record has been found for this registration plate, also indicates vehicle has already redeemed transaction.',
                                "System" => "1",
                                "ResponseCode" => "2",
                                "Response" => $response
                              ));
            }
          }
        }
        else
        {
          // VIA ANPR
          $stmt = $this->mssql->dbc->prepare("SELECT TOP 1 * FROM ANPR_REX WHERE Plate = ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC", array(\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
          $stmt->bindParam(1, $Plate);
          $stmt->execute();
          if($stmt->rowCount() > 0)
          {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            $patch = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $result['Patch']);
            $overview = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $result['Overview']);
            $response = array('ID' => $result['Uniqueref'],
            'Time' => $result['Capture_Date'],
            'Img_Patch' => $patch,
            'Img_Overview' => $overview,
            'Accept_Account' => $this->checks->Check_On_Account($Plate),
            'Accept_SNAP' => $this->checks->Check_On_SNAP($Plate)
            );

            echo json_encode(array(
                              "Status" => '101',
                              "Message" => 'ANPR record has been found for this registration plate.',
                              "System" => "0",
                              "ResponseCode" => "2",
                              "Response" => $response
                            ));
          }
          else
          {
            // RETURN NO RESULTS
          }
        }
      }
      else
      {
        echo json_encode(array("Status" => '103', "Message" => 'Site Check failed. Site Doesn\'t exist.'));
      }
      $this->mysql = null;
      $this->mssql = null;
      $this->checks = null;
    }
  }

?>
