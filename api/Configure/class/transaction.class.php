<?php
  namespace ParkingManager_API;
  use UniFi_API;

  class Transaction
  {
    protected $mssql;
    protected $mysql;

    // Return tariffs
    function GetTariffs($Vehicle, $Expiry, $Method, $Type, $Prebooked)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;

      $Site = $_CONFIG['api']['site'];
      if($Prebooked == 1) {
        // Prebooked
        if($Type == 1) {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND Meal_Vouchers > 0 AND Status = 0 AND Kiosk = 1 AND Portal = 1 ORDER BY Gross ASC");
          $stmt->bindParam(1, $Site);
          $stmt->bindParam(2, $Expiry);
        } else {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND Meal_Vouchers < 1 AND Status = 0 AND Kiosk = 1 AND Portal = 1 ORDER BY Gross ASC");
          $stmt->bindParam(1, $Site);
          $stmt->bindParam(2, $Expiry);
        }
      } else {
        // Not prebooked
        if($Type == 1) {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND VehicleType = ? AND Meal_Vouchers > 0 AND Status = 0 AND Kiosk = 1 AND Portal = 0 ORDER BY Gross ASC");
          $stmt->bindParam(1, $Site);
          $stmt->bindParam(2, $Expiry);
          $stmt->bindParam(3, $Vehicle);
        } else {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND VehicleType = ? AND Meal_Vouchers < 1 AND Status = 0 AND Kiosk = 1 AND Portal = 0 ORDER BY Gross ASC");
          $stmt->bindParam(1, $Site);
          $stmt->bindParam(2, $Expiry);
          $stmt->bindParam(3, $Vehicle);
        }
      }
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
    function New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID, $ETP, $Capture_Time, $Expiry, $CardType = '', $CardNo = '', $CardEx = '', $Site, $Note, $Booking)
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

      $stmt = $this->mysql->dbc->prepare("INSERT INTO transactions VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, '0', '', ?, ?, ?, ?, ?, ?, ?, '1', ?, ?)");
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
      $stmt->bindParam(24, $Note);
      $stmt->bindParam(25, $Booking);
      $stmt->bindParam(26, $Processed);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        return FALSE;
      }

      $this->mysql = null;
      $this->checks = null;
    }
    // Add Transactions
    function AddTransaction($System, $Ref, $Method, $Tariff, $Trl = '', $Name, $VehicleType, $FuelStr = '', $Note)
    {
      global $_CONFIG;
      $this->vehicles = new Vehicles;
      $this->checks = new Checks;

      $Site = $_CONFIG['api']['site'];
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        if($System == 0)
        {
          $Plate = $this->vehicles->ANPR_Info($Ref, "Plate");
          $TimeIN = $this->vehicles->ANPR_Info($Ref, "Capture_Date");
          $Service_Expiry = $this->Payment_TariffInfo($Tariff, "Expiry");
          $ETP = $this->Payment_TariffInfo($Tariff, "ETPID");
          $Expiry = date("Y-m-d H:i:s", strtotime($TimeIN.' +'.$Service_Expiry.' hours'));
          // Run & check if booked on portal
          $Probooked = $this->checks->Check_On_Portal($Plate);
          if($Probooked['Status'] == 1) {
            $Booking = $Probooked['Bookingref'];
            // Update booking & confirm checkin.
            $this->checks->ModifyStatus_Portal($Booking, "2");
          } else {
            $Booking = '';
          }

          if($Method == 1) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            }
          } else if($Method == 2) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            }
          } else if($Method == 3) {
            $Account = $this->checks->Get_Account($Plate);
            if($Account != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account, $TimeIN, $Expiry, $Booking);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, please try again. Or seek alternative method.'));
            }
          } else if($Method == 4) {
            $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, "RK Self Service");
            if($ETPID['Status'] > "0") {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 5) {
            $CardDets = $this->checks->Payment_FC_Break($FuelStr);

            $CardChk = substr($CardDets['cardno'], "0", "6");
            if($CardChk == '704310' AND $CardDets['rc'] == "90") {
              $CardType = 1; // DKV
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
              echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
            } else if ($CardChk == '707821') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '789666') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '706000') {
              $CardType = 3; // UTA
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700048') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '708284') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700676') {
              $CardType = 5; // BP
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
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
          // Run & check if booked on portal
          $Probooked = $this->checks->Check_On_Portal($Plate);
          if($Probooked['Status'] == 1) {
            $Booking = $Probooked['Bookingref'];
            // Update booking & confirm checkin.
            $this->checks->ModifyStatus_Portal($Booking, "2");
          } else {
            $Booking = '';
          }

          if($Method == 1) {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment, "0");
            }
          } else if($Method == 2) {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment, "0");
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 3) {
            $Account = $this->checks->Get_Account($Plate);
            if($Account != FALSE)
            {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
              $this->vehicles->ExpiryUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, this vehicle is not on any of our fleet records.'));
            }
          } else if($Method == 4) {
            $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, "RK Self Service");
            if($ETPID['Status'] > "0") {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
              $this->vehicles->ExpiryUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 5) {
            $CardDets = $this->checks->Payment_FC_Break($FuelStr);
            $CardChk = substr($CardDets['cardno'], "0", "6");
            if($CardChk == '704310' AND $CardDets['rc'] == "90") {
              $CardType = 1; // DKV
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
              echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
            } else if ($CardChk == '707821') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '789666') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '706000') {
              $CardType = 3; // UTA
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700048') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '708284') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700676') {
              $CardType = 5; // BP
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager does not recognize that card. Please use a different card, or seek alternative method.'));
            }
          }
        }
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        if($System == 0)
        {
          $Plate = $this->vehicles->ANPR_Info($Ref, "Plate");
          $TimeIN = $this->vehicles->ANPR_Info($Ref, "CaptureTime");
          $Service_Expiry = $this->Payment_TariffInfo($Tariff, "Expiry");
          $ETP = $this->Payment_TariffInfo($Tariff, "ETPID");
          $Expiry = date("Y-m-d H:i:s", strtotime($TimeIN.' +'.$Service_Expiry.' hours'));
          // Run & check if booked on portal
          $Probooked = $this->checks->Check_On_Portal($Plate);
          if($Probooked['Status'] == 1) {
            $Booking = $Probooked['Bookingref'];
            // Update booking & confirm checkin.
            $this->checks->ModifyStatus_Portal($Booking, "2");
          } else {
            $Booking = '';
          }

          if($Method == 1) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            }
          } else if($Method == 2) {
            // Add a parking record.
            $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
            if($VehRec != FALSE) {
              // Add transaction
              $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            }
          } else if($Method == 3) {
            $Account = $this->checks->Get_Account($Plate);
            if($Account != FALSE) {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account, $TimeIN, $Expiry, $Booking);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                }
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, please try again. Or seek alternative method.'));
            }
          } else if($Method == 4) {
            $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, "RK Self Service");
            if($ETPID['Status'] > "0") {
              // Add a parking record.
              $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
              if($VehRec != FALSE) {
                // Add transaction
                $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 5) {
            $CardDets = $this->checks->Payment_FC_Break($FuelStr);

            $CardChk = substr($CardDets['cardno'], "0", "6");
            if($CardChk == '704310' AND $CardDets['rc'] == "90") {
              $CardType = 1; // DKV
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
              echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
            } else if ($CardChk == '707821') {
    					$CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '789666') {
    					$CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '706000') {
    					$CardType = 3; // UTA
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700048') {
    					$CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '708284') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700676') {
    					$CardType = 5; // BP
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add a parking record.
                $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry, $Booking);
                if($VehRec != FALSE) {
                  // Add transaction
                  $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                  $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                  if($Payment != FALSE) {
                    echo $this->PrintData($Payment, "0");
                  } else {
                    echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                  }
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager could not create the vehicle record.'));
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
          // Run & check if booked on portal
          $Probooked = $this->checks->Check_On_Portal($Plate);
          if($Probooked['Status'] == 1) {
            $Booking = $Probooked['Bookingref'];
            // Update booking & confirm checkin.
            $this->checks->ModifyStatus_Portal($Booking, "2");
          } else {
            $Booking = '';
          }

          if($Method == 1) {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment, "0");
            }
          } else if($Method == 2) {
            // Add transaction
            $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
            $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
            $this->vehicles->ExpiryUpdate($Ref, $Expiry);
            if($Payment != FALSE) {
              echo $this->PrintData($Payment, "0");
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 3) {
            $Account = $this->checks->Get_Account($Plate);
            if($Account != FALSE)
            {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
              $this->vehicles->ExpiryUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager has rejected the transaction, this vehicle is not on any of our fleet records.'));
            }
          } else if($Method == 4) {
            $ETPID = $this->checks->Process_SNAP_Transaction($Plate, $ETP, "RK Self Service");
            if($ETPID['Status'] > "0") {
              // Add transaction
              $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site, $Note, $Booking);
              $this->vehicles->ANPR_PaymentUpdate($ANPRRef, $Expiry);
              $this->vehicles->ExpiryUpdate($Ref, $Expiry);
              if($Payment != FALSE) {
                echo $this->PrintData($Payment, "0");
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
            }
          } else if($Method == 5) {
            $CardDets = $this->checks->Payment_FC_Break($FuelStr);
            $CardChk = substr($CardDets['cardno'], "0", "6");
            if($CardChk == '704310' AND $CardDets['rc'] == "90") {
              $CardType = 1; // DKV
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if($CardChk == '704310' AND $CardDets['rc'] != "90") {
              echo json_encode(array("Status" => '103', "Message" => 'Your DKV Card is not RC 90'));
            } else if ($CardChk == '707821') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '789666') {
              $CardType = 2; // Key Fuels
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '706000') {
              $CardType = 3; // UTA
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700048') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '708284') {
              $CardType = 4; // MORGAN
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else if ($CardChk == '700676') {
              $CardType = 5; // BP
              $ETPID = $this->checks->Process_Fuel_Transaction($Plate, $ETP, "RK Self Service", $CardDets['cardno'], $CardDets['expiry']);
              if($ETPID['Status'] > "0") {
                // Add transaction
                $Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETPID['ETPID'], $TimeIN, $Expiry, $CardType, $CardDets['cardno'], $CardDets['expiry'], $Site, $Note, $Booking);
                $this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
                $this->vehicles->ExpiryUpdate($Ref, $Expiry);
                if($Payment != FALSE) {
                  echo $this->PrintData($Payment, "0");
                } else {
                  echo json_encode(array("Status" => '103', "Message" => 'ParkingManager transaction failed.'));
                }
              } else {
                echo json_encode(array("Status" => '103', "Message" => 'ETP have rejected the transaction, please try again.'));
              }
            } else {
              echo json_encode(array("Status" => '103', "Message" => 'ParkingManager does not recognize that card. Please use a different card, or seek alternative method.'));
            }
          }
        }
      }

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
    function PrintData($Ref, $Print)
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
      $Printed = $result['Ticket_Printed'] += 1;

      if($Print == 1) {
        $stmt2 = $this->mysql->dbc->prepare("UPDATE transactions SET Ticket_Printed = ? WHERE Uniqueref = ?");
        $stmt2->bindParam(1, $Printed);
        $stmt2->bindParam(2, $Ref);
        $stmt2->execute();

        $response = array (
                          'Status' => "101"
                          );

        echo json_encode($response);
      } else {

        $ExitCode = $this->checks->Vehicle_Info($result['Parkingref'], "ExitKey");
        // $VehType = $this->checks->Vehicle_Info($result['Parkingref'], "Type");

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

        if($Method == 'Account') {
          $AllowedDiscounts = $this->checks->Account_GetInfo($result['AccountID'], "Discount_Vouchers");
          if($AllowedDiscounts > 0) {
            $DiscountCount = $this->Payment_TariffInfo($result['Service'], "Discount_Vouchers");
            $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
            $MealCount = $this->Payment_TariffInfo($result['Service'], "Meal_Vouchers");
          } else {
            $DiscountCount = "0";
            $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
            $MealCount = $this->Payment_TariffInfo($result['Service'], "Meal_Vouchers");
          }
        } else {
          $DiscountCount = $this->Payment_TariffInfo($result['Service'], "Discount_Vouchers");
          $MealCount = $this->Payment_TariffInfo($result['Service'], "Meal_Vouchers");
          $ShowerCount = $this->Payment_TariffInfo($result['Service'], "Shower_Vouchers");
        }
        $TimeIN = date("d/m/Y H:i", strtotime($result['Vehicle_Capture_Time']));
        $Expiry = date("d/m/Y H:i", strtotime($result['Vehicle_Expiry_Time']));
        $TicketName = strtoupper($result['Service_Ticket_Name']);
        $response = array (
                          'Status' => "101",
                          'PaymentID' => $result['Uniqueref'],
                          'TicketName' => $TicketName,
                          'Gross' => $result['Gross'],
                          'Nett' => $result['Nett'],
                          'Time' => $TimeIN,
                          'Expiry' => $Expiry,
                          'Name' => $result['Name'],
                          'Plate' => $result['Plate'],
                          'Shower_Count' => $ShowerCount,
                          'Discount_Count' => $DiscountCount,
                          'Meal_Count' => $MealCount,
                          'Method' => $Method,
                          'ExitCode' => '*'.$ExitCode.'#',
                          'Tariff_ID' => $result['Service']
                          );

        echo json_encode($response);
      }

      $this->mysql = null;
      $this->checks = null;
    }
    function Create_Wifi_Voucher()
    {
      global $_CONFIG;
      $this->checks = new Checks;

      $site = $_CONFIG['api']['site'];

      $controllerurl = $this->checks->Site_Info($site, "Unifi_IP");
      $controlleruser = $this->checks->Site_Info($site, "Unifi_User");
      $controllerpassword = $this->checks->Site_Info($site, "Unifi_Pass");
      $site_id = $this->checks->Site_Info($site, "Unifi_Site");
      $controllerversion = $this->checks->Site_Info($site, "Unifi_Ver");

      $voucher_expiration = 1440;
      //Unifi creds
      $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
      $loginresults = $unifi_connection->login();
      //Make Voucher
      $voucher_result = $unifi_connection->create_voucher($voucher_expiration, 1, 1, 'PM API Generated '.date("d/m/y H:i"), '512', '2048');
      $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);
      $vouchers = json_encode($vouchers);
      $code = json_decode($vouchers, true);

      foreach($code as $row) {
        return $row['code'];
      }

      $this->checks = null;
    }
    function Wifi_Transaction($Method, $Note)
    {
      global $_CONFIG;
      $site = $_CONFIG['api']['site'];
      $Service = $_CONFIG['api']['wifi_tariff'];

      try {
        $Code = $this->Create_Wifi_Voucher();
        if($Code != null)
        {
          $this->New_Transaction("", $Method, "WiFi", "WiFi", $Service, '', '', '', '', $CardType = '', $CardNo = '', $CardEx = '', $site, $Note, "");
          echo json_encode(array("Status" => '101', "Message" => 'WiFi transaction has been accepted.', "Code" => $Code));
        } else {
          echo json_encode(array("Status" => '105', "Message" => 'WiFi Transaction has not been added, please try again or seek assistance. Wifi System Offline'));
        }
      } catch(\PDOException $e) {
        echo json_encode(array("Status" => '105', "Message" => 'WiFi Transaction has not been added, please try again or seek assistance.'));
      }
    }
  }

  ?>
