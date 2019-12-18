<?php
  namespace ParkingManager_API;

  class Vehicles
  {
    protected $mysql;
    protected $mssql;

    // Initial Vehicle Query
    function Initial_Search($Plate)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->checks = new Checks;

      $Site = $_CONFIG['api']['site'];

      $Plate = str_replace(" ", "", $Plate);

      if($this->checks->Check_Site_Exists($Site) == TRUE)
      {
        $snap = $this->checks->Check_On_SNAP($Plate);
        if($snap != 0) {
          $ETPCk = $snap;
        } else {
          $ETPCk = FALSE;
        }

        $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 1 AND Site = ? AND Deleted < 1");
        $stmt->bindValue(1, $Plate);
        $stmt->bindValue(2, $Site);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          $ref = $result['Uniqueref'];
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Parkingref = ? AND Site = ? AND Service_Group IN (2,3) AND Ticket_Printed < 1 AND Deleted < 1 ORDER BY Processed_Time DESC LIMIT 1");
          $stmt->bindParam(1, $ref);
          $stmt->bindParam(2, $Site);
          // $stmt->bindParam(3, $ref);
          // $stmt->bindParam(4, $Site);
          $stmt->execute();

          $trans = $stmt->fetch(\PDO::FETCH_ASSOC);

          $response = array('ParkingID' => $ref,
          'PaymentID' => $trans['Uniqueref'],
          'Arrival_Time' => $result['Arrival'],
          'Img_Patch' => $result['Img_Patch'],
          'Img_Overview' => $result['Img_Overview'],
          'Accept_Account' => $this->checks->Check_On_Account($Plate),
          'Accept_SNAP' => $ETPCk
          );
          if($trans['Vehicle_Expiry_Time'] >= date("Y-m-d H:i:s"))
          {
            if($stmt->rowCount() > 0)
            {
              // Has a valid transaction
              echo json_encode(array(
                "Status" => '101',
                "Message" => 'Vehicle Record has been found for this registration plate, also indicates vehicle has a valid transaction.',
                "SystemCode" => "1",
                "SystemInfo" => "ParkingManager Record.",
                "ResponseCode" => "1",
                "ResponseInfo" => "Has a valid and redeemable ticket.",
                "ResponseData" => $response
              ));
            }
            else
            {
              // Has no valid tickets (All redeemed)
              echo json_encode(array(
                                "Status" => '101',
                                "Message" => 'Vehicle Record has been found for this registration plate, also indicates vehicle has already redeemed transaction.',
                                "SystemCode" => "1",
                                "SystemInfo" => "ParkingManager Record.",
                                "ResponseCode" => "2",
                                "ResponseInfo" => "Needs to pay, has no valid tickets.",
                                "ResponseData" => $response
                              ));
            }
          } else
          {
            // Expired Parking Record
            echo json_encode(array(
                              "Status" => '101',
                              "Message" => 'A Record has been found, however this vehicle has expired and requires a new payment.',
                              "SystemCode" => "1",
                              "SystemInfo" => "ParkingManager Record.",
                              "ResponseCode" => "2",
                              "ResponseInfo" => "Needs to pay, has no valid tickets.",
                              "ResponseData" => $response
                            ));
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
            $response = array('ParkingID' => $result['Uniqueref'],
            'Arrival_Time' => $result['Capture_Date'],
            'Img_Patch' => $patch,
            'Img_Overview' => $overview,
            'Accept_Account' => $this->checks->Check_On_Account($Plate),
            'Accept_SNAP' => $ETPCk
            );

            echo json_encode(array(
                              "Status" => '101',
                              "Message" => 'ANPR record has been found for this registration plate.',
                              "SystemCode" => "0",
                              "SystemInfo" => "ANPR Record.",
                              "ResponseCode" => "2",
                              "ResponseInfo" => "Needs to pay, has no valid tickets.",
                              "ResponseData" => $response
                            ));
          }
          else
          {
            // RETURN NO RESULTS
            echo json_encode(array(
                              "Status" => '101',
                              "Message" => 'No record exists for that registration.',
                              "ResponseCode" => "0",
                              "ResponseInfo" => "No record found."
                            ));
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
    // Add a vehicle into the ANPR
    function Add_Vehicle($Plate, $Trlno = '', $Time)
    {
      global $_CONFIG;
      $this->mssql = new MSSQL;
      $this->checks = new Checks;

      $Site = $_CONFIG['api']['site'];

      $Plate = str_replace(" ", "", strtoupper($Plate));
      $Trlno = str_replace(" ", "", strtoupper($Trlno));

      if($this->checks->Check_Site_Exists($Site) == TRUE)
      {
        $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane', :capDate, :createdDate, null, 'RoadKing - Added via API', '0', null, '0', :plate2, :Trl, null, :capDate2, null, '', '', '')");
        $stmt->bindParam(':plate', $Plate);
        $stmt->bindParam(':capDate', $Time);
        $stmt->bindParam(':createdDate', $Time);
        $stmt->bindParam(':plate2', $Plate);
        $stmt->bindParam(':Trl', $Trlno);
        $stmt->bindParam(':capDate2', $Time);
        if($stmt->execute())
        {
          $this->Initial_Search($Plate, $Site);
        }
        else
        {
          echo json_encode(array("Status" => '105', "Message" => 'Vehicle can not been added.'));
        }
      }
      else
      {
        echo json_encode(array("Status" => '103', "Message" => 'Site Check failed. Site Doesn\'t exist.'));
      }


      $this->mssql = null;
      $this->checks = null;
    }
    function ANPR_Info($ref, $what)
    {
      $this->mssql = new MSSQL;

      $html = "";

      $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if(count($result) > 0) {
        return $result[$what];
      } else {

      }

      $this->mssql = null;
    }
    // Update ANPR Record (array)
    function ANPR_PaymentUpdate($ref, $expiry)
    {
      $this->mssql = new MSSQL;

      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $expiry);
      $stmt->bindParam(2, $ref);
      $stmt->execute();

      $this->mssql = null;
    }
    // Add Parking Record
    function Create_Parking_Rec($Ref, $Site, $Plate, $Trl = '', $Name, $VehicleType, $Account_ID = '', $TimeIN, $Expiry)
    {
      $this->checks = new Checks;
      $this->mysql = new MySQL;

      $Author = "Kiosk API";
      $ExitKey = mt_rand(11111, 99999);
      $ExitKey = str_replace("0", "9", $ExitKey);
      $Uniqueref = "0".date("YmdHis").$ExitKey;
      $Patch = $this->ANPR_Info($Ref, "Patch");
      $Overview = $this->ANPR_Info($Ref, "Overview");
      $Patch = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $Patch);
      $Overview = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $Overview);
      $Plate = strtoupper($Plate);
      $Name = strtoupper($Name);
      $time = date("Y-m-d H:i:s");


      $stmt = $this->mysql->dbc->prepare("INSERT INTO parking_records (id, Uniqueref, ANPRRef, Site, Plate, Name, Type, Arrival, Expiry, Departure, Parked_Column, AccountID, Trailer_No, Author, Flagged, Deleted, Notes, ExitKey, Img_Patch, Img_Overview, Last_Updated) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', 1, ?, ?, ?, '2', '0', '', ?, ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, $Ref);
      $stmt->bindParam(3, $Site);
      $stmt->bindParam(4, $Plate);
      $stmt->bindParam(5, $Name);
      $stmt->bindParam(6, $VehicleType);
      $stmt->bindParam(7, $TimeIN);
      $stmt->bindParam(8, $Expiry);
      $stmt->bindParam(9, $Account_ID);
      $stmt->bindParam(10, $Trl);
      $stmt->bindParam(11, $Author);
      $stmt->bindParam(12, $ExitKey);
      $stmt->bindParam(13, $Patch);
      $stmt->bindParam(14, $Overview);
      $stmt->bindParam(15, $time);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        return FALSE;
      }
      $this->checks = null;
      $this->mysql = null;
    }
    // Update a vehicles expiry time. And Flag status
    function ExpiryUpdate($ref, $time)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Expiry = ?, Flagged = '2' WHERE Uniqueref = ?");
      $stmt->bindParam(1, $time);
      $stmt->bindParam(2, $ref);
      $stmt->execute();

      $this->mysql = null;
    }
    // Update a vehicles expiry time.
    function VehicleInfo($ref, $what)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      if($stmt->execute()) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result[$what];
      } else {

      }

      $this->mysql = null;
    }
  }

?>
