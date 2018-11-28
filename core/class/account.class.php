<?php
  namespace ParkingManager;

  class Account
  {
    protected $mysql;
    private $user;

    //Account Information
    function Account_GetInfo($key, $what) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //Fleet Information
    function Account_FleetInfo($key, $what) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts_fleet WHERE account_vehicle_plate = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //List all accounts in a table
    function Account_ListAll() {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;

      $html = "";

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts ORDER BY campus, account_deleted ASC");
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        if($row['account_deleted'] == 1) {
          $type = "danger";
        } else if ($row['account_suspended'] == 1) {
          $type = "warning";
        } else {
          $type = "success";
        }

        $html .= '<tr class="table-'.$type.'">';
        $html .= '<td>'.$row['account_name'].'</td>';
        $html .= '<td>'.$row['account_contact_no'].'</td>';
        $html .= '<td>'.$row['account_contact_email'].'</td>';
        $html .= '<td>'.$this->pm->PM_SiteInfo($row['campus'], "site_name").'</td>';
        $html .= '<td>'.date("d/m/y H:i", strtotime($row['account_updated'])).'</td>';
        if($row['account_shared'] == 1) {
          $html .= '<td>Yes</td>';
        } else {
          $html .= '<td>No</td>';
        }
        $html .= '<td>'.$this->Account_Fleet_Count($row['id']).'</td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                  <button type="button" id="Account_UpdateButton" data-id="'.$row['id'].'" class="btn btn-secondary"><i class="fa fa-cog"></i> Update</button>
                  <button type="button" id="Account_UpdateFleetButton" data-id="'.$row['id'].'" class="btn btn-secondary"><i class="fa fa-truck"></i> Fleet</button>

                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="#">View Statistics</a>';
                    if($this->user->userInfo("rank") > 1) {
                      $html .= '
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" onClick="Account_Suspend('.$row['id'].')" href="#">Suspend Account</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" onClick="Account_Delete('.$row['id'].')" href="#">Delete Account</a>
                      </div>
                    </div>';
                    }
      $html .= '</div></td>';
      $html .= '<tr>';
      }

      echo $html;

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    //Get Account Information and Encode for JS
    function Account_Update_Get($key) {
      $this->mysql = new MySQL;

      if(isset($key)) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        echo json_encode($result);
      }


      $this->mysql = null;
    }
    //Update Account Information Modal PHP
    function Account_Update_Save($key, $name, $tel, $email, $billing, $site, $share) {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $this->user = new User;

      $user = $this->user->userInfo("first_name");

      $date = date("Y-m-d H:i:s");

      $query = $this->mysql->dbc->prepare("UPDATE pm_accounts SET account_name = ?, account_contact_no = ?, account_contact_email = ?, account_billing_email = ?, account_updated = ?, campus = ?, account_shared = ? WHERE id = ?");
      $query->bindParam(1, $name);
      $query->bindParam(2, $tel);
      $query->bindParam(3, $email);
      $query->bindParam(4, $billing);
      $query->bindParam(5, $date);
      $query->bindParam(6, $site);
      $query->bindParam(7, $share);
      $query->bindParam(8, $key);
      if($query->execute()) {
        $this->pm->PM_Notification_Create("$user has successfully updated $name's information.", "0");
      }

      $this->mysql = null;
      $this->pm = null;
      $this->user = null;
    }
    //Account fleet
    function Account_Fleet_Get($key) {
      $this->mysql = new MySQL;

      $html = "";
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts_fleet WHERE account_id = ? ORDER BY account_vehicle_added DESC");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetchAll();
      $html .= '
      <table class="table table-dark table-bordered table-hover">
        <thead>
          <tr>
            <th scope="col">Vehicle Registration</th>
            <th scope="col">Date Added</th>
            <th scope="col"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>';
      foreach ($result as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['account_vehicle_plate'].'</td>';
        $html .= '<td>'.date("d/m/y H:i", strtotime($row['account_vehicle_added'])).'</td>';
          $html .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" onClick="Account_Fleet_Delete('.$row['id'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
        $html .= '</tr>';
      }
      $html .= '</tbody>
              </table>';

      echo $html;

      $this->mysql = null;
    }
    //Account Fleet Add
    function Account_Fleet_Add($key, $plate) {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $this->user = new User;

      $user = $this->user->userInfo("first_name");

      $account = $this->Account_GetInfo($key, "account_name");

      $date = date("Y-m-d H:i:s");
      $plate = strtoupper($plate);
      $query = $this->mysql->dbc->prepare("INSERT INTO pm_accounts_fleet (account_id, account_vehicle_plate, account_vehicle_added) VALUES (?, ?, ?)");
      $query->bindParam(1, $key);
      $query->bindParam(2, $plate);
      $query->bindParam(3, $date);
      if($query->execute()) {
        $this->pm->PM_Notification_Create("$user has successfully updated $account's Fleet record.", "0");
      }

      $this->mysql = null;
      $this->pm = null;
      $this->user = null;
    }
    //Account Fleet Delete
    function Account_Fleet_Delete($key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("DELETE FROM pm_accounts_fleet WHERE id = ?");
      $query->bindParam(1, $key);
      if($query->execute()) {
        die("DONE");
      } else {
        die("Not done");
      }

      $this->mysql = null;
    }
    //Account Suspend
    function Account_Suspend($key) {
      $this->mysql = new MySQL;

      $is = $this->Account_GetInfo($key, "account_suspended");

      if($is == 1) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_accounts SET account_suspended = 0 WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
      } else {
        $query = $this->mysql->dbc->prepare("UPDATE pm_accounts SET account_suspended = 1 WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
      }
      $this->mysql = null;
    }
    //Account Delete
    function Account_Delete($key) {
      $this->mysql = new MySQL;

      $is = $this->Account_GetInfo($key, "account_deleted");

      if($is == 1) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_accounts SET account_deleted = 0 WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
      } else {
        $query = $this->mysql->dbc->prepare("UPDATE pm_accounts SET account_deleted = 1 WHERE id = ?");
        $query->bindParam(1, $key);
        $query->execute();
      }
      $this->mysql = null;
    }
    //Check if vehicle belongs to account.
    function Account_Check($plate) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $sql1 = $this->mysql->dbc->prepare("SELECT account_id FROM pm_accounts_fleet WHERE account_vehicle_plate = ?");
      $sql1->bindParam(1, $plate);
      $sql1->execute();
      $result1 = $sql1->fetch(\PDO::FETCH_ASSOC);
      $count = $sql1->rowCount();
      if ($count > 0) {
        $id = $result1['account_id'];

        $sql2 = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE id = ? AND account_suspended = 0 AND account_deleted = 0");
        $sql2->bindParam(1, $id);
        $sql2->execute();
        $result = $sql2->fetch(\PDO::FETCH_ASSOC);
        $count2 = count($result);
        if ($count2 > 0) {
          if($result['account_shared'] == 1) {
            return TRUE;
          } else if ($result['campus'] == $campus) {
            return TRUE;
          } else {
            return FALSE;
          }
        }
      } else {
        return FALSE;
      }

      $this->mysql = null;
      $this->user = null;
    }
    //PM Account Dropdown
    function Account_List_Dropdown() {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE campus = ? OR account_shared = 1 AND account_deleted = 0 ORDER BY account_name ASC");
      $query->bindParam(1, $campus);
      $query->execute();
      $result = $query->fetchAll();
      $list .= '<select class="form-control form-control-lg" name="PM_Account_Select" id="PM_Account_Select">';
      $list .= '<option value="unchecked">-- Please choose an account --</option>';
      foreach ($result as $row) {
        if($row['account_suspended'] == 1) {
          $list .= '<option style="color: red;" value="unchecked">'.$row['account_name'].' - currently suspended</option>';
        } else {
          $list .= '<option value="'.$row['id'].'">'.$row['account_name'].'</option>';
        }
      }
      $list .= '</select>';
      echo $list;
      $this->mysql = null;
      $this->user = null;
    }
    //Get Account info from Fleet plate
    function Account_List_Dropdown_Set($key) {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      $list .= '<select class="form-control form-control-lg" id="PM_Account_Select">';
      $list .= '<option value="'.$result['id'].'">'.$result['account_name'].'</option>';
      $list .= '</select>';

      echo $list;

      $this->mysql = null;
    }
    //Account registration
    function Account_Register($name, $tel, $email, $billing, $site, $shared) {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $date = date("Y-m-d H:i:s");

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_accounts (account_name, account_shared, account_contact_no, account_contact_email, account_billing_email, account_suspended, account_deleted, account_updated, campus) VALUES (?, ?, ?, ?, ?, '0', '0', ?, ?)");
      $query->bindParam(1, $name);
      $query->bindParam(2, $shared);
      $query->bindParam(3, $tel);
      $query->bindParam(4, $email);
      $query->bindParam(5, $billing);
      $query->bindParam(6, $date);
      $query->bindParam(7, $site);
      if($query->execute()) {
        $this->pm->PM_Notification_Create('A new account has been added to PM - '.$name.'', 0);
      }

      $this->mysql = null;
      $this->pm = null;
    }
    //Fleet Counter
    function Account_Fleet_Count($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts_fleet WHERE account_id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $return = $query->fetchAll();

      return count($return);

      $this->mysql = null;
    }
    //Account payment reports
    function Account_Report($account, $dateStart, $dateEnd) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->vehicle = new Vehicles;
      $this->payment = new Payment;
      $this->reports = new Reports;
      $campus = $this->user->userInfo("campus");
      $date1 = date("Y-m-d 00:00:00", strtotime($dateStart));
      $date2 = date("Y-m-d 23:59:59", strtotime($dateEnd));
      $priceGross = 0;
      $priceNet = 0;
      $totalTransactions = 0;

      $stat ='<div class="col-md-6"><table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">Service</th>
                    <th scope="col">No. Transactions</th>
                    <th scope="col">Price Gross</th>
                    <th scope="col">Price Net</th>
                  </tr>
                </thead>
              <tbody>';

      $html = '<table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Trailer</th>
                      <th scope="col">Vehicle Type</th>
                      <th scope="col">Time ARRIVAL</th>
                      <th scope="col">Time DEPARTURE</th>
                      <th scope="col">Payment Ref</th>
                      <th scope="col">Time Stayed</th>
                    </tr>
                  </thead>
                <tbody>';

      //Stats
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id ORDER BY payment_price_gross ASC");
      $query->bindParam(1, $account);
      $query->bindParam(2, $campus);
      $query->bindParam(3, $date1);
      $query->bindParam(4, $date2);
      $query->execute();
      foreach($query->fetchAll() as $row) {
        $key = $row['payment_service_id'];
        $count = $this->payment->Payment_Count_Account($account, $campus, $key, $date1, $date2);
        $net = $this->payment->Payment_ServiceInfo($key, "service_price_net") * $count;
        $gross = $this->payment->Payment_ServiceInfo($key, "service_price_gross") * $count;

        $stat .= '<tr>';
        $stat .= '<td>'.$this->payment->Payment_ServiceInfo($key, "service_name").'</td>';
        $stat .= '<td>'.$this->payment->Payment_Count_Account($account, $campus, $key, $date1, $date2).'</td>';
        $stat .= '<td>'.number_format($gross, 2).'</td>';
        $stat .= '<td colspan="2">'.number_format($net, 2).'</td>';
        $stat .= '</tr>';
      }
      $stat .= '</tbody></table></div>';
      //Report
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_ref ORDER BY payment_date ASC");
      $query->bindParam(1, $account);
      $query->bindParam(2, $campus);
      $query->bindParam(3, $date1);
      $query->bindParam(4, $date2);
      $query->execute();
      foreach ($query->fetchAll() as $row) {
        $key = $row['payment_ref'];
        $query2 = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE payment_ref = ? ORDER BY parked_timein ASC");
        $query2->bindParam(1, $key);
        $query2->execute();
        foreach ($query2->fetchAll() as $row) {
          if(isset($row['parked_timeout']) AND $row['parked_timeout'] == "") {
            $timeout = "";
          } else {
            $timeout = date("d/m/y H:i", strtotime($row['parked_timeout']));
          }
          $d1 = new \DateTime($row['parked_timein']);
          $d2 = new \DateTime($row['parked_timeout']);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);

          $key2 = $row['payment_ref'];
          $html .= '<tr class="table-primary" style="color: #000;">';
          $html .= '<td>'.$row['parked_plate'].'</td>';
          $html .= '<td>'.$row['parked_trailer'].'</td>';
          $html .= '<td>'.$this->vehicle->Vehicle_Type_Info($row['parked_type'], "type_shortName").'</td>';
          $html .= '<td>'.date("d/m/y H:i:s", strtotime($row['parked_timein'])).'</td>';
          $html .= '<td>'.$timeout.'</td>';
          $html .= '<td>'.$row['payment_ref'].'</td>';
          $html .= '<td>'.$h.' hours & '.$int->format('%i').' minutes</td>';
          $html .= '</tr>';
          $query3 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_ref = ? AND payment_deleted = 0");
          $query3->bindParam(1, $key2);
          $query3->execute();
          foreach($query3->fetchAll() as $row) {
            $priceGross += $row['payment_price_gross'];
            $priceNet += $row['payment_price_net'];
            $totalTransactions++;
            $html .= '<tr>';
            $html .= '<td>T.ID: '.$row['id'].'</td>';
            $html .= '<td colspan="2">'.$row['payment_service_name'].'</td>';
            $html .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
            $html .= '<td> £'.$row['payment_price_gross'].'</td>';
            $html .= '<td> £'.$row['payment_price_net'].'</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
          }
        }
      }
      $html .= '<tr class="table-danger" style="text-align: center;">';
      $html .= '<td colspan="2">Total Transactions: '.$totalTransactions.'</td>';
      $html .= '<td colspan="2">Gross Price: £'.number_format($priceGross, 2).'</td>';
      $html .= '<td colspan="2">Net Price: £'.number_format($priceNet, 2).'</td>';
      $html .= '<td colspan="2"></td>';
      $html .= '</tr>';
      $html .= "</tbody></table>";

      echo $stat;
      echo $html;



      $this->mysql = null;
      $this->user = null;
      $this->vehicle = null;
      $this->payment = null;
    }
  }
?>
