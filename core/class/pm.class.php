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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM vehicle_types ORDER BY id ASC");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $html = "";
      foreach($result as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['Name'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
    function Tariff_Groups_DowndownOpt()
    {
      $this->mysql = new MySQL;

      $html = "";

      $html .= '<option value="1">Miscellaneous</option>';
      $html .= '<option value="2">Parking</option>';
      $html .= '<option value="3">Parking with Meal</option>';
      $html .= '<option value="4">Wash</option>';


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
      $id = $this->account->Account_FleetInfo($Plate, "Account");
      $status = $this->account->Account_GetInfo($id, "Status");

      if($status < 1 AND $status != '') {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        $list .= '<option value="'.$result['Uniqueref'].'">'.$result['Name'].'</option>';
      } else if($status == 1) {
        $list = '';
        $query = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        $list .= '<option value="unchecked">'.$result['Name'].' - Currently Suspended</option>';
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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM vehicle_types WHERE id = ?");
      $stmt->bindParam(1, $type);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result['ShortName'];

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
    // Get All Sites
    function List_Sites()
    {
      $this->mysql = new MySQL;
      $html = '';

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites");
      $stmt->execute();

      foreach($stmt->fetchAll() as $row)
      {
        $ref = '\''.$row['Uniqueref'].'\'';
        $html .= '
        <div class="col-md-3">
          <div class="jumbotron">
            <h4 class="display-5">'.$row['Name'].'</h4>';
            $html .= '
            <p class="lead"></p>
            <hr class="my-4">
            <p>Vat No. '.$row['Vatno'].'<br>
            <hr>
            <p><i class="fa fa-history"></i> '.date("d/m/Y @ H:i:s", strtotime($row['Last_Updated'])).'</p>';
            if($row['Status'] == 1) {
              $html .= '
              <div class="alert alert-warning">
                This account has been suspended.
              </div>';
            } else if($row['Status'] == 2) {
              $html .=  '
              <div class="alert alert-danger">
                This account has been terminated.
              </div>';
            } else {}

            $html .= '
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <button type="button" class="btn btn-secondary" onClick="Site_Settings('.$ref.')"><i class="fa fa-cog"></i> Settings</button>
            </div>
          </div>
        </div>
        ';
      }
      return $html;
      $this->mysql = null;
    }
    function New_Site($Data)
    {
      $this->mysql = new MySQL;

      //die($Data['Name']);

      $Uniqueref = date("YmdHis").mt_rand(1111, 9999);
      $Time = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("INSERT INTO sites VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindValue(2, $Data['Name']);
      $stmt->bindValue(3, $Data['Vatno']);
      $stmt->bindValue(4, $Data['BarrierIN']);
      $stmt->bindValue(5, $Data['BarrierOUT']);
      $stmt->bindValue(6, $Data['ANPR_IP']);
      $stmt->bindValue(7, $Data['ANPR_User']);
      $stmt->bindValue(8, $Data['ANPR_Pass']);
      $stmt->bindValue(9, $Data['ANPR_DB']);
      $stmt->bindValue(10, $Data['ANPR_Imgstr']);
      $stmt->bindValue(11, $Data['ANPR_Imgsrv']);
      $stmt->bindValue(12, $Data['Unifi_Status']);
      $stmt->bindValue(13, $Data['Unifi_IP']);
      $stmt->bindValue(14, $Data['Unifi_User']);
      $stmt->bindValue(15, $Data['Unifi_Pass']);
      $stmt->bindValue(16, $Data['Unifi_Site']);
      $stmt->bindValue(17, $Data['Unifi_Ver']);
      $stmt->bindValue(18, $Data['ETP_User']);
      $stmt->bindValue(19, $Data['ETP_Pass']);
      $stmt->bindValue(20, '0');
      $stmt->bindValue(21, $Time);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = array('Result' => '1', 'Message' => 'Site has successfully been added into ParkingManager.');
      } else {
        $result = array('Result' => '0', 'Message' => 'Site has NOT been added into ParkingManager. Please try again.');
      }

      echo json_encode($result);
      unset($Uniqueref);

      $this->mysql = null;
    }
    function Update_Site($Data)
    {
      $this->mysql = new MySQL;

      $Time = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("UPDATE sites SET Name = ?, Vatno = ?, Barrier_IN = ?, Barrier_OUT = ?, ANPR_IP = ?, ANPR_User = ?, ANPR_Password = ?, ANPR_DB = ?, ANPR_Imgstr = ?, ANPR_Img = ?, Unifi_Status = ?, Unifi_IP = ?, Unifi_User = ?, Unifi_Pass = ?, Unifi_Site = ?, Unifi_Ver = ?, ETP_User = ?, ETP_Pass = ?, Last_Updated = ? WHERE Uniqueref = ?");
      $stmt->bindValue(1, $Data['Name']);
      $stmt->bindValue(2, $Data['Vatno']);
      $stmt->bindValue(3, $Data['BarrierIN']);
      $stmt->bindValue(4, $Data['BarrierOUT']);
      $stmt->bindValue(5, $Data['ANPR_IP']);
      $stmt->bindValue(6, $Data['ANPR_User']);
      $stmt->bindValue(7, $Data['ANPR_Pass']);
      $stmt->bindValue(8, $Data['ANPR_DB']);
      $stmt->bindValue(9, $Data['ANPR_Imgstr']);
      $stmt->bindValue(10, $Data['ANPR_Imgsrv']);
      $stmt->bindValue(11, $Data['Unifi_Status']);
      $stmt->bindValue(12, $Data['Unifi_IP']);
      $stmt->bindValue(13, $Data['Unifi_User']);
      $stmt->bindValue(14, $Data['Unifi_Pass']);
      $stmt->bindValue(15, $Data['Unifi_Site']);
      $stmt->bindValue(16, $Data['Unifi_Ver']);
      $stmt->bindValue(17, $Data['ETP_User']);
      $stmt->bindValue(18, $Data['ETP_Pass']);
      $stmt->bindValue(19, $Time);
      $stmt->bindValue(20, $Data['Ref']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = array('Result' => '1', 'Message' => 'Site has successfully been updated in ParkingManager.');
      } else {
        $result = array('Result' => '0', 'Message' => 'Site has NOT been updated in ParkingManager. Please try again.');
      }

      echo json_encode($result);

      $this->mysql = null;
    }
    function Update_Site_GET($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);

      $this->mysql = null;
    }
    function Printers_DropdownOpt()
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM printers WHERE Status < 1");
      $stmt->execute();
      $html = '';

      foreach($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['Name'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
  }
?>
