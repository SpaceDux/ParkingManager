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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_expiry = ? AND service_vehicles = ? AND service_deleted < 1 AND service_active > 0 AND service_group != 2 ORDER BY service_price_gross ASC");
      $stmt->bindParam(1, $expiry);
      $stmt->bindParam(2, $type);
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
  }
?>
