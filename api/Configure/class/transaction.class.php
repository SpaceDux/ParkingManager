<?php
  namespace ParkingManager_API;

  class Transaction
  {
    protected $mssql;
    protected $mysql;

    // Return transactions
    function GetTariffs($Vehicle, $Expiry, $Method, $Site)
    {
        $this->mysql = new MySQL;

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
        echo json_encode(array(
          "Status" => '101',
          "Message" => 'Tariffs found.',
          "ResponseCode" => "1",
          "ResponseInfo" => "Tariffs found",
          "ResponseData" => $data
        ));

        $this->mysql = null;
    }
    // Add payment into db
    function New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID, $ETP, $Capture_Time, $Expiry, $CardType = '', $CardNo = '', $CardEx = '', $Site)
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

      $stmt = $this->mysql->dbc->prepare("INSERT INTO transactions (id, Uniqueref, Parkingref, Site, Method, Plate, Name, Service, Service_Name, Service_Ticket_Name, Service_Group, Gross, Nett, Processed_Time, Vehicle_Capture_Time, Vehicle_Expiry_Time, Ticket_Printed, AccountID, ETPID, Deleted, Deleted_Comment, Settlement_Group, Settlement_Multi, Author, FuelCard_Type, FuelCard_No, FuelCard_Ex, Last_Updated)
      VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, '0', '', ?, ?, ?, ?, ?, ?, ?)");
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
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        return FALSE;
      }

      $this->mysql = null;
    }
    // Add Transactions
    function AddTransaction($System, $Site, $Ref, $Method, $Tariff, $Plate, $Trl = '', $Name, $VehicleType, $FuelStr = '')
    {
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->vehicles = new Vehicles;
      $this->checks = new Checks;

      if($System == 0)
      {
        $TimeIN = $this->vehicles->ANPR_Info($Ref, "Capture_Date");
        $Service_Expiry = $this->Payment_TariffInfo($Tariff, "Expiry");
        $Expiry = date("Y-m-d H:i:s", strtotime($TimeIN.' +'.$Service_Expiry.' hours'));
        if($Method == 1) {
          // Add a parking record.
          $VehRec = $this->vehicles->Create_Parking_Rec($Ref, $Site, $Plate, $Trl, $Name, $VehicleType, $Account_ID = null, $TimeIN, $Expiry);
          if($VehRec != FALSE) {
            $Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Tariff, $Account_ID = null, $ETP = null, $TimeIN, $Expiry, $CardType = null, $CardNo = null, $CardEx = null, $Site);
          }
        } else if($Method == 2) {

        } else if($Method == 3) {

        } else if($Method == 4) {

        } else if($Method == 5) {

        }
      }
      else if($System == 1)
      {
        if($Method == 1) {

        } else if($Method == 2) {

        } else if($Method == 3) {

        } else if($Method == 4) {

        } else if($Method == 5) {

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
  }

?>
