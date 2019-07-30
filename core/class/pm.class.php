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

      $campus = $this->user->Info("campus");

      $html = "";

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_notifications WHERE notification_site = ? ORDER BY notification_created DESC LIMIT 25");
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
        $site = $this->user->Info("campus");
        $stmt = $this->mysql->dbc->prepare("INSERT INTO pm_notifications (notification_text, notification_site, notification_created, notification_urgency) VALUES (?, ?, ?, ?)");
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
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_sites WHERE id = ?");
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
    // Account Dropdown
    function Account_DropdownOpt($Plate)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->account = new Account;
      $campus = $this->user->Info("campus");
      $id = $this->account->Account_FleetInfo($Plate, "account_id");
      if($id > 0) {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        $list .= '<option value="'.$result['id'].'">'.$result['account_name'].'</option>';

      } else {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts WHERE campus = ? AND account_deleted = 0 OR account_shared = 1 AND account_deleted = 0 ORDER BY account_name ASC");
        $query->bindParam(1, $campus);
        $query->execute();
        $result = $query->fetchAll();
        $list .= '<option value="unchecked">-- Please choose an account --</option>';
        foreach ($result as $row) {
          if($row['account_suspended'] == 1) {
            $list .= '<option style="color: red;" value="unchecked">'.$row['account_name'].' - currently suspended</option>';
          } else {
            $list .= '<option value="'.$row['id'].'">'.$row['account_name'].'</option>';
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
  }
?>
