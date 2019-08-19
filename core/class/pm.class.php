<?php
  namespace ParkingManager;
  use UniFi_API;

  class PM
  {
    // VARS
    protected $mysql;

    // Get notifications
    function GET_Notifications()
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $campus = $this->user->Info("Site");

      $html = "";

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM notifications WHERE notification_site = ? ORDER BY notification_created DESC LIMIT 25");
      $stmt->bindParam(1, $campus);
      $stmt->execute();

      foreach($stmt->fetchAll() as $row) {
        if($row['notification_urgency'] == 0) {
          $urg = "alert-success";
        } else if($row['notification_urgency'] == 1) {
          $urg = "alert-warning";
        } else if($row['notification_urgency'] == 2) {
          $urg = "alert-danger";
        }

        $html .= '<div class="alert '.$urg.'" role="alert">
                    <p>'.$row['notification_text'].'</p>
                    <hr>
                    <p class="mb-0" style="text-align: right;"><i class="fa fa-clock"></i> '.date("H:i:s", strtotime($row['notification_created'])).'</p>
                  </div>';
      }

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    //Notifications Create
    function POST_Notifications($text, $urgency)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      if(isset($text)) {
        $date = date("Y-m-d H:i:s");
        $site = $this->user->Info("Site");
        $stmt = $this->mysql->dbc->prepare("INSERT INTO notifications (notification_text, notification_site, notification_created, notification_urgency) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $text);
        $stmt->bindParam(2, $site);
        $stmt->bindParam(3, $date);
        $stmt->bindParam(4, $urgency);
        $stmt->execute();
      }
      $this->mysql = null;
      $this->user = null;
    }
    // GET site information
    function Site_Info($site, $key)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites WHERE Uniqueref = ?");
      $stmt->bindParam(1, $site);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];

      $this->mysql = null;
      $this->user = null;
    }
    // Hour Calculations ONLY returns hour
    function Hour($time1, $time2)
    {
      if(isset($time1)) {
        $d1 = new \DateTime($time1);
        $d2 = new \DateTime($time2);
        $int = $d2->diff($d1);
        $h = $int->h;
        $h = $h + ($int->days*24);
        return $h;
      } else {
        echo "ERROR!";
      }
    }
    // Vehicle Types list
    function Vehicle_Types_DropdownOpt()
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types ORDER BY id ASC");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $html = "";
      foreach($result as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
    // Vehicle Types list
    function Sites_DropdownOpt()
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $html = "";
      foreach($result as $row) {
        $html .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
    // Account Dropdown
    function Account_DropdownOpt($Plate)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->account = new Account;
      $campus = $this->user->Info("Site");
      $id = $this->account->Account_FleetInfo($Plate, "account_id");
      if($id > 0) {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ? AND Status < 1");
        $query->bindParam(1, $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        $list .= '<option value="'.$result['Uniqueref'].'">'.$result['Name'].'</option>';

      } else {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Site = ? AND Status < 2 OR Shared = 1 AND Status < 2 ORDER BY Name ASC");
        $query->bindParam(1, $campus);
        $query->execute();
        $result = $query->fetchAll();
        $list .= '<option value="unchecked">-- Please choose an account --</option>';
        foreach ($result as $row) {
          if($row['Status'] > 0) {
            $list .= '<option style="color: red;" value="unchecked">'.$row['Name'].' - currently suspended</option>';
          } else {
            $list .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].'</option>';
          }
        }
      }

      return $list;

      $this->mysql = null;
      $this->user = null;
      $this->account = null;
    }
    // Get Vehicle Types
    function GET_VehicleType($type)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types WHERE id = ?");
      $stmt->bindParam(1, $type);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result['type_shortName'];

      $this->mysql = null;
    }
    // Return printed into
    function PrinterInfo($printer, $what)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_printers WHERE id = ?");
      $stmt->bindParam(1, $printer);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //Generate WiFi voucher.
    function Create_WiFi_Voucher($site)
    {
      //Minutes
      $controllerurl = $this->Site_Info($site, "Unifi_IP");
      $controlleruser = $this->Site_Info($site, "Unifi_User");
      $controllerpassword = $this->Site_Info($site, "Unifi_Password");
      $site_id = $this->Site_Info($site, "Unifi_Site");
      $controllerversion = $this->Site_Info($site, "Unifi_Ver");

      $voucher_expiration = 1440;
      //Unifi creds
      $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
      $loginresults = $unifi_connection->login();
      //Make Voucher
      $voucher_result = $unifi_connection->create_voucher($voucher_expiration, 1, 1, 'PM Generated '.date("d/m/y H:i"), '512', '2048');
      $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);
      $vouchers = json_encode($vouchers);
      $code = json_decode($vouchers, true);

      foreach($code as $row) {
        return $row['code'];
      }
    }
  }
?>
