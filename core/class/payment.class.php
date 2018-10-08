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
    function getTransactions($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_anprkey = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
    }
    //List all services
    function list_services() {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services ORDER BY service_expiry, service_price_net ASC");
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
        $table .= "<td>".$this->pm->PM_CampusInfo($row['service_campus'], "campus_name")."</td>";
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
    function Add_Service($name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $meal_voucher, $shower_voucher) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $date = date("Y-m-d H:i");
      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_services VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '')");
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
      $query->bindParam(16, $shower_voucher);
      $query->execute();

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
    function Payment_Service_Update($id, $name, $ticket_name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus, $meal_voucher, $shower_voucher, $types) {
      $this->mysql = new MySQL;
      $this->user = new User;

      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("UPDATE pm_services SET service_name = ?, service_price_gross = ?, service_price_net = ?, service_expiry = ?, service_cash = ?, service_card = ?, service_account = ?, service_snap = ?, service_fuel = ?, service_update_author = ?, service_campus = ?, service_mealVoucher = ?, service_showerVoucher = ?, service_vehicles = ?, service_ticket_name = ? WHERE id = ?");
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
      $query->bindParam(16, $id);
      $query->execute();

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Cash Select menu
    function Payment_ServiceSelect_Cash($vehicle) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_vehicles IN (?) AND service_cash = 1 AND service_campus = ?");
      $stmt->bindParam(1, $vehicle);
      $stmt->bindParam(2, $campus);
      $stmt->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Cash" id="NT_Payment_Service_Cash" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
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
      "%".$vehicle."%";

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_vehicles LIKE ? AND service_card = 1 AND service_campus = ?");
      $stmt->bindParam(1, $vehicle);
      $stmt->bindParam(2, $campus);
      $stmt->execute();

      $html = '<select class="form-control form-control-lg" name="NT_Payment_Service_Card" id="NT_Payment_Service_Card" required>';
      $html .= '<option value="unchecked">-- Please choose a service --</option>';
      foreach ($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['service_name'].' - '.$row['service_price_gross'].'</option>';
      }
      $html .= '</select>';

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Payment Service Info
    function Payment_ServiceInfo($key) {
      $this->mysql = new MySQL;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE id = ?");
      $stmt->bindParam(1, $key);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $result[$key];

      $this->mysql = null;
    }
    //Transaction for cash
    function Transaction_Proccess_Cash($ANPRKey, $Plate, $Company, $Trailer, $Type, $Service) {
      $this->mysql = new MySQL;
      $this->mssql = new MSSQL;
      $this->anpr = new ANPR;
      $this->user = new User;
      //ANPR Dets
      $anprInfo = $this->anpr->getANPR_Record($ANPRKey);
      $ANPR_Date = $anprInfo['Capture_Date'];
      //User Details
      $name = $this->user->userInfo("first_name");
      $campus = $this->user->userInfo("campus");



      //SQL for Payment (13)
      $sql_paymentTbl = $this->mysql->dbc->prepare("INSERT INTO pm_payments (payment_anprkey, payment_vehicle_plate, payment_type, payment_service_name, payment_price_gross, payment_price_net, payment_service_ticket, payment_ticket_number, payment_author, payment_date, payment_account_id, payment_campus) VALUES ('', ?, ?, '1', ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      //SQL for ANPR Db
      $sql_anprTbl = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = ?, Expiry = ? WHERE Uniqueref = ?");
      //SQL for Parking Log
      $sql_parkedLog = $this->mysql->dbc->prepare("INSERT INTO pm_parking_log () VALUES ()");


      $this->mysql = null;
      $this->mssql = null;
      $this->anpr = null;
      $this->user = null;
    }
  }
?>
