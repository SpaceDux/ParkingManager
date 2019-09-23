<?php
  namespace ParkingManager_API;

  class Transaction
  {
    protected $mssql;
    protected $mysql;

    // Return tariffs
    function GetTariffs($Vehicle, $Expiry, $Method)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;

      $Site = $_CONFIG['api']['site'];

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND VehicleType = ? AND Status = 0 ORDER BY Gross ASC");
      $stmt->bindParam(1, $Site);
      $stmt->bindParam(2, $Expiry);
      $stmt->bindParam(3, $Vehicle);
      $stmt->execute();
      $data = array();
      $response = array();
      foreach($stmt->fetchAll() as $row) {
        if($stmt->rowCount() > 0) {
          // Cash
          if($Method == '1' AND $row['Cash'] == '1')
          {
            $response = array('Tariff_ID' => $row['Uniqueref'],
              'Name' => $row['Name'],
              'Gross' => $row['Gross']
            );
            $data[] = $response;
          }
          // Card
          else if($Method == '2' AND $row['Card'] == '1')
          {
            $response = array('Tariff_ID' => $row['Uniqueref'],
              'Name' => $row['Name'],
              'Gross' => $row['Gross']
            );
            $data[] = $response;
          }
          // Roadking Accounts / KingPay
          else if($Method == '3' AND $row['Account'] == '1')
          {
            $response = array('Tariff_ID' => $row['Uniqueref'],
              'Name' => $row['Name'],
              'Gross' => $row['Gross']
            );
            $data[] = $response;
          }
          // Snap Account
          else if($Method == '4' AND $row['Snap'] == '1')
          {
            $response = array('Tariff_ID' => $row['Uniqueref'],
              'Name' => $row['Name'],
              'Gross' => $row['Gross']
            );
            $data[] = $response;
          }
          // Fuel Card
          else if($Method == '5' AND $row['Fuel'] == '1')
          {
            $response = array('Tariff_ID' => $row['Uniqueref'],
              'Name' => $row['Name'],
              'Gross' => $row['Gross']
            );
            $data[] = $response;
          }
        } else {
          // Can't find any records
          echo json_encode(array(
            "Status" => '101',
            "Message" => 'Tariffs NOT found.',
            "SystemCode" => "1",
            "SystemInfo" => "ParkingManager Records.",
            "ResponseCode" => "0",
            "ResponseInfo" => "Tariffs not found."
          ));
        }
      }
      if(count($data) > 0) {
        echo json_encode(array(
          "Status" => '101',
          "Message" => 'Tariffs found.',
          "ResponseCode" => "1",
          "ResponseInfo" => "Tariffs found",
          "ResponseData" => $data
        ));
      } else {
        echo json_encode(array(
          "Status" => '101',
          "Message" => 'Tariffs not found.',
          "ResponseCode" => "0",
          "ResponseInfo" => "Tariffs not found"
        ));
      }

      $this->mysql = null;
    }
    // Add payment into db
    function New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID, $ETP, $Capture_Time, $Expiry, $CardType = '', $CardNo = '', $CardEx = '', $Site, $Note)
    {
      $this->mysql = new MySQL;

      $Author = "Kiosk API";
      $Service_Name = $this->Payment_TariffInfo($Service, "Name");
      $Ticket_Name = $this->Payment_TariffInfo($Service, "TicketName");
      $Service_Settlement_Group = $this->Payment_TariffInfo($Service, "Settlement_Group");
      $Service_Settlement_Multi = $this->Payment_TariffInfo($Service, "Settlement_Multi");
      $Service_Group = $this->Payment_TariffInfo($Service, "Tariff_Group");
      $Service_Gross = $this->Payment_TariffInfo($Service, "Gross");
      $Service_Nett = $this->Payment_TariffInfo($Service, "Nett");
      $Uniqueref = "01".date("YmdHis").mt_rand(1111, 9999);
      $Processed = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("INSERT INTO transactions (id, Uniqueref, Parkingref, Site, Method, Plate, Name, Service, Service_Name, Service_Ticket_Name, Service_Group, Gross, Nett, Processed_Time, Vehicle_Capture_Time, Vehicle_Expiry_Time, Ticket_Printed, AccountID, ETPID, Deleted, Deleted_Comment, Settlement_Group, Settlement_Multi, Author, FuelCard_Type, FuelCard_No, FuelCard_Ex, Last_Updated, Note)
      VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, '0', '', ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, $Ref);
      $stmt->bindParam(3, $Site);
      $stmt->bindParam(4, $Method);
      $stmt->bindParam(5, $Plate);
      $stmt->bindParam(6, $Name);
      $stmt->bindParam(7, $Service);
      $stmt->bindParam(8, $Service_Name);
      $stmt->bindParam(9, $Ticket_Name);
      $stmt->bindParam(10, $Service_Group);
      $stmt->bindParam(11, $Service_Gross);
      $stmt->bindParam(12, $Service_Nett);
      $stmt->bindParam(13, $Processed);
      $stmt->bindParam(14, $Capture_Time);
      $stmt->bindParam(15, $Expiry);
      $stmt->bindParam(16, $Account_ID);
      $stmt->bindParam(17, $ETP);
      $stmt->bindParam(18, $Service_Settlement_Group);
      $stmt->bindParam(19, $Service_Settlement_Multi);
      $stmt->bindParam(20, $Author);
      $stmt->bindParam(21, $CardType);
      $stmt->bindParam(22, $CardNo);
      $stmt->bindParam(23, $CardEx);
      $stmt->bindParam(24, $Processed);
      $stmt->bindParam(25, $Note);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        return FALSE;
      }

      $this->mysql = null;
    }
    // Add Transactions
    function AddTransaction($System, $Ref, $Method, $Tariff, $Trl = '', $Name, $VehicleType, $FuelStr = '', $Note)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->vehicles = new Vehicles;
      $this->checks = new Checks;

      $Site = $_CONFIG['api']['site'];

      if($FuelStr != '' OR $FuelStr != null) {
        $CardDets = $this->checks->Payment_FC_Break($FuelStr);
      }

      if($System == 0)
      {
        $Plate = $this->vehicles->ANPR_Info($Ref, "Plate");
        $TimeIN = $this->vehicles->ANPR_Info($Ref, "Capture_Date");
        $Service_Expiry = $this->Payment_TariffInfo($Tariff, "Expiry");
        $ETP = $this->Payment_TariffInfo($Tariff, "ETPID");
        $Expiry = date("Y-m-d H:i:s", strtotime($TimeIN.' +'.$Service_Expiry.' hours'));
        if($Method == 1) {
          // Add a parking record.
          $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
          if($VehRec != FALSE) {
            // Add transaction
            $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
            $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment);
            }
          }
        } else if($Method == 2) {
          // Add a parking record.
          $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
          if($VehRec != FALSE) {
            // Add transaction
            $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
            $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment);
            }
          }
        } else if($Method == 3) {
          $Account = $this->checks->Get_Account($Plate);
          if($Account != FALSE) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account, $TimeIN, $Expiry);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            }
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, please try again. Or seek alternative method.'));
          }
        } else if($Method == 4) {
          $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, $Name);
          if($ETPID != FALSE) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site), $Note;
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            }
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
          }
        } else if($Method == 5) {
          $CardChk = substr($CardDets['cardno'], "0", "6");
          if($CardChk == '704310' AND $CardDets['rc'] == "90") {
            $CardType = 1; // DKV
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
            echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
          } else if ($CardChk == '707821') {
						$CardType = 2; // Key Fuels
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '789666') {
						$CardType = 2; // Key Fuels
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '706000') {
						$CardType = 3; // UTA
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '700048') {
						$CardType = 4; // MORGAN
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '708284') {
            $CardType = 4; // MORGAN
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '700676') {
						$CardType = 5; // BP
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment);
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager does not recognize that card. Please use a different card, or seek alternative method.'));
          }
        }
      }
      else if($System == 1)
      {
        $Plate = $this->vehicles->VehicleInfo($Ref, "Plate");
        $TimeIN = $this->vehicles->VehicleInfo($Ref, "Arrival");
        $TimeExpiry = $this->vehicles->VehicleInfo($Ref, "Expiry");
        $Service_Expiry = $this->Payment_TariffInfo($Tariff, "Expiry");
        $ETP = $this->Payment_TariffInfo($Tariff, "ETPID");
        $Expiry = date("Y-m-d H:i:s", strtotime($TimeExpiry.' +'.$Service_Expiry.' hours'));
        $ANPRRef = $this->vehicles->VehicleInfo($Ref, "ANPRRef");
        if($Method == 1) {
          // Add transaction
          $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
          $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
          $this->vehicles->ExpiryUpdate($Ref, $Expiry);
          if($Payment != FALSE) {
            echo $this->PrintData($Payment);
          }
        } else if($Method == 2) {
          // Add transaction
          $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
          $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
          $this->vehicles->ExpiryUpdate($Ref, $Expiry);
          if($Payment != FALSE) {
            echo $this->PrintData($Payment);
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
          }
        } else if($Method == 3) {
          $Account = $this->checks->Get_Account($Plate);
          if($Account != FALSE)
          {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment);
            }
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, this vehicle is not on any of our fleet records.'));
          }
        } else if($Method == 4) {
          $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, $Name);
          if($ETPID != FALSE) {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment);
            }
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
          }
        } else if($Method == 5) {
          $CardChk = substr($CardDets['cardno'], "0", "6");
          if($CardChk == '704310' AND $CardDets['rc'] == "90") {
            $CardType = 1; // DKV
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
            echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
          } else if ($CardChk == '707821') {
            $CardType = 2; // Key Fuels
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '789666') {
            $CardType = 2; // Key Fuels
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '706000') {
            $CardType = 3; // UTA
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '700048') {
            $CardType = 4; // MORGAN
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '708284') {
            $CardType = 4; // MORGAN
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if ($CardChk == '700676') {
            $CardType = 5; // BP
            $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, $Name, $CardDets['cardno'], $CardDets['expiry']);
            if($ETPID != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID, $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment);
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else {
            echo json_encode(array("Status" => '103', "Message" => 'ParkingManager does not recognize that card. Please use a different card, or seek alternative method.'));
          }
        }
      }

      $this->mysql = null;
      $this->mssql = null;
      $this->vehicles = null;
      $this->checks = null;
    }
    //Payment Service Info
    function Payment_TariffInfo($key, $what)
    {
     $this->mysql = new MySQL;

     $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Uniqueref = ?");
     $stmt->bindParam(1, $key);
     $stmt->execute();
     $result = $stmt->fetch(\PDO::FETCH_ASSOC);
     return $result[$what];

     $this->mysql = null;
    }
    function PrintData($Ref)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->checks = new Checks;

      $Site = $_CONFIG['api']['site'];

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Uniqueref = ? AND Site = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->bindParam(2, $Site);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      $ExitCode = $this->checks->Vehicle_Info($result['Parkingref'], "ExitKey");

      $Printed = $result['Ticket_Printed'] += 1;

      if($result['Method'] == 1) {
        $Method = 'Cash';
      } else if($result['Method'] == 2) {
        $Method = 'Card';
      } else if($result['Method'] == 3) {
        $Method = 'Account';
      } else if($result['Method'] == 4) {
        $Method = 'SNAP';
      } else if($result['Method'] == 5) {
        $Method = 'Fuel Card';
      }

      if($Method == 3) {
        $AllowedDiscounts = $this->checks->Account_GetInfo($result['AccountID'], "Discount_Vouchers");
        if($AllowedDiscounts > 0) {
          $DiscountCount = $this->Payment_TariffInfo($result['Service'], "Discount_Vouchers");
          // $MealCount = $this->Payment_TariffInfo($result['Service'], "Meal_Vouchers");
          $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
        } else {
          $DiscountCount = 0;
          $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
        }
      } else {
        $DiscountCount = $this->Payment_TariffInfo($result['Service'], "Discount_Vouchers");
        $MealCount = $this->Payment_TariffInfo($result['Service'], "Meal_Vouchers");
        $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
      }

      $response = array (
                        'TicketName' => $result['Service_Ticket_Name'],
                        'Gross' => $result['Gross'],
                        'Nett' => $result['Nett'],
                        'Time' => $result['Vehicle_Capture_Time'],
                        'Expiry' => $result['Vehicle_Expiry_Time'],
                        'Name' => $result['Name'],
                        'Plate' => $result['Plate'],
                        'Shower_Count' => $ShowerCount,
                        'Discount_Count' => $DiscountCount,
                        'Meal_Count' => $MealCount,
                        'Method' => $Method,
                        'ExitCode' => '*'.$ExitCode.'#'
                        );

      $stmt2 = $this->mysql->dbc->prepare("UPDATE transactions SET Ticket_Printed = ? WHERE Uniqueref = ?");
      $stmt2->bindParam(1, $Printed);
      $stmt2->bindParam(2, $Ref);
      $stmt2->execute();

      echo json_encode($response);

      $this->mysql = null;
      $this->checks = null;
    }
  }

?>
