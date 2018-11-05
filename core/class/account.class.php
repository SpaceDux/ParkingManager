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

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts_fleet WHERE id = ? OR account_vehicle_plate = ?");
      $query->bindParam(1, $key);
      $query->bindParam(2, $key);
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
      $list .= '<select class="form-control form-control-lg" id="PM_Account_Select">';
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
  }
?>
