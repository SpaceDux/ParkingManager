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
      if($_CONFIG['ANPR']['Type'] == "ETP") {
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
          $accCk = $this->checks->Check_On_Account($Plate);
          if($accCk == TRUE) {
            $ETPCk = FALSE;
          }


          $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 1 AND Site = ? AND Deleted < 1");
          $stmt->bindValue(1, $Plate);
          $stmt->bindValue(2, $Site);
          $stmt->execute();
          if($stmt->rowCount() > 0)
          {
            $Prebooked = $this->checks->Check_On_Portal($Plate);

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $ref = $result['Uniqueref'];
            $stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Parkingref = ? AND Site = ? AND Service_Group IN (2,3,5,6) AND Ticket_Printed < 1 AND Deleted < 1 ORDER BY Processed_Time DESC LIMIT 1");
            $stmt->bindParam(1, $ref);
            $stmt->bindParam(2, $Site);
            $stmt->execute();

            $trans = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($Prebooked['Status'] == 1) {
              $response = array('ParkingID' => $ref,
                'PaymentID' => $trans['Uniqueref'],
                'Arrival_Time' => $result['Arrival'],
                'Img_Patch' => $result['Img_Patch'],
                'Img_Overview' => $result['Img_Overview'],
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "1",
                'Vehicle_Type' => $Prebooked['Vehicle_Type'],
              );
            } else {
              $response = array('ParkingID' => $ref,
                'PaymentID' => $trans['Uniqueref'],
                'Arrival_Time' => $result['Arrival'],
                'Img_Patch' => $result['Img_Patch'],
                'Img_Overview' => $result['Img_Overview'],
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "0",
              );
            }
            $Expiry = date("Y-m-d H:i:s", strtotime($result['Expiry'] . "- 4 hours"));

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
                // Cool down, dont allow another parking payment
                if($Expiry >= date("Y-m-d H:i:s"))
                {
                  // Has no valid tickets (All redeemed)
                  echo json_encode(array(
                    "Status" => '101',
                    "Message" => 'Sorry, we can\'t process another transaction for your vehicle until after '.date("d/m/y H:i:s", strtotime($Expiry)).', please seek assistance from a member of staff.',
                    "SystemCode" => "1",
                    "SystemInfo" => "ParkingManager Record.",
                    "ResponseCode" => "3",
                    "ResponseInfo" => "Needs to pay, has no valid tickets.",
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
              }
            }
            else
            {
              // Cool down, dont allow another parking payment
              if($Expiry >= date("Y-m-d H:i:s"))
              {
                // Has no valid tickets (All redeemed)
                echo json_encode(array(
                  "Status" => '101',
                  "Message" => 'Sorry, we can\'t process another transaction for your vehicle until after '.date("d/m/y H:i:s", strtotime($Expiry)).', please seek assistance from a member of staff.',
                  "SystemCode" => "1",
                  "SystemInfo" => "ParkingManager Record.",
                  "ResponseCode" => "3",
                  "ResponseInfo" => "Needs to pay, has no valid tickets.",
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
            }
          }
          else
          {
            $Prebooked = $this->checks->Check_On_Portal($Plate);
            // VIA ANPR
            $stmt = $this->mssql->dbc->prepare("SELECT TOP 1 * FROM ANPR_REX WHERE Plate = ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC", array(\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
            $stmt->bindParam(1, $Plate);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
              $result = $stmt->fetch(\PDO::FETCH_ASSOC);

              $patch = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $result['Patch']);
              $overview = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $result['Overview']);

              if($Prebooked['Status'] == 1) {
                $response = array('ParkingID' => $result['Uniqueref'],
                'Arrival_Time' => $result['Capture_Date'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "1",
                'Vehicle_Type' => $Prebooked['Vehicle_Type'],
                );
              } else {
                $response = array('ParkingID' => $result['Uniqueref'],
                'Arrival_Time' => $result['Capture_Date'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "0",
                );
              }

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
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->mysql = new MySQL;
        $this->rev = new Rev;
        $this->checks = new Checks;

        $Site = $_CONFIG['api']['site'];

        $Plate = str_replace(" ", "", $Plate);
        $Imgurl = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/";

        if($this->checks->Check_Site_Exists($Site) == TRUE)
        {
          $snap = $this->checks->Check_On_SNAP($Plate);
          if($snap != 0) {
            $ETPCk = $snap;
          } else {
            $ETPCk = FALSE;
          }
          $accCk = $this->checks->Check_On_Account($Plate);
          if($accCk == TRUE) {
            $ETPCk = FALSE;
          }


          $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate = ? AND Parked_Column = 1 AND Site = ? AND Deleted < 1");
          $stmt->bindValue(1, $Plate);
          $stmt->bindValue(2, $Site);
          $stmt->execute();
          if($stmt->rowCount() > 0)
          {
            $Prebooked = $this->checks->Check_On_Portal($Plate);

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $ref = $result['Uniqueref'];
            $stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Parkingref = ? AND Site = ? AND Service_Group IN (2,3,5,6) AND Ticket_Printed < 1 AND Deleted < 1 ORDER BY Processed_Time DESC LIMIT 1");
            $stmt->bindParam(1, $ref);
            $stmt->bindParam(2, $Site);
            $stmt->execute();

            $trans = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($result['Img_Patch'] != '' || $result['Img_Patch'] != null) {
              $patch = $Imgurl.$result['Img_Patch'];
              $overview = $Imgurl.$result['Img_Overview'];
            } else {
              $patch = '';
              $overview = '';
            }

            if($Prebooked['Status'] == 1) {
              $response = array('ParkingID' => $ref,
                'PaymentID' => $trans['Uniqueref'],
                'Arrival_Time' => $result['Arrival'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "1",
                'Vehicle_Type' => $Prebooked['Vehicle_Type'],
              );
            } else {
              $response = array('ParkingID' => $ref,
                'PaymentID' => $trans['Uniqueref'],
                'Arrival_Time' => $result['Arrival'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "0",
              );
            }

            $Expiry = date("Y-m-d H:i:s", strtotime($result['Expiry'] . "- 4 hours"));

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
                // Cool down, dont allow another parking payment
                if($Expiry >= date("Y-m-d H:i:s"))
                {
                  // Has no valid tickets (All redeemed)
                  echo json_encode(array(
                    "Status" => '101',
                    "Message" => 'Sorry, we can\'t process another transaction for your vehicle until after '.date("d/m/y H:i:s", strtotime($Expiry)).', please seek assistance from a member of staff.',
                    "SystemCode" => "1",
                    "SystemInfo" => "ParkingManager Record.",
                    "ResponseCode" => "3",
                    "ResponseInfo" => "Needs to pay, has no valid tickets.",
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
              }
            } else
            {
              // Cool down, dont allow another parking payment
              if($Expiry >= date("Y-m-d H:i:s"))
              {
                // Has no valid tickets (All redeemed)
                echo json_encode(array(
                  "Status" => '101',
                  "Message" => 'Sorry, we can\'t process another transaction for your vehicle until after '.date("d/m/y H:i:s", strtotime($Expiry)).', please seek assistance from a member of staff.',
                  "SystemCode" => "1",
                  "SystemInfo" => "ParkingManager Record.",
                  "ResponseCode" => "3",
                  "ResponseInfo" => "Needs to pay, has no valid tickets.",
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
            }
          }
          else
          {
            $Prebooked = $this->checks->Check_On_Portal($Plate);
            // VIA ANPR
            $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE Plate = ? AND LaneID = 1 AND Status < 1 ORDER BY CaptureTime DESC LIMIT 1");
            $stmt->bindParam(1, $Plate);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
              $result = $stmt->fetch(\PDO::FETCH_ASSOC);

              if($result['Images'] != '' || $result['Images'] != null) {
                $images = json_decode($result['Images'], true);
                $patch = $Imgurl.$images['Plate'];
                $overview = $Imgurl.$images['Front'];
              } else {
                $patch = '';
                $overview = '';
              }
              if($Prebooked['Status'] == 1) {
                $response = array('ParkingID' => $result['Uniqueref'],
                'Arrival_Time' => $result['CaptureTime'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "1",
                'Vehicle_Type' => $Prebooked['Vehicle_Type'],
                );
              } else {
                $response = array('ParkingID' => $result['Uniqueref'],
                'Arrival_Time' => $result['CaptureTime'],
                'Img_Patch' => $patch,
                'Img_Overview' => $overview,
                'Accept_Account' => $accCk,
                'Accept_SNAP' => $ETPCk,
                'Prebooked' => "0",
                );
              }

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
        $this->rev = null;
        $this->checks = null;
      }
    }
    // Add a vehicle into the ANPR
    function Add_Vehicle($Plate, $Trlno = '', $Time)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;
        $this->checks = new Checks;

        $Site = $_CONFIG['api']['site'];

        $Plate = str_replace(" ", "", strtoupper($Plate));
        $Trlno = str_replace(" ", "", strtoupper($Trlno));

        if($this->checks->Check_Site_Exists($Site) == TRUE)
        {
          $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane', :capDate, :createdDate, null, 'RoadKing - Self Service', '0', null, '0', :plate2, :Trl, null, :capDate2, null, '', '', '')");
          $stmt->bindParam(':plate', $Plate);
          $stmt->bindParam(':capDate', $Time);
          $stmt->bindParam(':createdDate', $Time);
          $stmt->bindParam(':plate2', $Plate);
          $stmt->bindParam(':Trl', $Trlno);
          $stmt->bindParam(':capDate2', $Time);
          if($stmt->execute())
          {
            $this->Initial_Search($Plate);
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
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $this->checks = new Checks;

        $Site = $_CONFIG['api']['site'];

        $Plate = str_replace(" ", "", strtoupper($Plate));

        if($this->checks->Check_Site_Exists($Site) == TRUE)
        {
          $Uniqueref = mt_rand(11111111, 99999999);
          $stmt = $this->rev->dbc->prepare("INSERT INTO rev_plates (Uniqueref, Plate, OriginalPlate, Country, CaptureTime, ExpiryTime, Images, CameraID, LaneID, LaneName, LaneGroup, Parkingref, ExitCode, ManualEntry, Confidence, Status) VALUES (?, ?, ?, 'NON', ?, ?, '', '0', '1', 'Entry Lane', '1', '', '00000', '1', '', '0')");
          $stmt->bindParam(1, $Uniqueref);
          $stmt->bindParam(2, $Plate);
          $stmt->bindParam(3, $Plate);
          $stmt->bindParam(4, $Time);
          $stmt->bindParam(5, $Time);
          if($stmt->execute())
          {
            $this->Initial_Search($Plate);
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


        $this->rev = null;
        $this->checks = null;
      }
    }
    function ANPR_Info($ref, $what)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;

        $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(count($result) > 0) {
          return $result[$what];
        } else {

        }

        $this->mssql = null;
      } else if ($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;

        $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          return $result[$what];
        } else {

        }

        $this->rev = null;
      }
    }
    // Update ANPR Record (array)
    function ANPR_PaymentUpdate($ref, $expiry)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;

        $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $stmt->bindParam(1, $expiry);
        $stmt->bindParam(2, $ref);
        $stmt->execute();

        $this->mssql = null;
      } else if ($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;

        $stmt = $this->rev->dbc->prepare("UPDATE rev_plates SET Status = 1, ExpiryTime = ? WHERE Uniqueref = ?");
        $stmt->bindParam(1, $expiry);
        $stmt->bindValue(2, $ref);
        $stmt->execute();

        $this->rev = null;
      }
    }
    // Add Parking Record
    function Create_Parking_Rec($Ref, $Site, $Plate, $Trl = '', $Name, $VehicleType, $Account_ID = '', $TimeIN, $Expiry, $Booking)
    {
      global $_CONFIG;
      $this->checks = new Checks;
      $this->mysql = new MySQL;

      $Author = "Kiosk API";
      $ExitKey = mt_rand(11111, 99999);
      $ExitKey = str_replace("0", "9", $ExitKey);
      $Uniqueref = "0".date("YmdHis").$ExitKey;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $Patch = $this->ANPR_Info($Ref, "Patch");
        $Overview = $this->ANPR_Info($Ref, "Overview");
        $Patch = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $Patch);
        $Overview = str_replace($this->checks->Site_Info($Site, 'ANPR_Imgstr'), $this->checks->Site_Info($Site, 'ANPR_Img'), $Overview);
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $Images = $this->ANPR_Info($Ref, "Images");
        $result = json_decode($Images, true);
        $Patch = $result['Plate'];
        $Overview = $result['Front'];
      }
      $Plate = strtoupper($Plate);
      $Name = strtoupper($Name);
      $time = date("Y-m-d H:i:s");


      $stmt = $this->mysql->dbc->prepare("INSERT INTO parking_records (id, Uniqueref, ANPRRef, Site, Plate, Name, Type, Arrival, Expiry, Departure, Parked_Column, AccountID, Trailer_No, Author, Flagged, Deleted, Notes, ExitKey, Img_Patch, Img_Overview, Bookingref, Last_Updated)
      VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', '1', ?, ?, ?, '2', '0', '', ?, ?, ?, ?, ?)");
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
      $stmt->bindParam(15, $Booking);
      $stmt->bindParam(16, $time);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        return FALSE;
      }
      $this->checks = null;
      $this->mysql = null;
      $this->pm = null;
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
