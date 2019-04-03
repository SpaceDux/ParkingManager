<?php
  namespace ParkingManager;
  use UniFi_API;

  class PM
  {
    #Variables
    public $err;
    public $runErr;
    protected $mysql;
    private $campus;
    private $user;
    private $author;

    //Error Handler, used to gently display user based errors.
    function ErrorHandler() {
      if(isset($this->err)) {
        $this->runErr .= '<div class="alert alert-danger" role="alert">';
        $this->runErr .= '<b>Oops: </b>';
        $this->runErr .= ''.$this->err.'';
        $this->runErr .= '</div>';
        echo $this->runErr;
      }
    }
    //Display Notices for the campus
    function displayNotice() {
      //Have to issue a connection
      $this->mysql = new MySQL;
      $this->user = new User;
      //Get User  Campus
      $this->campus = $this->user->userInfo("campus");

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_notices WHERE campus = ? ORDER BY id DESC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
      $this->user = null;
      foreach($result as $row) {
        echo '<div style="margin-top: 10px;" class="alert alert-'.$row['notice_type'].'" role="alert"><b>'.$row['notice_title'].'</b> '.$row['notice_body'].'<br><i style="font-size: 13px;">'.$row['notice_author'].'</i></div>';
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //List all notices for the campus
    function listNotices() {
      //Have to issue a connection
      $this->mysql = new MySQL;
      $this->user = new User;
      //Get User  Campus
      $this->campus = $this->user->userInfo("campus");

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_notices WHERE campus = ? ORDER BY id DESC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
      $this->user = null;
      foreach($result as $row) {
        echo '<div class="alert alert-'.$row['notice_type'].'" role="alert"><b>'.$row['notice_title'].'</b> '.$row['notice_body'].'<br><i style="font-size: 13px;">'.$row['notice_author'].'</i><button type="button" class="close" onClick="deleteNotice('.$row['id'].')"><span aria-hidden="true">&times;</span></button></div>';
      }

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Delete Notice
    function PM_DeleteNotice($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM pm_notices WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $this->mysql = null;
    }
    //Add new notice
    function newNotice($title, $body, $type) {
      if(isset($title)) {
        $this->mysql = new MySQL;
        $this->user = new User;
        $this->campus = $this->user->userInfo("campus");
        $this->author = $this->user->userInfo("first_name");

        $query = $this->mysql->dbc->prepare("INSERT INTO pm_notices (notice_type, notice_title, notice_body, notice_author, campus) VALUES (?, ?, ?, ?, ?)");
        $query->bindParam(1, $type);
        $query->bindParam(2, $title);
        $query->bindParam(3, $body);
        $query->bindParam(4, $this->author);
        $query->bindParam(5, $this->campus);
        $query->execute();

        //Null variables.
        $this->mysql = null;
        $this->user = null;
        $this->campus = null;
        $this->author = null;
      }
    }
    //PM Navigation
    function PM_Nav() {
      $this->user = new User;
      $this->pm = new PM;
      $site = $this->user->userInfo("campus");

      //Top Bar
      $nav ='<nav class="topBar">';
      $nav .=  '<a href="'.URL.'/index">';
      $nav .=  '<div class="brand">';
      $nav .=    'Parking<b>Manager</b>';
      $nav .=  '</div>';
      $nav .=  '</a>';
      $nav .=  '<ul>';
      $nav .=    '<a onClick="menuHide()"><li><i class="fas fa-align-justify"></i></li></a>';
      $nav .=    '<li data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></li>';
      $nav .=    '<li data-toggle="modal" id="AddANPRModal" data-target="#ANPR_AddModal"><i class="fa fa-plus"></i></li>';
      $nav .=    '<li onClick="ANPR_Barrier(1)" title="Toggle Entry Barrier"><i class="fa fa-arrow-right"></i></li>';
      $nav .=    '<li onClick="ANPR_Barrier(0)" title="Toggle Exit Barrier"><i class="fa fa-arrow-left"></i></li>';
      $nav .=    '<li onClick="ANPR_Exit_Log()" title="Exit History Log"><i class="fa fa-list-ul"></i></li>';
      if($this->user->userInfo("rank") > 1) {
      $nav .=    '<li onClick="PM_SwitchSite()" title="Switch Site"><i class="fa fa-recycle"></i> '.$this->pm->PM_SiteInfo($site, "site_name").'</li>';
      }
      $nav .=  '</ul>';
      $nav .='</nav>';

      //Main Nav
      $nav .='<nav id="sideBar" style="margin-left: -220px;">';
        //UserBox
      $nav .=  '<div class="userBox">';
      $nav .=    '<div class="userInfo">';
      $nav .=      '<div class="userName">'.$this->user->userInfo('first_name').' <b>'.substr($this->user->userInfo('last_name'), 0, 1).'</b></div>';
      $nav .=      '<div class="userLocation">';
      $nav .=        $this->PM_SiteInfo($this->user->userInfo("campus"), "site_name");
      $nav .=      '</div>';
      $nav .=      '<div class="pmVer">'.VER.'</div>';
      $nav .=    '</div>';
      $nav .=    '<div class="buttons">';
      $nav .=      '<a href="#settings"><i class="fa fa-cog"></i></a>';
      $nav .=      '<a href="'.URL.'/logout"><i class="fa fa-sign-out-alt"></i></a>';
      $nav .=    '</div>';
      $nav .=   '</div>';
        //Options
      $nav .=  '<ul>';
      $nav .=    '<a href="'.URL.'/main"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>';
      $nav .=    '<li><i class="fa fa-truck-moving"></i> Vehicle Tools';
      $nav .=     ' <ul>';
      $nav .=        '<a href="'.URL.'/yardcheck" target="_blank"><li>Yard Check</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-pound-sign"></i> Payment Tools';
      $nav .=     ' <ul>';
      $nav .=        '<a href="'.URL.'/transaction_log"><li>Transactions History</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-book"></i> Account Tools';
      $nav .=      '<ul>';
      $nav .=        '<a href="'.URL.'/accounts"><li>Account List</li></a>';
      $nav .=        '<a href="'.URL.'/account_report"><li>Account Reports</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-cogs"></i> P<b>M</b> Tools';
      $nav .=      '<ul>';
      $nav .=        '<a href="'.URL.'/notices"><li>Notices</li></a>';
      if($this->user->userInfo("rank") > 1) {
        $nav .= '<a href="'.URL.'/users"><li>Users</li></a>';
      }
      $nav .=      '</ul>';
      $nav .=    '</li>';
      if($this->user->userInfo("rank") > 2) {
        $nav .=    '<li><i class="fa fa-chart-line"></i> Admin Tools';
        $nav .=      '<ul>';
        $nav .=        '<a href="'.URL.'/services"><li>Services</li></a>';
        $nav .=      '</ul>';
        $nav .=    '</li>';
      }
      $nav .=  '</ul>';
      $nav .='</nav>';

      echo $nav;

      $this->user = null;
      $this->pm = null;
    }
    //Dropdown menu for Campus
    function PM_Sites_Dropdown() {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_sites ORDER BY id ASC");
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $list .= '<option value="'.$row['id'].'">'.$row['site_name'].'</option>';
      }
      echo $list;
      $this->mysql = null;
    }
    //Dropdown menu for Ranks
    function PM_Ranks_Dropdown() {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_ranks ORDER BY id ASC");
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $list .= '<option value="'.$row['id'].'">'.$row['rank_name'].'</option>';
      }
      echo $list;
      $this->mysql = null;
    }
    //Campus Info
    function PM_SiteInfo($id, $key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_sites WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];
      $this->mysql = null;
    }
    //Rank Info
    function PM_RankInfo($id, $key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_ranks WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];
      $this->mysql = null;
    }
    //Get Vehicle type Details
    function PM_VehicleTypes() {
      $this->mysql = new MySQL;

      $html = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types");
      $query->execute();
      $result = $query->fetchAll();

      foreach($result as $row) {
        $html .= '<tr>';
        $html .= '<td>'.$row['type_name'].'</td>';
        $html .= '<td>'.$row['type_shortName'].'</td>';
        $html .= '<td>'.$row['type_imageURL'].'</td>';
        $html .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger" id="Update_Vehicle_TypeBtn" data-id="'.$row['id'].'"><i class="fa fa-cog"></i></button>
            <button type="button" class="btn btn-danger" onClick="Vehicle_Service_Delete('.$row['id'].')"><i class="fa fa-times"></i></button>
          </div>
        </td>';
        $html .= '</tr>';
      }
      echo $html;
      $this->mysql = null;
    }
    //Vehicles Select menu
    function PM_VehicleTypes_Dropdown() {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types");
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $list .= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
      }
      echo $list;
      $this->mysql = null;
    }
    //Add Vehicle Type
    function addVehicleType($name, $short, $url) {
      $this->mysql = new MySQL;
      $short = strtoupper($short);
      $query = $this->mysql->dbc->prepare("INSERT INTO pm_vehicle_types (type_name, type_imageURL, type_shortName) VALUES(?, ?, ?)");
      $query->bindParam(1, $name);
      $query->bindParam(2, $url);
      $query->bindParam(3, $short);
      $query->execute();

      $this->mysql = null;
    }
    //Delete Vehicle Type
    function Vehicle_Service_Delete($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM pm_vehicle_types WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();

      $this->mysql = null;
    }
    //Vehicle Service Update GET
    function Vehicle_Service_Update_Get($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);

      $this->mysql = null;
    }
    //Vehicle Service Update
    function Vehicle_Service_Update($id, $name, $short, $url) {
      $this->mysql = new MySQL;
      $short = strtoupper($short);

      $query = $this->mysql->dbc->prepare("UPDATE pm_vehicle_types SET type_name = ?, type_imageURL = ?, type_shortName = ? WHERE id = ?");
      $query->bindParam(1, $name);
      $query->bindParam(2, $url);
      $query->bindParam(3, $short);
      $query->bindParam(4, $id);
      $query->execute();

      $this->mysql = null;
    }
    //Search PM Logs
    function PM_Search($key) {
      $string = '%'.$key.'%';
      $html = '';
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->vehicles = new Vehicles;
      $site = $this->user->userInfo("campus");
      $stmt = $this->mysql->dbc->prepare("SELECT id, parked_company, parked_plate, parked_trailer, parked_type, parked_timein, parked_expiry, parked_timeout FROM pm_parking_log WHERE parked_campus = ? AND parked_plate LIKE ? OR parked_campus = ? AND parked_company LIKE ? OR parked_campus = ? AND parked_trailer LIKE ? ORDER BY parked_timein DESC LIMIT 100");
      $stmt->bindParam(1, $site);
      $stmt->bindParam(2, $string);
      $stmt->bindParam(3, $site);
      $stmt->bindParam(4, $string);
      $stmt->bindParam(5, $site);
      $stmt->bindParam(6, $string);
      $stmt->execute();
      $result = $stmt->fetchAll();

      if(count($result) > 0) {
        $html .= '
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Company</th>
                <th scope="col">Registration</th>
                <th scope="col">Trailer Number</th>
                <th scope="col">Type</th>
                <th scope="col">Time IN</th>
                <th scope="col">Expiry</th>
                <th scope="col">Time OUT</th>
                <th scope="col"><i class="fa fa-cog"></i></th>
              </tr>
            </thead>
          ';
          $html .= '<tbody>';
          foreach($result as $row) {
            $timeout = $row['parked_timeout'];
            $html .= '<tr>
                <td>'.$row['parked_company'].'</td>
                <td>'.$row['parked_plate'].'</td>
                <td>'.$row['parked_trailer'].'</td>
                <td>'.$this->vehicles->Vehicle_Type_Info($row['parked_type'], "type_shortName").'</td>
                <td>'.date("d/m/y H:i:s", strtotime($row['parked_timein'])).'</td>
                <td>'.date("d/m/y H:i:s", strtotime($row['parked_expiry'])).'</td>';
                if($timeout != "") {
                  $html .= '<td>'.date("d/m/y H:i:s", strtotime($timeout)).'</td>';
                } else {
                  $html .= '<td></td>';
                }
                $html .= '<td>
                  <div class="btn-group" role="group" aria-label="Options">
                    <a href="'.URL."/update/".$row['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></a>
                  </div>
                </td>
              </tr>';
          }
          $html .= '</tbody></table>';
          echo $html;
      } else {
          echo 'No Data Found';
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
      $this->vehicles = null;
    }
    //Notifications
    function PM_Notification_Create($text, $urgency) {
      $this->mysql = new MySQL;
      $this->user = new User;
      if(isset($text)) {
        $date = date("Y-m-d H:i:s");

        $site = $this->user->userInfo("campus");

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
    //Exit log
    function PM_ExitList() {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->mssql = new MSSQL;

      $anpr = $this->mssql->dbc->prepare("SELECT TOP 60 * FROM ANPR_REX WHERE Lane_ID = 2 ORDER BY Capture_Date DESC");
      $anpr->execute();
      $html = '<table class="table table-bordered">
                <thead>
                  <th>Plate</th>
                  <th>Capture Date</th>
                  <th><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>';
      foreach($anpr->fetchAll() as $row) {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_exit_log WHERE exit_anpr_key = ?");
        $stmt->bindParam(1, $row['Uniqueref']);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row['Uniqueref'] == $result['exit_anpr_key']) {
          $html .= '<tr class="table-success">';
          // $style = 'class="table-success"';
        } else {
          $html .= '<tr class="table-danger">';
          // $style = 'class="table-danger"';
        }
        $html .= '<td>'.$row['Plate'].'</td>';
        $html .= '<td>'.$row['Capture_Date'].'</td>';
        $html .= '<td><button class="btn btn-primary"><i class="fa fa-camera"></i></button></td>';
        $html .= '</tr>';
      }
      $html .= '<tbody>
              </table>';

      echo $html;


      $this->mysql = null;
      $this->user = null;
      $this->mssql = null;
    }
    //Exit Keypad
    function PM_ExitKeyPad($string) {
      $this->mysql = new MySQL;
      $this->anpr = new ANPR;

      // $current = date("Y-m-d H:i:s", strtotime('+ 2 hours'));
      $time = date("Y-m-d H:i:s");

      //Alter string
      $string = str_replace("£", "", $string);
      $string = str_replace("#", "", $string);

      if(strlen($string) == 6) {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE parked_exitKey = ? AND parked_column = 1 ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(1, $string);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $id = $result['id'];
        $site = $result['parked_campus'];
        $expiry = date("Y-m-d H:i:s", strtotime($result['parked_expiry'].'+ 2 hours'));
        if($expiry >= $time) {
          $exit = $this->mysql->dbc->prepare("UPDATE pm_parking_log SET parked_column = '2', parked_timeout = ? WHERE id = ?");
          $exit->bindParam(1, $time);
          $exit->bindParam(2, $id);
          if($exit->execute()) {
            $this->anpr->Barrier_Controller($site, "EX");
            $this->PM_Notification_Create($result['parked_plate']." has been exit via keypad", "0");
            echo 1;
          }
        } else {
          echo 0;
        }
      } else if($string == "6868") {
        $this->anpr->Barrier_Controller(1, "EX");
        $this->PM_Notification_Create("Override code has been used at the barrier keypad", "0");
      } else if($string == "0419") {
        $this->anpr->Barrier_Controller(2, "EX");
        $this->PM_Notification_Create("DU code has been used at the barrier keypad", "0");
      }

      $this->mysql = null;
      $this->anpr = null;
    }
    //Run checks if auth is required
    function CheckAuth() {
      if(!isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) != "index.php") {
        header('Location: index');
      }
    }
    //Generate WiFi voucher.
    function Create_WiFi_Voucher($site) {
      //Minutes
      $controllerurl = $this->PM_SiteInfo($site, "site_unifi_ip");
      $controlleruser = $this->PM_SiteInfo($site, "site_unifi_user");
      $controllerpassword = $this->PM_SiteInfo($site, "site_unifi_pass");
      $site_id = $this->PM_SiteInfo($site, "site_unifi_site");
      $controllerversion = $this->PM_SiteInfo($site, "site_unifi_ver");

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
    //
    function ChoosePrinter_Dropdown() {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_printers WHERE printer_deleted = 0");
      $stmt->execute();

      $html = '';

      foreach($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['printer_displayName'].'</option>';
      }

      echo $html;

      $this->mysql = null;
    }
    function PM_PrinterInfo($printer, $what) {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_printers WHERE id = ?");
      $stmt->bindParam(1, $printer);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    function PM_SiteSwap() {
      $this->user = new User;
      $id = $this->user->userInfo("id");
      $campus = $this->user->userInfo("campus");

      if($campus == 1) {
        $this->user->User_FastUpdate($id, "campus", 2);
      } else if ($campus == 2) {
        $this->user->User_FastUpdate($id, "campus", 1);
      }
      $this->user = null;
    }
  }
?>
