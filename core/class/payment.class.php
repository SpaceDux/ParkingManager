<?php

  namespace ParkingManager;
  use Mike42\Escpos\Printer;
  use Mike42\Escpos\EscposImage;
  use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

  class Payment
  {
    #Variables
    protected $mysql;
    protected $mssql;
    private $user;
    private $vehicle;
    private $campus;
    private $pm;
    private $anpr;

    //Get All transactions for the logged vehicle
    function getTransactions($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_ref = ? AND payment_deleted = 0 ORDER BY payment_date DESC");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
      $html = '<tr>';
      foreach($result as $row) {
        if($row['payment_type'] == 1) {
          $type = "Cash";
        } else if ($row['payment_type'] == 2) {
          $type = "Card";
        } else if ($row['payment_type'] == 3) {
          $type = "Account";
        } else if ($row['payment_type'] == 4) {
          $type = "SNAP";
        } else if ($row['payment_type'] == 5) {
          $type = "Fuel Card";
        }
        $html .= '<td>'.$type.'</td>';
        $html .= '<td>'.$row['payment_service_name'].'</td>';
        $html .= '<td>'.date("d/m H:i", strtotime($row['payment_date'])).'</td>';
        $html .= '<td>'.$row['payment_author'].'</td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                    <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                    <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                  </td>';
        $html .= '<tr>';
      }

      echo $html;
    }
    //List all services
    function list_services($site) {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_campus = ? ORDER BY service_price_gross ASC");
      $query->bindParam(1, $site);
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        $table = "<tr>";
        $table .= "<td>".$row['service_name']."</td>";
        $table .= "<td>".$row['service_price_gross']."</td>";
        $table .= "<td>".$row['service_price_net']."</td>";
        $table .= "<td>".$row['service_expiry']."</td>";
        if($row['service_mealVoucher'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_showerVoucher'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_cash'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_card'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_account'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_snap'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        if($row['service_fuel'] == 1) {
          $table .= '<td class="table-success">Yes</td>';
        } else {
          $table .= '<td class="table-danger">No</td>';
        }
        $table .= "<td>".$row['service_update_author']."</td>";
        $table .= "<td>".$this->pm->PM_SiteInfo($row['service_campus'], "site_name")."</td>";
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" id="Payment_Service_Update_Modal" data-id="'.$row['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" onClick="Payment_Service_Delete('.$row['id'].')" href="#">Delete Service</a>
              </div>
            </div>
          </div>
        </td>';
        $table .= "</tr>";

        echo $table;
      }
      $this->mysql = null;
      $this->pm = null;
    }
    //Add services
    function Add_Service($name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $meal_voucher, $shower_voucher, $meal_amount, $shower_amount) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $date = date("Y-m-d H:i");
      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_services (service_name, service_ticket_name, service_price_gross, service_price_net, service_expiry, service_cash, service_card, service_account, service_snap, service_fuel, service_author, service_created, service_update_author, service_campus, service_mealVoucher, service_meal_amount, service_showerVoucher, service_shower_amount, service_vehicles, service_anyvehicle) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', '0')");
      $query->bindParam(1, $name);
      $query->bindParam(2, $ticket_name);
      $query->bindParam(3, $price_gross);
      $query->bindParam(4, $price_net);
      $query->bindParam(5, $expiry);
      $query->bindParam(6, $cash);
      $query->bindParam(7, $card);
      $query->bindParam(8, $account);
      $query->bindParam(9, $snap);
      $query->bindParam(10, $fuel);
      $query->bindParam(11, $fname);
      $query->bindParam(12, $date);
      $query->bindParam(13, $fname);
      $query->bindParam(14, $campus);
      $query->bindParam(15, $meal_voucher);
      $query->bindParam(16, $meal_amount);
      $query->bindParam(17, $shower_voucher);
      $query->bindParam(18, $shower_amount);
      if($query->execute()) {
        echo "Executed successfully";
      } else {
        echo "Executed unsuccessfully";
      }

      $this->mysql = null;
      $this->user = null;
    }
    //Delete services
    function DeleteService($key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("DELETE FROM pm_services WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();

      $this->mysql = null;
    }
    //Add Transaction
    function Payment_ProcessNew($ANPRKey, $plate, $company, $pay_type, $service, $service_name, $gross, $net, $author, $date, $account, $campus, $ref, $etp) {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $sqlPayment = $this->mysql->dbc->prepare("INSERT INTO pm_payments (payment_anprkey, payment_vehicle_plate, payment_company_name, payment_type, payment_service_id, payment_service_name, payment_price_gross, payment_price_net, payment_author, payment_date, payment_account_id, payment_campus, payment_ref, payment_etp_id, payment_deleted, payment_deleted_comment) VALUES (:ANPRKey, :Plate, :Company, :Type, :Service_ID, :Service_Name, :Price_Gross, :Price_Net, :Author, :Cur_Date, :Account, :Campus, :PayRef, :ETP, '0', '')");
      $sqlPayment->bindParam(':ANPRKey', $ANPRKey);
      $sqlPayment->bindParam(':Plate', $plate);
      $sqlPayment->bindParam(':Company', $company);
      $sqlPayment->bindParam(':Type', $pay_type);
      $sqlPayment->bindParam(':Service_ID', $service);
      $sqlPayment->bindParam(':Service_Name', $service_name);
      $sqlPayment->bindParam(':Price_Gross', $gross);
      $sqlPayment->bindParam(':Price_Net', $net);
      $sqlPayment->bindParam(':Author', $author);
      $sqlPayment->bindParam(':Cur_Date', $date);
      $sqlPayment->bindParam(':Account', $account);
      $sqlPayment->bindParam(':Campus', $campus);
      $sqlPayment->bindParam(':PayRef', $ref);
      $sqlPayment->bindParam(':ETP', $etp);
      if($sqlPayment->execute()) {
        $newDate = date("D - H:i", strtotime($date));
        if($pay_type == 1) {
          $type = "Cash";
        } else if($pay_type == 2) {
          $type = "Card";
        } else if($pay_type == 3) {
          $type = "Account";
        } else if($pay_type == 4) {
          $type = "SNAP";
        } else if($pay_type == 5) {
          $type = "Fuel Card";
        }
        $this->pm->PM_Notification_Create("A $type payment has been authorised and processed by $author at $newDate, ref: $ref", "0");
      }

      $this->mysql = null;
      $this->pm = null;
    }
    //Add Vehicle to parking log
    function Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus) {
      //SQL for Parking Log 15
      $Trailer = strtoupper($Trailer);
      $sql_parkedLog = $this->mysql->dbc->prepare("INSERT INTO pm_parking_log (parked_anprkey, payment_ref, parked_plate, parked_trailer, parked_type, parked_company, parked_column, parked_timein, parked_timeout, parked_expiry, parked_flag, parked_deleted, parked_account_id, parked_author, parked_campus, parked_comment) VALUES (:ANPRKey, :PayRef, :Plate, :Trailer, :Vehicle_Type, :Company, '1', :TimeIN, '', :Expiry, '0', '0', null, :Name, :Campus, '')");
      $sql_parkedLog->bindParam(':ANPRKey', $ANPRKey);
      $sql_parkedLog->bindParam(':PayRef', $ref);
      $sql_parkedLog->bindParam(':Plate', $Plate);
      $sql_parkedLog->bindParam(':Trailer', $Trailer);
      $sql_parkedLog->bindParam(':Vehicle_Type', $Vehicle_Type);
      $sql_parkedLog->bindParam(':Company', $Company);
      $sql_parkedLog->bindParam(':TimeIN', $ANPR_Date);
      $sql_parkedLog->bindParam(':Expiry', $expiry);
      $sql_parkedLog->bindParam(':Name', $name);
      $sql_parkedLog->bindParam(':Campus', $campus);
      $sql_parkedLog->execute();
    }
    //Gather payment information & vehicle info
    function Payment_Ticket_Info($tid, $ticket_printed, $processed, $date, $expiry) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_tickets (ticket_tid, ticket_printed, ticket_date_processed, ticket_date, ticket_expiry) VALUES (?, ?, ?, ?, ?)");
      $query->bindParam(1, $tid);
      $query->bindParam(2, $ticket_printed);
      $query->bindParam(3, $processed);
      $query->bindParam(4, $date);
      $query->bindParam(5, $expiry);
      $query->execute();

      $this->mysql = null;
    }
    //Payment service GET
    function Payment_Service_Update_Get($id) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);

      $this->mysql = null;
    }
    //Payment service update
    function Payment_Service_Update($id, $name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $meal_voucher, $shower_voucher, $types, $meal_amount, $shower_amount, $any) {
      $this->mysql = new MySQL;
      $this->user = new User;

      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("UPDATE pm_services SET service_name = ?, service_price_gross = ?, service_price_net = ?, service_expiry = ?, service_cash = ?, service_card = ?, service_account = ?, service_snap = ?, service_fuel = ?, service_update_author = ?, service_campus = ?, service_mealVoucher = ?, service_showerVoucher = ?, service_vehicles = ?, service_ticket_name = ?, service_meal_amount = ?, service_shower_amount = ?, service_anyvehicle = ? WHERE id = ?");
      $query->bindParam(1, $name);
      $query->bindParam(2, $price_gross);
      $query->bindParam(3, $price_net);
      $query->bindParam(4, $expiry);
      $query->bindParam(5, $cash);
      $query->bindParam(6, $card);
      $query->bindParam(7, $account);
      $query->bindParam(8, $snap);
      $query->bindParam(9, $fuel);
      $query->bindParam(10, $fname);
      $query->bindParam(11, $campus);
      $query->bindParam(12, $meal_voucher);
      $query->bindParam(13, $shower_voucher);
      $query->bindParam(14, $types);
      $query->bindParam(15, $ticket_name);
      $query->bindParam(16, $meal_amount);
      $query->bindParam(17, $shower_amount);
      $query->bindParam(18, $any);
      $query->bindParam(19, $id);
      $query->execute();

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Cash Select menu
    function Payment_ServiceSelect_Cash($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_cash = 1 AND service_campus = ? AND service_vehicles = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_cash = 1 AND service_anyvehicle = 1 AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Cash" id="NT_Payment_Service_Cash" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
      foreach ($stmt2->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Card Select menu
    function Payment_ServiceSelect_Card($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_card = 1 AND service_campus = ? AND service_vehicles = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_card = 1 AND service_anyvehicle = 1 AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Card" id="NT_Payment_Service_Card" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
      foreach ($stmt2->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Account Select menu
    function Payment_ServiceSelect_Account($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_account = 1 AND service_campus = ? AND service_vehicles = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_account = 1 AND service_anyvehicle = 1 AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Account" id="NT_Payment_Service_Account" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
      foreach ($stmt2->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service ETP Select menu
    function Payment_ServiceSelect_SNAP($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_snap = 1 AND service_campus = ? AND service_vehicles = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_snap = 1 AND service_anyvehicle = 1 AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_SNAP" id="NT_Payment_Service_Snap" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
      foreach ($stmt2->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Fuel Select menu
    function Payment_ServiceSelect_Fuel($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_fuel = 1 AND service_campus = ? AND service_vehicles = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_fuel = 1 AND service_anyvehicle = 1 AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Fuel" id="NT_Payment_Service_Fuel" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
      foreach ($stmt2->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Info
    function Payment_ServiceInfo($key, $what) {
      $this->mysql = new MySQL;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE id = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];

      $this->mysql = null;
    }
    //Payment Info
    function PaymentInfo($key, $what) {
      $this->mysql = new MySQL;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_vehicle_plate = ? OR id = ? OR payment_ref = ? AND payment_deleted = 0 ORDER BY id DESC LIMIT 1");
      $stmt->bindParam(1, $key);
      $stmt->bindParam(2, $key);
      $stmt->bindParam(3, $key);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];

      $this->mysql = null;
    }
    //Print Ticket (For reprints)
    function Print_Parking_Ticket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $site, $meal, $shower, $meal_count, $shower_count, $vat) {
      global $_CONFIG;
      $fields_string = "";
      //set POST variables
      $url = $_CONFIG['pm']['url'].'/core/plugins/printer/example/parking_ticket.php';
      $fields = array(
        'ticket_name' => urlencode($ticket_name),
        'gross' => urlencode($gross),
        'net' => urlencode($net),
        'company' => urlencode($company),
        'reg' => urlencode($reg),
        'tid' => urlencode($tid),
        'date' => urlencode($date),
        'expiry' => urlencode($expiry),
        'payment_type' => urlencode($payment_type),
        'site' => urlencode($site),
        'meal' => urlencode($meal),
        'shower' => urlencode($shower),
        'meal_count' => urlencode($meal_count),
        'shower_count' => urlencode($shower_count),
        'vat' => urlencode($vat)
      );

      //url-ify the data for the POST
      foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
      rtrim($fields_string, '&');

      //open connection
      $ch = curl_init();

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

      //execute post
      $result = curl_exec($ch);

      //close connection
      curl_close($ch);
    }
    //Print the ticket via modal click
    function NT_Print_Ticket($key, $plate, $date, $company) {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
      $service = $this->PaymentInfo($plate, "payment_service_id");

      $ticket_name = $this->Payment_ServiceInfo($service, "service_ticket_name");
      $expiryHrs = $this->Payment_ServiceInfo($service, "service_expiry");
      $shower = $this->Payment_ServiceInfo($service, "service_showerVoucher");
      $meal = $this->Payment_ServiceInfo($service, "service_mealVoucher");

      $gross = $this->PaymentInfo($plate, "payment_price_gross");
      $tid = $this->PaymentInfo($plate, "id");
      $type = $this->PaymentInfo($plate, "payment_type");
      $net = $this->PaymentInfo($plate, "payment_price_net");
      $meal_count = $this->Payment_ServiceInfo($service, "service_meal_amount");
      $shower_count = $this->Payment_ServiceInfo($service, "service_shower_amount");
      $expiry = date("Y-m-d H:i:s", strtotime($date.' +'.$expiryHrs.' hours'));

      $site = $this->user->userInfo("campus");
      $vat = $this->pm->PM_SiteInfo($site, "site_vat");

      //$payment_type
      if($type == 1) {
        $payment_type = "Cash";
      } else if ($type == 2) {
        $payment_type = "Card";
      } else if ($type == 3) {
        $payment_type = "Account";
      } else if ($type == 4) {
        $payment_type = "SNAP";
      } else if ($type == 5) {
        $payment_type = "Fuel Card";
      }

      $fields_string = "";
      //set POST variables
      $url = $_CONFIG['pm']['url'].'/core/plugins/printer/example/parking_ticket.php';
      $fields = array(
        'ticket_name' => urlencode($ticket_name),
        'gross' => urlencode($gross),
        'net' => urlencode($net),
        'company' => urlencode($company),
        'reg' => urlencode($plate),
        'tid' => urlencode($tid),
        'date' => urlencode($date),
        'expiry' => urlencode($expiry),
        'payment_type' => urlencode($payment_type),
        'site' => urlencode($site),
        'shower' => urlencode($shower),
        'meal' => urlencode($meal),
        'meal_count' => urlencode($meal_count),
        'shower_count' => urlencode($shower_count),
        'vat' => urlencode($vat)
      );

      //url-ify the data for the POST
      foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
      rtrim($fields_string, '&');

      //open connection
      $ch = curl_init();

      //set the url, number of POST vars, POST data
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

      //execute post
      $result = curl_exec($ch);

      //close connection
      curl_close($ch);

      $this->user = null;
      $this->pm = null;
    }
    //Transaction for cash
    function Transaction_Proccess_Cash($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(1, 9999);
        $payment_ref = $Plate."-".$random_number;
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
      } else {
        //ignore
      }
    }
    //Transaction for Card
    function Transaction_Proccess_Card($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(1, 9999);
        $payment_ref = $Plate."-".$random_number;
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "2", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
      } else {
        //ignore
      }
    }
    //Transaction for Account
    function Transaction_Proccess_Account($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Account_ID) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(1, 9999);
        $payment_ref = $Plate."-".$random_number;
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "3", $Service, $service_name, $price_gross, $price_net, $name, $current_date, $Account_ID, $campus, $payment_ref, null);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
      } else {
        //ignore
      }
    }
    //Transaction for SNAP
    function Transaction_Proccess_SNAP($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $etp) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(1, 9999);
        $payment_ref = $Plate."-".$random_number;
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "4", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, $etp);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
      } else {
        //ignore
      }
    }
    //Transaction for Fuel
    function Transaction_Proccess_Fuel($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $etp) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(1, 9999);
        $payment_ref = $Plate."-".$random_number;
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "5", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, $etp);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->Payment_Parking_LogNew($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
      } else {
        //ignore
      }
    }
    //Renewals
    //Transaction for Cash
    function Transaction_Proccess_Cash_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Expiry) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //ANPR DATE
        $ANPR_Date = $Expiry;
        $current_date = date("Y-m-d H:i:s");

        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($Expiry.'+ '.$service_expiry.' hours'));
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //SQL Payment
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, null);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($ANPRKey, $expiry);
        }

        $pay_id = $this->PaymentInfo($Plate, "id");

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //Transaction for Card
    function Transaction_Proccess_Card_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Expiry) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //ANPR DATE
        $ANPR_Date = $Expiry;
        $current_date = date("Y-m-d H:i:s");

        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($Expiry.'+ '.$service_expiry.' hours'));
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //SQL Payment
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "2", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, null);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($ANPRKey, $expiry);
        }

        $pay_id = $this->PaymentInfo($Plate, "id");

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        //$this->Print_Parking_Ticket($service_ticket_name, $price_gross, $price_net, $Company, $Plate, $pay_id, $ANPR_Date, $expiry, "Card", $campus, $meal, $shower, $meal_count, $shower_count, $site_vat);

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      }
    }
    //Transaction for Account
    function Transaction_Proccess_Account_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Account, $Expiry) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //ANPR DATE
        $ANPR_Date = $Expiry;
        $current_date = date("Y-m-d H:i:s");

        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($Expiry.'+ '.$service_expiry.' hours'));
        //Ticket Info
        $shower = $this->Payment_ServiceInfo($Service, "service_showerVoucher");
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal = $this->Payment_ServiceInfo($Service, "service_mealVoucher");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //SQL Payment
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "3", $Service, $service_name, $price_gross, $price_net, $name, $current_date, $Account, $campus, $PayRef, null);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($ANPRKey, $expiry);
        }

        $pay_id = $this->PaymentInfo($Plate, "id");

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        //$this->Print_Parking_Ticket($service_ticket_name, $price_gross, $price_net, $Company, $Plate, $pay_id, $ANPR_Date, $expiry, "Account", $campus, $meal, $shower, $meal_count, $shower_count, $site_vat);

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //Transaction for SNAP
    function Transaction_Proccess_SNAP_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Account, $Expiry, $etp) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //ANPR DATE
        $ANPR_Date = $Expiry;
        $current_date = date("Y-m-d H:i:s");

        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($Expiry.'+ '.$service_expiry.' hours'));

        //SQL Payment
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "4", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, $etp);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($ANPRKey, $expiry);
        }

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //Transaction for Fuel
    function Transaction_Proccess_Fuel_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Account, $Expiry, $etp) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //ANPR DATE
        $ANPR_Date = $Expiry;
        $current_date = date("Y-m-d H:i:s");

        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $expiry = date("Y-m-d H:i:s", strtotime($Expiry.'+ '.$service_expiry.' hours'));

        //SQL Payment
        $this->Payment_ProcessNew($ANPRKey, $Plate, $Company, "5", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, $etp);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($ANPRKey, $expiry);
        }

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //List all payments
    function Transaction_Log_24() {
      $this->user = new User;
      $this->mysql = new MySQL;
      $this->account = new Account;
      $campus = $this->user->userInfo("campus");

      $date1 = date("Y-m-d 21:00");
      $date2 = date("Y-m-d 21:00", strtotime('-24 hours'));

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_date BETWEEN ? AND ? AND payment_deleted = 0 ORDER BY payment_date DESC");
      $query->bindParam(1, $campus);
      $query->bindParam(2, $date2);
      $query->bindParam(3, $date1);
      $query->execute();

      $result = $query->fetchAll();

      $html = '<tr>';
      foreach ($result as $row) {
        if($row['payment_type'] == 1) {
          $type = "Cash";
        } else if ($row['payment_type'] == 2) {
          $type = "Card";
        } else if ($row['payment_type'] == 3) {
          $type = "Account";
        } else if ($row['payment_type'] == 4) {
          $type = "SNAP";
        } else if ($row['payment_type'] == 5) {
          $type = "Fuel";
        }

        $html .= '<td>'.$row['payment_company_name'].'</td>';
        $html .= '<td>'.$row['payment_vehicle_plate'].'</td>';
        $html .= '<td>'.$row['payment_service_name'].'</td>';
        $html .= '<td>'.$type.'</td>';
        $html .= '<td> £'.$row['payment_price_gross'].'</td>';
        $html .= '<td> £'.$row['payment_price_net'].'</td>';
        $html .= '<td>'.date("d/H:i", strtotime($row['payment_date'])).'</td>';
        $html .= '<td>'.$row['payment_ref'].'</td>';
        $html .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
        $html .= '<td>'.$row['payment_author'].'</td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                    <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                    <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                  </td>';
        $html .= '</tr>';
      }

      echo $html;

      $this->user = null;
      $this->mysql = null;
      $this->account = null;
    }
    //Delete Transaction
    function Payment_Delete($key, $comment) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $this->mssql = new MSSQL;
      $this->anpr = new ANPR;
      $this->vehicles = new Vehicles;

      $user = $this->user->userInfo("first_name");
      $service = $this->PaymentInfo($key, "payment_service_id");
      $anprkey = $this->PaymentInfo($key, "payment_anprkey");

      $service_expiry = $this->Payment_ServiceInfo($service, "service_expiry");
      $q = $this->mysql->dbc->prepare("SELECT parked_expiry FROM pm_parking_log WHERE parked_anprkey = ?");
      $q->bindParam(1, $anprkey);
      $q->execute();

      $return = $q->fetch(\PDO::FETCH_ASSOC);
      $expiry = $return['parked_expiry'];
      $new_expiry = date("Y-m-d H:i:s", strtotime($expiry.' - '.$service_expiry.' hours'));

      $query = $this->mysql->dbc->prepare("UPDATE pm_payments SET payment_deleted = 1, payment_deleted_comment = ? WHERE id = ?");
      $query->bindParam(1, $comment);
      $query->bindParam(2, $key);
      if($query->execute()) {
        $this->anpr->ANPR_Expiry_Set($anprkey, $new_expiry);
        $this->vehicles->Parking_Log_Expiry_Update($anprkey, $new_expiry);
        $this->pm->PM_Notification_Create("$user has successfully deleted a transaction. ID: $key", 1);
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
      $this->anpr = null;
      $this->vehicles = null;
    }
    //Reprint a parking ticket with information gathered in pm_tickets
    function Reprint_Ticket($pay_id) {
      $this->mysql = new MySQL;
      $this->vehicles = new Vehicles;
      $this->pm = new PM;

      if(!empty($pay_id)) {
        //Ticket Query
        $TicketInfo = $this->mysql->dbc->prepare("SELECT * FROM pm_tickets WHERE ticket_tid = ?");
        $TicketInfo->bindParam(1, $pay_id);
        $TicketInfo->execute();
        $Ticket_Result = $TicketInfo->fetch(\PDO::FETCH_ASSOC);

        $service_id = $this->PaymentInfo($pay_id, "payment_service_id");
        $paid = $this->PaymentInfo($pay_id, "payment_type");
        $Plate = $this->PaymentInfo($pay_id, "payment_vehicle_plate");
        $Company = $this->PaymentInfo($pay_id, "payment_company_name");
        $price_gross = $this->PaymentInfo($pay_id, "payment_price_gross");
        $price_net = $this->PaymentInfo($pay_id, "payment_price_net");
        $site = $this->PaymentInfo($pay_id, "payment_campus");
        $vatno = $this->pm->PM_SiteInfo($site, "site_vat");
        $date = $Ticket_Result['ticket_date'];
        $expiry = $Ticket_Result['ticket_expiry'];
        $shower = $this->Payment_ServiceInfo($service_id, "service_showerVoucher");
        $meal = $this->Payment_ServiceInfo($service_id, "service_mealVoucher");
        $shower_count = $this->Payment_ServiceInfo($service_id, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($service_id, "service_meal_amount");
        $ticket_name = $this->Payment_ServiceInfo($service_id, "service_ticket_name");

        if($paid == 1) {
          $payment_type = "Cash";
        } else if ($paid == 2) {
          $payment_type = "Card";
        } else if ($paid == 3) {
          $payment_type = "Account";
        } else if ($paid == 4) {
          $payment_type = "SNAP";
        } else if ($paid == 5) {
          $payment_type = "Fuel Card";
        }

        $this->Print_Parking_Ticket($ticket_name, $price_gross, $price_net, $Company, $Plate, $pay_id, $date, $expiry, $payment_type, $site, $meal, $shower, $meal_count, $shower_count, $vatno);
      }

      $this->mysql = null;
      $this->vehicles = null;
      $this->pm = null;
    }
  }
?>
