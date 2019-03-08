<?php

  namespace ParkingManager;

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
    function Payment_GetTransactions($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT id, payment_type, payment_service_name, payment_author, payment_date FROM pm_payments WHERE payment_ref = ? AND payment_deleted = 0 ORDER BY payment_date DESC");
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
    function Payment_Services_List($site) {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types ORDER BY id ASC");
      $query->execute();
      $result = $query->fetchAll();
      $html = '';
      //Misc
      $html .= '<tr class="table table-primary"><td colspan="15">Misc (All Vehicles)</td></tr>';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_vehicles = 0 AND service_campus = ? AND service_deleted < 1 ORDER BY service_expiry, service_active ASC");
      $query->bindParam(1, $site);
      $query->execute();
      foreach($query->fetchAll() as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['service_name'].'</td>';
        $html .= '<td>£'.$row['service_price_gross'].'</td>';
        $html .= '<td>£'.$row['service_price_net'].'</td>';
        if($row['service_cash'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        if($row['service_card'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        if($row['service_account'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        if($row['service_snap'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        if($row['service_fuel'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        $html .= '<td class="">'.$row['service_meal_amount'].'</td>';
        $html .= '<td class="">'.$row['service_shower_amount'].'</td>';
        $html .= '<td class="">'.$row['service_discount_amount'].'</td>';
        $html .= '<td class="">'.$row['service_wifi_amount'].'</td>';
        $html .= '<td class="">'.$row['service_etpid'].'</td>';
        if($row['service_active'] == 1) {
          $html .= '<td class="table-success">YES</td>';
        } else {
          $html .= '<td class="table-danger">NO</td>';
        }
        $html .= '<td>
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
        $html .= '</tr>';
      }

      //Query types
      foreach($result as $type) {
        $id = $type['id'];
        $html .= '<tr class="table table-primary"><td colspan="15">'.$type['type_name'].'</td></tr>';
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_vehicles = ? AND service_campus = ? ORDER BY service_expiry, service_price_gross ASC");
        $query->bindParam(1, $id);
        $query->bindParam(2, $site);
        $query->execute();
        foreach($query->fetchAll() as $row) {
          $html .= '<tr class="">';
          $html .= '<td>'.$row['service_name'].'</td>';
          $html .= '<td>£'.$row['service_price_gross'].'</td>';
          $html .= '<td>£'.$row['service_price_net'].'</td>';
          if($row['service_cash'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          if($row['service_card'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          if($row['service_account'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          if($row['service_snap'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          if($row['service_fuel'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          $html .= '<td class="">'.$row['service_meal_amount'].'</td>';
          $html .= '<td class="">'.$row['service_shower_amount'].'</td>';
          $html .= '<td class="">'.$row['service_discount_amount'].'</td>';
          $html .= '<td class="">'.$row['service_wifi_amount'].'</td>';
          $html .= '<td class="">'.$row['service_etpid'].'</td>';
          if($row['service_active'] == 1) {
            $html .= '<td class="table-success">YES</td>';
          } else {
            $html .= '<td class="table-danger">NO</td>';
          }
          $html .= '<td>
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
          $html .= '</tr>';
        }
      }

      echo $html;
      $this->mysql = null;
      $this->pm = null;
    }
    //Add services
    function Payment_Services_New($name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $meal_amount, $shower_amount, $group, $vehicles, $etpid, $active, $wifi_amount, $discount_amount) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $date = date("Y-m-d H:i");
      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_services (service_name, service_ticket_name, service_price_gross, service_price_net, service_expiry, service_cash, service_card, service_account, service_snap, service_fuel, service_author, service_created, service_update_author, service_campus, service_meal_amount, service_shower_amount, service_vehicles, service_group, service_etpid, service_active, service_wifi_amount, service_discount_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
      $query->bindParam(15, $meal_amount);
      $query->bindParam(16, $shower_amount);
      $query->bindParam(17, $vehicles);
      $query->bindParam(18, $group);
      $query->bindParam(19, $etpid);
      $query->bindParam(20, $active);
      $query->bindParam(21, $wifi_amount);
      $query->bindParam(22, $discount_amount);
      if($query->execute()) {
        echo "Executed successfully";
      } else {
        echo "Executed unsuccessfully";
      }

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Groups
    function Payment_Service_Group_Dropdown() {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services_groups");
      $query->execute();

      $html = '<option value="unchecked">-- Please choose a group --</option>';
      foreach ($query->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['group_name'].'</option>';
      }

      echo $html;

      $this->mysql = null;
    }
    //Delete services
    function Payment_Services_Delete($key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("UPDATE pm_services SET service_deleted = 1 WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();

      $this->mysql = null;
    }
    //Add Transaction
    function Payment_Transaction_Add($ANPRKey, $plate, $company, $pay_type, $service, $service_name, $gross, $net, $author, $date, $account, $campus, $ref, $etp, $group, $vehicle_type) {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $sqlPayment = $this->mysql->dbc->prepare("INSERT INTO pm_payments (payment_anprkey, payment_vehicle_plate, payment_company_name, payment_type, payment_service_id, payment_service_name, payment_price_gross, payment_price_net, payment_author, payment_date, payment_account_id, payment_campus, payment_ref, payment_etp_id, payment_deleted, payment_deleted_comment, payment_service_group, payment_vehicle_type) VALUES (:ANPRKey, :Plate, :Company, :Type, :Service_ID, :Service_Name, :Price_Gross, :Price_Net, :Author, :Cur_Date, :Account, :Campus, :PayRef, :ETP, '0', '', :Group, :Vehicle_Type)");
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
      $sqlPayment->bindParam(':Group', $group);
      $sqlPayment->bindParam(':Vehicle_Type', $vehicle_type);
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
    function Payment_Service_Update($id, $name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $types, $meal_amount, $shower_amount, $group, $etpid, $active, $wifi_amount, $discount_amount) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("UPDATE pm_services SET service_name = ?, service_price_gross = ?, service_price_net = ?, service_expiry = ?, service_cash = ?, service_card = ?, service_account = ?, service_snap = ?, service_fuel = ?, service_update_author = ?, service_campus = ?, service_vehicles = ?, service_ticket_name = ?, service_meal_amount = ?, service_shower_amount = ?, service_group = ?, service_etpid = ?, service_active = ?, service_wifi_amount = ?, service_discount_amount = ? WHERE id = ?");
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
      $query->bindParam(12, $types);
      $query->bindParam(13, $ticket_name);
      $query->bindParam(14, $meal_amount);
      $query->bindParam(15, $shower_amount);
      $query->bindParam(16, $group);
      $query->bindParam(17, $etpid);
      $query->bindParam(18, $active);
      $query->bindParam(19, $wifi_amount);
      $query->bindParam(20, $discount_amount);
      $query->bindParam(21, $id);
      if($query->execute()) {
        echo "Successful";
      } else {
        echo "Unsuccessful";
      }

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Cash Select menu
    function Payment_ServiceSelect_Cash($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_cash = 1 AND service_campus = ? AND service_vehicles = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_cash = 1 AND service_vehicles = 0 AND service_campus = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_card = 1 AND service_campus = ? AND service_vehicles = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_card = 1 AND service_vehicles = 0 AND service_campus = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_account = 1 AND service_campus = ? AND service_vehicles = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_account = 1 AND service_vehicles = 0 AND service_campus = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_snap = 1 AND service_campus = ? AND service_vehicles = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_snap = 1 AND service_vehicles = 0 AND service_campus = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_SNAP" id="NT_Payment_Service_SNAP" required>';
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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_fuel = 1 AND service_campus = ? AND service_vehicles = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $vehicle);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_fuel = 1 AND service_vehicles = 0 AND service_campus = ? AND service_active = 1 AND service_deleted = 0 ORDER BY service_expiry, service_price_gross ASC");
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
    //Print the ticket via modal click
    function NT_Print_Ticket($key, $plate, $date, $company) {
      $this->user = new User;
      $this->pm = new PM;
      $this->ticket = new Ticket;
      $this->vehicles = new Vehicles;

      $service = $this->PaymentInfo($plate, "payment_service_id");

      $ticket_name = $this->Payment_ServiceInfo($service, "service_ticket_name");
      $expiryHrs = $this->Payment_ServiceInfo($service, "service_expiry");

      $exitKey = $this->vehicles->vehInfo("parked_exitKey", $key);
      $gross = $this->PaymentInfo($plate, "payment_price_gross");
      $tid = $this->PaymentInfo($plate, "id");
      $type = $this->PaymentInfo($plate, "payment_type");
      $net = $this->PaymentInfo($plate, "payment_price_net");
      $meal_count = $this->Payment_ServiceInfo($service, "service_meal_amount");
      $shower_count = $this->Payment_ServiceInfo($service, "service_shower_amount");
      $discount_count = $this->Payment_ServiceInfo($service, "service_discount_amount");
      $wifi_count = $this->Payment_ServiceInfo($service, "service_discount_amount");
      $group = $this->Payment_ServiceInfo($service, "service_group");
      $discount_count = $this->Payment_ServiceInfo($service, "service_discount_amount");
      $wifi_count = $this->Payment_ServiceInfo($service, "service_wifi_amount");
      $expiry = date("Y-m-d H:i:s", strtotime($date.' +'.$expiryHrs.' hours'));

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
      //Finally, print ticket
      $this->ticket->Direction($ticket_name, $gross, $net, $company, $plate, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $group, $exitKey, $discount_count, $wifi_count);
      //die("PRINTED?");
      $this->user = null;
      $this->pm = null;
      $this->ticket = null;
    }
    //Transaction for cash
    function Transaction_Proccess_Cash($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ANPRKey);
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
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null, $group, $Vehicle_Type);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->vehicles->Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

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
        $this->vehicles = new Vehicles;

        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "2", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, null, $group, $Vehicle_Type);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->vehicles->Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
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
        $this->vehicles = new Vehicles;

        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        //Insert Payment data
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "3", $Service, $service_name, $price_gross, $price_net, $name, $current_date, $Account_ID, $campus, $payment_ref, null, $group, $Vehicle_Type);

        $ref = $this->PaymentInfo($Plate, "payment_ref");
        $pay_id = $this->PaymentInfo($Plate, "id");

        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        $sql_anprTbl->execute();


        //Create new parking log information.
        $this->vehicles->Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

        $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //Transaction for SNAP
    function Transaction_Proccess_SNAP($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        $this->etp = new ETP;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $etpid = $this->Payment_ServiceInfo($Service, "service_etpid");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");

        $return = $this->etp->Proccess_Transaction_SNAP($etpid, $Plate, $Company);
        if($return == FALSE) {
          echo 0;
        } else {
          //Insert Payment data
          $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "4", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, $return, $group, $Vehicle_Type);

          $ref = $this->PaymentInfo($Plate, "payment_ref");
          $pay_id = $this->PaymentInfo($Plate, "id");

          //ANPR DB SQL
          $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
          $sql_anprTbl->bindParam(1, $expiry);
          $sql_anprTbl->bindParam(2, $ANPRKey);
          $sql_anprTbl->execute();

          //Create new parking log information.
          $this->vehicles->Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

          $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);
          echo 1;
        }

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
        $this->etp = null;
        $this->vehicles = null;
      } else {
        //ignore
      }
    }
    //Transaction for Fuel
    function Transaction_Proccess_Fuel($ANPRKey, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $FuelCardno, $CardExpiry) {
      if(!empty($ANPRKey)) {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->anpr = new ANPR;
        $this->user = new User;
        $this->pm = new PM;
        $this->etp = new ETP;
        $this->vehicles = new Vehicles;
        //Misc dets
        $current_date = date("Y-m-d H:i:s");
        $Company = strtoupper($Company);
        $Plate = strtoupper($Plate);
        //ANPR Dets
        $anprInfo = $this->anpr->ANPR_GetRecord($ANPRKey);
        $ANPR_Date = $anprInfo['Capture_Date'];
        //User Details
        $name = $this->user->userInfo("first_name");
        $campus = $this->user->userInfo("campus");
        //Payment Service Details
        $service_expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
        $service_name = $this->Payment_ServiceInfo($Service, "service_name");
        $price_gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
        $price_net = $this->Payment_ServiceInfo($Service, "service_price_net");
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $etpid = $this->Payment_ServiceInfo($Service, "service_etpid");
        $expiry = date("Y-m-d H:i:s", strtotime($ANPR_Date.'+ '.$service_expiry.' hours'));
        $random_number = mt_rand(111111, 999999);
        $payment_ref = $Plate."-".$random_number;
        $exitKey = mt_rand(111111, 999999);
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
        $site_vat = $this->pm->PM_SiteInfo($campus, "site_vat");
        $result = $this->etp->Proccess_Transaction_Fuel($etpid, $Plate, $Company, $FuelCardno, $CardExpiry);
        if($result != FALSE) {
          //Insert Payment data
          $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "5", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $payment_ref, $result, $group, $Vehicle_Type);

          $ref = $this->PaymentInfo($Plate, "payment_ref");
          $pay_id = $this->PaymentInfo($Plate, "id");

          //ANPR DB SQL
          $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
          $sql_anprTbl->bindParam(1, $expiry);
          $sql_anprTbl->bindParam(2, $ANPRKey);
          $sql_anprTbl->execute();

          //Create new parking log information.
          $this->vehicles->Vehicles_Parking_New($ANPRKey, $ref, $Plate, $Trailer, $Vehicle_Type, $Company, $ANPR_Date, $expiry, $name, $campus, $exitKey);

          $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);
          echo 1;
        } else {
          echo 0;
        }

        $this->mysql = null;
        $this->mssql = null;
        $this->anpr = null;
        $this->user = null;
        $this->pm = null;
        $this->etp = null;
        $this->vehicles = null;
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
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");

        $this->vehicles->Vehicle_Update_Type($LogID, $Vehicle_Type);

        //SQL Payment
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "1", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, null, $group, $Vehicle_Type);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($PayRef, $expiry);
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
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");

        $this->vehicles->Vehicle_Update_Type($LogID, $Vehicle_Type);

        //SQL Payment
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "2", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, null, $group, $Vehicle_Type);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($PayRef, $expiry);
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
        $group = $this->Payment_ServiceInfo($Service, "service_group");

        //Ticket Info
        $shower_count = $this->Payment_ServiceInfo($Service, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($Service, "service_meal_amount");
        $service_ticket_name = $this->Payment_ServiceInfo($Service, "service_ticket_name");

        $this->vehicles->Vehicle_Update_Type($LogID, $Vehicle_Type);

        //SQL Payment
        $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "3", $Service, $service_name, $price_gross, $price_net, $name, $current_date, $Account, $campus, $PayRef, null, $group, $Vehicle_Type);
        //ANPR DB SQL
        $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $sql_anprTbl->bindParam(1, $expiry);
        $sql_anprTbl->bindParam(2, $ANPRKey);
        if($sql_anprTbl->execute()) {
          $this->vehicles->Parking_Log_Expiry_Update($PayRef, $expiry);
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
    //Transaction for SNAP (w/ API)
    function Transaction_Proccess_SNAP_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Expiry) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        $this->etp = new ETP;
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
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $etpid = $this->Payment_ServiceInfo($Service, "service_etpid");

        $this->vehicles->Vehicle_Update_Type($LogID, $Vehicle_Type);

        $return = $this->etp->Proccess_Transaction_SNAP($etpid, $Plate, $Company);
        if($return == FALSE) {
          echo 0;
          //echo "TRANSACTION NOT ADDED";
        } else {
          //SQL Payment
          $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "4", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, $return, $group, $Vehicle_Type);
          //ANPR DB SQL
          $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
          $sql_anprTbl->bindParam(1, $expiry);
          $sql_anprTbl->bindParam(2, $ANPRKey);
          if($sql_anprTbl->execute()) {
            $this->vehicles->Parking_Log_Expiry_Update($PayRef, $expiry);
          }
          $pay_id = $this->PaymentInfo($Plate, "id");

          $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);
          echo 1;
        }

        $this->mssql = null;
        $this->user = null;
        $this->pm = null;
        $this->vehicles = null;
        $this->etp = null;
      } else {
        //ignore
      }
    }
    //Transaction for Fuel
    function Transaction_Proccess_Fuel_Renewal($LogID, $ANPRKey, $PayRef, $Plate, $Company, $Trailer, $Vehicle_Type, $Service, $Expiry, $FuelCard, $CardExpiry) {
      if(!empty($ANPRKey)) {
        $this->mssql = new MSSQL;
        $this->user = new User;
        $this->pm = new PM;
        $this->vehicles = new Vehicles;
        $this->etp = new ETP;
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
        $group = $this->Payment_ServiceInfo($Service, "service_group");
        $etpid = $this->Payment_ServiceInfo($Service, "service_etpid");

        $result = $this->etp->Proccess_Transaction_Fuel($etpid, $Plate, $Company, $FuelCard, $CardExpiry);
        if($result != FALSE) {
          $Vehicle_Type = $this->vehicles->Vehicle_Update_Type($LogID, $Vehicle_Type);
          //SQL Payment
          $this->Payment_Transaction_Add($ANPRKey, $Plate, $Company, "5", $Service, $service_name, $price_gross, $price_net, $name, $current_date, null, $campus, $PayRef, $result, $group, $Vehicle_Type);
          //ANPR DB SQL
          $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
          $sql_anprTbl->bindParam(1, $expiry);
          $sql_anprTbl->bindParam(2, $ANPRKey);
          if($sql_anprTbl->execute()) {
            $this->vehicles->Parking_Log_Expiry_Update($PayRef, $expiry);
          }
          $pay_id = $this->PaymentInfo($Plate, "id");

          $this->Payment_Ticket_Info($pay_id, "0", $current_date, $ANPR_Date, $expiry);
          echo 1;
        } else {
          echo 0;
        }
      }
      $this->mssql = null;
      $this->user = null;
      $this->pm = null;
      $this->vehicles = null;
      $this->etp = null;
    }
    //List all payments
    function Transaction_Log($date1, $date2, $cash, $card, $account, $snap, $fuel, $group, $pm9, $price_filter) {
      $this->user = new User;
      $this->mysql = new MySQL;
      $this->account = new Account;
      // $this->account = new Account;
      $campus = $this->user->userInfo("campus");

      $cash_count = 0;
      $card_count = 0;
      $acc_count = 0;
      $snap_count = 0;
      $fuel_count = 0;
      $total_net = 0;
      $total_gross = 0;

      if($pm9 > 0) {
        if($campus == 2) {
          $date1 = date("Y-m-d 21:30:00", strtotime($date1));
          $date2 = date("Y-m-d 21:30:00", strtotime($date2));
        } else {
          $date1 = date("Y-m-d 21:00:00", strtotime($date1));
          $date2 = date("Y-m-d 21:00:00", strtotime($date2));
        }
      } else {
        $date1 = date("Y-m-d 00:00:00", strtotime($date1));
        $date2 = date("Y-m-d 23:59:59", strtotime($date2));
      }

      $html = '';
      $stat = '';
      $html2 = '';

      if($price_filter != "0.00") {
        $query = $this->mysql->dbc->prepare("SELECT id, payment_company_name, payment_vehicle_plate, payment_service_name, payment_type, payment_price_gross, payment_price_net, payment_date, payment_ref, payment_account_id, payment_author, payment_deleted, payment_deleted_comment FROM pm_payments WHERE payment_campus = ? AND payment_price_gross = ? AND payment_date BETWEEN ? AND ? ORDER BY payment_date, payment_type DESC");
        $query->bindParam(1, $campus);
        $query->bindParam(2, $price_filter);
        $query->bindParam(3, $date1);
        $query->bindParam(4, $date2);
      } else if($group == 0) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_date BETWEEN ? AND ? ORDER BY payment_date, payment_type DESC");
        $query->bindParam(1, $campus);
        $query->bindParam(2, $date1);
        $query->bindParam(3, $date2);
      } else {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_service_group = ? AND payment_date BETWEEN ? AND ? ORDER BY payment_date, payment_type DESC");
        $query->bindParam(1, $campus);
        $query->bindParam(2, $group);
        $query->bindParam(3, $date1);
        $query->bindParam(4, $date2);
      }
      $query->execute();

      $html .= '<div class="row">
                  <div class="col-md-12">
                    <table class="table table-dark table-hover table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">T.ID</th>
                          <th scope="col">Company</th>
                          <th scope="col">Plate</th>
                          <th scope="col">Payment Service Name</th>
                          <th scope="col">Paid</th>
                          <th scope="col">Gross</th>
                          <th scope="col">Net</th>
                          <th scope="col">Date</th>
                          <th scope="col">Payment Ref</th>
                          <th scope="col">Account</th>
                          <th scope="col">Author</th>
                          <th scope="col"><i class="fa fa-cog"></i></th>
                        </tr>
                      </thead>';
      $html .= '<tbody>';

      foreach ($query->fetchAll() as $row) {
        $total_net += $row['payment_price_net'];
        $total_gross += $row['payment_price_gross'];
        $paid = $row['payment_type'];
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
        //Is deleted
        if($row['payment_deleted'] == 1) {
          $style = 'table-danger';
          $comment = '<i class="fa fa-trash" title="'.$row['payment_deleted_comment'].'"></i>';
        } else {
          $style = '';
          $comment = '';
        }

        if($row['payment_type'] == 1 AND $cash == 1) {
          $cash_count++;
          $html2 .= '<tr class="'.$style.'">';
          $html2 .= '<td>'.$row['id'].'</td>';
          $html2 .= '<td>'.$row['payment_company_name']." ".$comment.'</td>';
          $html2 .= '<td>'.$row['payment_vehicle_plate'].'</td>';
          $html2 .= '<td>'.$row['payment_service_name'].'</td>';
          $html2 .= '<td>'.$payment_type.'</td>';
          $html2 .= '<td>'.$row['payment_price_gross'].'</td>';
          $html2 .= '<td>'.$row['payment_price_net'].'</td>';
          $html2 .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
          $html2 .= '<td>'.$row['payment_ref'].'</td>';
          $html2 .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
          $html2 .= '<td>'.$row['payment_author'].'</td>';
          $html2 .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                      <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                      <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div>
                    </td>';
          $html2 .= '</tr>';
        } else if($row['payment_type'] == 2 AND $card == 1) {
          $card_count++;
          $html2 .= '<tr class="'.$style.'">';
          $html2 .= '<td>'.$row['id'].'</td>';
          $html2 .= '<td>'.$row['payment_company_name']." ".$comment.'</td>';
          $html2 .= '<td>'.$row['payment_vehicle_plate'].'</td>';
          $html2 .= '<td>'.$row['payment_service_name'].'</td>';
          $html2 .= '<td>'.$payment_type.'</td>';
          $html2 .= '<td>'.$row['payment_price_gross'].'</td>';
          $html2 .= '<td>'.$row['payment_price_net'].'</td>';
          $html2 .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
          $html2 .= '<td>'.$row['payment_ref'].'</td>';
          $html2 .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
          $html2 .= '<td>'.$row['payment_author'].'</td>';
          $html2 .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                      <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                      <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div>
                    </td>';
          $html2 .= '</tr>';
        } else if($row['payment_type'] == 3 AND $account == 1) {
          $acc_count++;
          $html2 .= '<tr class="'.$style.'">';
          $html2 .= '<td>'.$row['id'].'</td>';
          $html2 .= '<td>'.$row['payment_company_name']." ".$comment.'</td>';
          $html2 .= '<td>'.$row['payment_vehicle_plate'].'</td>';
          $html2 .= '<td>'.$row['payment_service_name'].'</td>';
          $html2 .= '<td>'.$payment_type.'</td>';
          $html2 .= '<td>'.$row['payment_price_gross'].'</td>';
          $html2 .= '<td>'.$row['payment_price_net'].'</td>';
          $html2 .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
          $html2 .= '<td>'.$row['payment_ref'].'</td>';
          $html2 .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
          $html2 .= '<td>'.$row['payment_author'].'</td>';
          $html2 .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                      <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                      <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div>
                    </td>';
          $html2 .= '</tr>';
        } else if($row['payment_type'] == 4 AND $snap == 1) {
          $snap_count++;
          $html2 .= '<tr class="'.$style.'">';
          $html2 .= '<td>'.$row['id'].'</td>';
          $html2 .= '<td>'.$row['payment_company_name']." ".$comment.'</td>';
          $html2 .= '<td>'.$row['payment_vehicle_plate'].'</td>';
          $html2 .= '<td>'.$row['payment_service_name'].'</td>';
          $html2 .= '<td>'.$payment_type.'</td>';
          $html2 .= '<td>'.$row['payment_price_gross'].'</td>';
          $html2 .= '<td>'.$row['payment_price_net'].'</td>';
          $html2 .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
          $html2 .= '<td>'.$row['payment_ref'].'</td>';
          $html2 .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
          $html2 .= '<td>'.$row['payment_author'].'</td>';
          $html2 .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                      <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                      <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div>
                    </td>';
          $html2 .= '</tr>';
        } else if($row['payment_type'] == 5 AND $fuel == 1) {
          $fuel_count++;
          $html2 .= '<tr class="'.$style.'">';
          $html2 .= '<td>'.$row['id'].'</td>';
          $html2 .= '<td>'.$row['payment_company_name']." ".$comment.'</td>';
          $html2 .= '<td>'.$row['payment_vehicle_plate'].'</td>';
          $html2 .= '<td>'.$row['payment_service_name'].'</td>';
          $html2 .= '<td>'.$payment_type.'</td>';
          $html2 .= '<td>'.$row['payment_price_gross'].'</td>';
          $html2 .= '<td>'.$row['payment_price_net'].'</td>';
          $html2 .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
          $html2 .= '<td>'.$row['payment_ref'].'</td>';
          $html2 .= '<td>'.$this->account->Account_GetInfo($row['payment_account_id'], "account_name").'</td>';
          $html2 .= '<td>'.$row['payment_author'].'</td>';
          $html2 .= '<td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                      <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                      <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div>
                    </td>';
          $html2 .= '</tr>';
        } else {
          //nothing
        }
      }
      $stat .= '<tr class="table table-success" style="color: #000;">
                  <td colspan="2">Cash: '.$cash_count.'</td>
                  <td colspan="1">Card: '.$card_count.'</td>
                  <td colspan="1">Account: '.$acc_count.'</td>
                  <td colspan="2">SNAP: '.$snap_count.'</td>
                  <td colspan="2">Fuel: '.$fuel_count.'</td>
                  <td colspan="2">Total Net: £'.number_format($total_net, 2).'</td>
                  <td colspan="3">Total Gross: £'.number_format($total_gross, 2).'</td>
                </tr>';
      $html2 .= '</tbody>';
      $html2 .= '</table>
              </div>
            </div>';

      echo $html;
      echo $stat;
      echo $html2;

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
      $ref = $this->PaymentInfo($key, "payment_ref");
      $anprkey = $this->PaymentInfo($key, "payment_anprkey");

      $service_expiry = $this->Payment_ServiceInfo($service, "service_expiry");
      $q = $this->mysql->dbc->prepare("SELECT parked_expiry FROM pm_parking_log WHERE payment_ref = ?");
      $q->bindParam(1, $ref);
      $q->execute();

      $return = $q->fetch(\PDO::FETCH_ASSOC);
      $expiry = $return['parked_expiry'];
      $new_expiry = date("Y-m-d H:i:s", strtotime($expiry.' - '.$service_expiry.' hours'));

      $query = $this->mysql->dbc->prepare("UPDATE pm_payments SET payment_deleted = 1, payment_deleted_comment = ? WHERE id = ?");
      $query->bindParam(1, $comment);
      $query->bindParam(2, $key);
      if($query->execute()) {
        $this->anpr->ANPR_Expiry_Set($anprkey, $new_expiry);
        $this->vehicles->Parking_Log_Expiry_Update($ref, $new_expiry);
        $this->pm->PM_Notification_Create("$user has successfully deleted a transaction. ID: $key", 1);
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
      $this->anpr = null;
      $this->vehicles = null;
    }
    //Reprint a parking ticket with information gathered in pm_tickets (Uses new Ticket.class)
    function Reprint_Ticket($pay_id) {
      $this->mysql = new MySQL;
      $this->vehicles = new Vehicles;
      $this->pm = new PM;
      $this->ticket = new Ticket;

      if(!empty($pay_id)) {
        //Ticket Query
        $TicketInfo = $this->mysql->dbc->prepare("SELECT * FROM pm_tickets WHERE ticket_tid = ?");
        $TicketInfo->bindParam(1, $pay_id);
        $TicketInfo->execute();
        $Ticket_Result = $TicketInfo->fetch(\PDO::FETCH_ASSOC);

        $anpr = $this->PaymentInfo($pay_id, "payment_anprkey");
        $exitKey = $this->vehicles->vehInfo("parked_exitKey", $anpr);

        $service_id = $this->PaymentInfo($pay_id, "payment_service_id");
        $paid = $this->PaymentInfo($pay_id, "payment_type");
        $Plate = $this->PaymentInfo($pay_id, "payment_vehicle_plate");
        $Company = $this->PaymentInfo($pay_id, "payment_company_name");
        $price_gross = $this->PaymentInfo($pay_id, "payment_price_gross");
        $price_net = $this->PaymentInfo($pay_id, "payment_price_net");
        $date = $Ticket_Result['ticket_date'];
        $expiry = $Ticket_Result['ticket_expiry'];
        $shower_count = $this->Payment_ServiceInfo($service_id, "service_shower_amount");
        $meal_count = $this->Payment_ServiceInfo($service_id, "service_meal_amount");
        $ticket_name = $this->Payment_ServiceInfo($service_id, "service_ticket_name");
        $group = $this->Payment_ServiceInfo($service_id, "service_group");
        $discount_count = $this->Payment_ServiceInfo($service_id, "service_discount_amount");
        $wifi_count = $this->Payment_ServiceInfo($service_id, "service_wifi_amount");

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
        $this->ticket->Direction($ticket_name, $price_gross, $price_net, $Company, $Plate, $pay_id, $date, $expiry, $payment_type, $meal_count, $shower_count, $group, $exitKey, $discount_count, $wifi_count);

      }

      $this->mysql = null;
      $this->vehicles = null;
      $this->pm = null;
      $this->ticket = null;
    }
    //Search PM Logs
    function PM_PaymentSearch($key) {
      $string = '%'.$key.'%';
      $html = '';
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->campus = $this->user->userInfo("campus");
      $stmt = $this->mysql->dbc->prepare("SELECT id, payment_company_name, payment_vehicle_plate, payment_service_name, payment_date, payment_deleted FROM pm_payments WHERE payment_vehicle_plate LIKE ? AND payment_campus = ? OR id LIKE ? AND payment_campus = ? OR payment_etp_id LIKE ? AND payment_campus = ? ORDER BY payment_date DESC LIMIT 100");
      $stmt->bindParam(1, $string);
      $stmt->bindParam(2, $this->campus);
      $stmt->bindParam(3, $string);
      $stmt->bindParam(4, $this->campus);
      $stmt->bindParam(5, $string);
      $stmt->bindParam(6, $this->campus);
      $stmt->execute();
      $result = $stmt->fetchAll();

      if(count($result) > 0) {
        $html .= '
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">T.ID</th>
                <th scope="col">Company</th>
                <th scope="col">Plate</th>
                <th scope="col">Service</th>
                <th scope="col">Date</th>
                <th scope="col"><i class="fa fa-cog"></i></th>
              </tr>
            </thead>
          ';
          $html .= '<tbody>';
          foreach($result as $row) {
            if($row['payment_deleted'] == 0) {
              $html .= '
                <tr>
                  <td>'.$row['id'].'</td>
                  <td>'.$row['payment_company_name'].'</td>
                  <td>'.$row['payment_vehicle_plate'].'</td>
                  <td>'.$row['payment_service_name'].'</td>
                  <td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>
                  <td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                    <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                    <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                  </div></td>
                </tr>';
            } else if($row['payment_deleted'] == 1) {
              $html .= '
                <tr class="table table-danger">
                  <td>'.$row['id'].'</td>
                  <td>'.$row['payment_company_name'].'</td>
                  <td>'.$row['payment_vehicle_plate'].'</td>
                  <td>'.$row['payment_service_name'].'</td>
                  <td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>
                  <td><div class="btn-group" role="group" aria-label="Payment_Table_Options">
                    <button type="button" onClick="Reprint_Ticket('.$row['id'].')" class="btn btn-danger"><i class="fa fa-print"></i></button>
                    <button type="button" onClick="Payment_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                  </div></td>
                </tr>';
            }
          }
          $html .= '</tbody></table>';
          echo $html;
      } else {
          echo 'No Data Found';
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
  }
?>
