<?php
  namespace ParkingManager;
  class Kiosk {
    //Return the Parking Page with relevant forms
    function Kiosk_Search($Plate) {
      $this->mssql = new MSSQL;
      $this->mysql = new MySQL;

      $mssql = $this->mssql->dbc->prepare("SELECT TOP 1 * FROM ANPR_REX WHERE Plate = ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC", array(\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
      $mssql->bindParam(1, $Plate);
      $mssql->execute();
      $count = $mssql->rowCount();
      $result = $mssql->fetch(\PDO::FETCH_ASSOC);
      // ANPR Record
      if($count > 0) {
        $return = array (
          "Type" => "1",
          "id" => $result['Uniqueref']
        );
        echo json_encode($return);
      } else if($count < 1) {
        $current_time = date("Y-m-d H:i:s", strtotime('-2 hours'));
        $mysql = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_plate = ? AND parked_column < 2 AND parked_deleted < 1 ORDER BY parked_timein DESC LIMIT 1");
        $mysql->bindParam(1, $Plate);
        $mysql->execute();
        $count2 = $mysql->rowCount();
        $result = $mysql->fetch(\PDO::FETCH_ASSOC);
        if($count2 > 0 AND $result['parked_expiry'] <= $current_time) {
          // Already paid
          $return2 = array (
            "Type" => "2",
            "id" => $result['id']
          );
          echo json_encode($return2);
        } else if($count2 > 0 AND $result['parked_expiry'] >= $current_time) {
          // Renewal
          $return2 = array (
            "Type" => "3",
            "id" => $result['id']
          );
          echo json_encode($return2);
        } else {
          $return3 = array (
            "Type" => "4"
          );

          echo json_encode($return3);
        }
      }

      $this->anpr = null;
      $this->vehicles = null;
    }

    //Get the correct payment options for the kiosk parking form
    //Allow only the allowed types.
    function Kiosk_GET_PaymentTypes($reg) {
      global $_CONFIG;
      $this->account = new Account;
      $this->etp = new ETP;
      $html = "";

      $html .= '<div class="Radios">
                  <div class="Label">
                    Cash
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="Cash" value="1" checked>
                    <label for="Cash"><img src="cash.png"></img></label>
                  </div>
                  <div class="Label">
                    Card
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="Card" value="2">
                    <label for="Card"><img src="card.png"></img></label>
                  </div>';
                if($this->account->Account_Check($reg) == TRUE) {
                  $html .= '
                  <div class="Label">
                    RK Accounts
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="Account" value="3" checked>
                    <label for="Account"><img src="kingpay.png"></img></label>
                  </div>';
                } else {
                  $html .= '
                  <div class="Label">
                    RK Accounts
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="Account" value="3" disabled>
                    <label for="Account"><img src="kingpay.png"></img></label>
                  </div>';
                }
                if($this->etp->Check_SNAP($reg) == TRUE) {
                  $html .='
                  <div class="Label">
                    SNAP
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="SNAP" value="4">
                    <label for="SNAP"><img src="snap.png"></img></label>
                  </div>';
                } else {
                  $html .='
                  <div class="Label">
                    SNAP
                    <input type="radio" class="RadioButton" name="Kiosk_PayType" id="SNAP" value="4" disabled>
                    <label for="SNAP"><img src="snap.png"></img></label>
                  </div>';
                }
                $html .= '
                <div class="Label">
                  Fuel Card
                  <input type="radio" class="RadioButton" name="Kiosk_PayType" id="Fuel" value="5">
                  <label for="Fuel"><img src="fuelcard.png"></img></label>
                </div>';
                $html .= '
              </div>';


      echo $html;

      $this->account = null;
      $this->etp = null;
    }
    //Get the correct payment options for the kiosk parking form
    //Allow only the allowed types.
    function Kiosk_GET_PaymentServices($pay, $expiry, $type) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_expiry = ? AND service_vehicles = ? AND service_campus = ? AND service_deleted < 1 AND service_active > 0 AND service_group != 2 ORDER BY service_price_gross ASC");
      $stmt->bindParam(1, $expiry);
      $stmt->bindParam(2, $type);
      $stmt->bindParam(3, $campus);
      $stmt->execute();
      $html = "";

      foreach($stmt->fetchAll() as $row) {
        if($pay == 1 AND $row['service_cash'] == 1) {
          $html .= '<div class="Services">
                      <input type="radio" name="Kiosk_Service" class="Kiosk_Service" id="'.$row['id'].'" value="'.$row['id'].'">
                      <label for="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</label>
                    </div>';
        } else if($pay == 2 AND $row['service_card'] == 1) {
          $html .= '<div class="Services">
                      <input type="radio" name="Kiosk_Service" class="Kiosk_Service" id="'.$row['id'].'" value="'.$row['id'].'">
                      <label for="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</label>
                    </div>';
        } else if($pay == 3 AND $row['service_account'] == 1) {
          $html .= '<div class="Services">
                      <input type="radio" name="Kiosk_Service" class="Kiosk_Service" id="'.$row['id'].'" value="'.$row['id'].'">
                      <label for="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</label>
                    </div>';
        } else if($pay == 4 AND $row['service_snap'] == 1) {
          $html .= '<div class="Services">
                      <input type="radio" name="Kiosk_Service" class="Kiosk_Service" id="'.$row['id'].'" value="'.$row['id'].'">
                      <label for="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</label>
                    </div>';
        } else if($pay == 5 AND $row['service_fuel'] == 1) {
          $html .= '<div class="Services">
                      <input type="radio" name="Kiosk_Service" class="Kiosk_Service" id="'.$row['id'].'" value="'.$row['id'].'">
                      <label for="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</label>
                    </div>';
        }
      }

      echo $html;
      $this->mysql = null;
    }

    function Kiosk_ConfirmInfo() {
      $this->payment = new Payment;
      $this->vehicles = new Vehicles;

      if($_POST['Kiosk_PayType'] == 1) {
        $paytype = "Cash";
      } else if ($_POST['Kiosk_PayType'] == 2) {
        $paytype = "Card";
      } else if ($_POST['Kiosk_PayType'] == 3) {
        $paytype = "Roadking Pay";
      } else if ($_POST['Kiosk_PayType'] == 4) {
        $paytype = "SNAP Account";
      } else if ($_POST['Kiosk_PayType'] == 5) {
        $paytype = "Fuel Card";
      }

      $html = '<h1 style="color:white;">'.strtoupper($_POST['Kiosk_Plate']).'</h1><br>';
      $html .= '<h1 style="color:white;">'.$this->vehicles->Vehicle_Type_Info($_POST['Kiosk_Type'], "type_name").'</h1><br>';
      $html .= '<h1 style="color:white;">'.$paytype.'</h1><br>';
      $html .= '<h1 style="color:white;">'.$this->payment->Payment_ServiceInfo($_POST['Kiosk_Service'], "service_name").'</h1><br>';
      $html .= '<h1 style="color:white;">£'.$this->payment->Payment_ServiceInfo($_POST['Kiosk_Service'], "service_price_gross").'</h1><br>';

      echo $html;

      $this->payment = null;
      $this->vehicles = null;
    }
    // Kiosk Payments
    function Kiosk_Begin_Parking_Transaction($Plate, $Sys, $ID, $Type, $PayType, $Service, $FuelCardNo = '', $FuelCardEx = '') {
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->anpr = new ANPR;
      $this->user = new User;
      $this->payment = new Payment;
      $this->pm = new PM;
      $this->account = new Account;
      $this->vehicles = new Vehicles;
      $this->etp = new ETP;
      if($Sys == "1") {
        // ANPR Payment
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Plate = strtoupper($Plate);
        $Company = "";
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ID);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->payment->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->payment->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->payment->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->payment->Payment_ServiceInfo($Service, "service_price_net");
        $etpid = $this->payment->Payment_ServiceInfo($Service, "service_etpid");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->payment->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->payment->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->payment->Payment_ServiceInfo($Service, "service_ticket_name");
        $group = $this->payment->Payment_ServiceInfo($Service, "service_group");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        if ($PayType == "1") {
          // Cash
          try {
            $this->payment->Payment_Transaction_Add($ID, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null, $group, $Type);

            $ref = $this->payment->PaymentInfo($Plate, "payment_ref");
            $pay_id = $this->payment->PaymentInfo($Plate, "id");

            //ANPR DB SQL
            $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
            $sql_anprTbl->bindParam(1, $expiry);
            $sql_anprTbl->bindParam(2, $ID);
            $sql_anprTbl->execute();

            //Create new parking log information.
            $this->vehicles->Vehicles_Parking_New($ID, $ref, $Plate, "", $Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

            // $this->PrintTicket();

            $this->payment->Payment_Ticket_Info($pay_id, "1", $current_date, $ANPR_Date, $expiry);
          } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
          }
        } else if ($PayType == "2") {
          // Card
          try {
            $this->payment->Payment_Transaction_Add($ID, $Plate, $Company, "2", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null, $group, $Type);

            $ref = $this->payment->PaymentInfo($Plate, "payment_ref");
            $pay_id = $this->payment->PaymentInfo($Plate, "id");

            //ANPR DB SQL
            $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
            $sql_anprTbl->bindParam(1, $expiry);
            $sql_anprTbl->bindParam(2, $ID);
            $sql_anprTbl->execute();

            //Create new parking log information.
            $this->vehicles->Vehicles_Parking_New($ID, $ref, $Plate, "", $Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

            // $this->PrintTicket();

            $this->payment->Payment_Ticket_Info($pay_id, "1", $current_date, $ANPR_Date, $expiry);
          } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
          }
        } else if ($PayType == "3") {
          // Roadking Pay
          try {
            $Acc_ID = $this->account->Account_FleetInfo($Plate, "account_id");
            $this->payment->Payment_Transaction_Add($ID, $Plate, $Company, "3", $Service, $service_name, $price_gross, $price_net, $name, $current_date, $Acc_ID, $campus, $payment_ref, null, $group, $Type);

            $ref = $this->payment->PaymentInfo($Plate, "payment_ref");
            $pay_id = $this->payment->PaymentInfo($Plate, "id");

            //ANPR DB SQL
            $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
            $sql_anprTbl->bindParam(1, $expiry);
            $sql_anprTbl->bindParam(2, $ID);
            $sql_anprTbl->execute();

            //Create new parking log information.
            $this->vehicles->Vehicles_Parking_New($ID, $ref, $Plate, "", $Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

            // $this->PrintTicket();

            $this->payment->Payment_Ticket_Info($pay_id, "1", $current_date, $ANPR_Date, $expiry);
          } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
          }
        } else if($PayType == "4") {
          // SNAP
          try {
            $return = $this->etp->Proccess_Transaction_SNAP($etpid, $Plate, $Company);
            if($return == FALSE) {
              echo 0;
              //echo "TRANSACTION NOT ADDED";
            } else {
              $this->payment->Payment_Transaction_Add($ID, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, $return, $group, $Type);

              $ref = $this->payment->PaymentInfo($Plate, "payment_ref");
              $pay_id = $this->payment->PaymentInfo($Plate, "id");

              //ANPR DB SQL
              $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
              $sql_anprTbl->bindParam(1, $expiry);
              $sql_anprTbl->bindParam(2, $ID);
              $sql_anprTbl->execute();

              //Create new parking log information.
              $this->vehicles->Vehicles_Parking_New($ID, $ref, $Plate, "", $Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

              // $this->PrintTicket();

              $this->payment->Payment_Ticket_Info($pay_id, "1", $current_date, $ANPR_Date, $expiry);
            }
          } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
          }
        } else if($PayType == "5") {
          // Fuel Card
          try {
            $this->payment->Payment_Transaction_Add($ID, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null, $group, $Type);

            $ref = $this->payment->PaymentInfo($Plate, "payment_ref");
            $pay_id = $this->payment->PaymentInfo($Plate, "id");

            //ANPR DB SQL
            $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
            $sql_anprTbl->bindParam(1, $expiry);
            $sql_anprTbl->bindParam(2, $ID);
            $sql_anprTbl->execute();

            //Create new parking log information.
            $this->vehicles->Vehicles_Parking_New($ID, $ref, $Plate, "", $Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

            // $this->PrintTicket();

            $this->payment->Payment_Ticket_Info($pay_id, "1", $current_date, $ANPR_Date, $expiry);
          } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
          }
        }
      } else if ($Sys == "2") {
        // Renewal / ParkingManager Record Payment
      }
    }
  }
?>
