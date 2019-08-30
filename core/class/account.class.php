<?php
  namespace ParkingManager;

  class Account
  {
    protected $mysql;
    private $user;

    //Account Information
    function Account_GetInfo($key, $what)
    {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //Fleet Information
    function Account_FleetInfo($key, $what)
    {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM accounts_trucks WHERE Plate = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$what];

      $this->mysql = null;
    }
    //Check if vehicle belongs to account.
    function Account_Check($plate)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->Info("Site");

      $sql1 = $this->mysql->dbc->prepare("SELECT Account FROM accounts_trucks WHERE Plate = ?");
      $sql1->bindParam(1, $plate);
      $sql1->execute();
      $result1 = $sql1->fetch(\PDO::FETCH_ASSOC);
      $count = $sql1->rowCount();
      if ($count > 0) {
        $id = $result1['Account'];

        $sql2 = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ? AND Status < 1");
        $sql2->bindParam(1, $id);
        $sql2->execute();
        $result = $sql2->fetch(\PDO::FETCH_ASSOC);
        $count2 = $sql2->rowCount();
        if ($count2 > 0) {
          if($result['Shared'] == 1) {
            return TRUE;
          } else if ($result['Site'] == $campus) {
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
    // List all accounts
    function List_Accounts()
    {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts ORDER BY Site ASC");
      $stmt->execute();
      $html = '';

      foreach($stmt->fetchAll() as $row)
      {
        $ref = '\''.$row['Uniqueref'].'\'';
        $html .= '
        <div class="col-md-3">
          <div class="jumbotron">
            <h4 class="display-5">'.$row['ShortName'].'</h4>';
            if($row['Shared'] > 0) {
              $html .=' <div class="alert alert-success">
                          This account is shared with other sites.
                        </div>';
            } else {}
            $html .= '
            <p class="lead"></p>
            <hr class="my-4">
            <p>'.$row['Name'].'<br>
            '.$row['Address'].'</p>
            <hr>
            <p><i class="fa fa-envelope"></i> '.$row['Contact_Email'].'</p>
            <p><i class="fa fa-envelope"></i> '.$row['Billing_Email'].'</p>
            <p><i class="fa fa-location-arrow"></i> '.$this->pm->Site_Info($row['Site'], "Name").'</p>
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
              <button type="button" class="btn btn-secondary" onClick="Account_Settings('.$ref.')"><i class="fa fa-cog"></i> Settings</button>
              <button type="button" class="btn btn-secondary" onClick="Account_Settings_Fleet('.$ref.')"><i class="fa fa-truck"></i> Fleet</button>
            </div>
          </div>
        </div>
        ';
      }

      return $html;

      $this->mysql = null;
      $this->pm = null;
    }
    // Register a new account to parking manager
    function Register_Account($Name, $Short, $Address, $Contact, $Billing, $Site, $Shared, $Discount, $Status)
    {
      $this->mysql = new MySQL;

      $Uniqueref = date("YmdHis").mt_rand(1111, 9999);
      $Last_Updated = date("Y-m-d H:i:s");
      $Short = strtoupper($Short);

      $stmt = $this->mysql->dbc->prepare("INSERT INTO accounts VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, $Site);
      $stmt->bindParam(3, $Shared);
      $stmt->bindParam(4, $Name);
      $stmt->bindParam(5, $Short);
      $stmt->bindParam(6, $Address);
      $stmt->bindParam(7, $Contact);
      $stmt->bindParam(8, $Billing);
      $stmt->bindParam(9, $Discount);
      $stmt->bindParam(10, $Status);
      $stmt->bindParam(11, $Last_Updated);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = array('Result' => '1', 'Message' => 'Account successfully added to ParkingManager');
      } else {
        $result = array('Result' => '0', 'Message' => 'Account was NOT added to ParkingManager, please try again');
      }

      echo json_encode($result);

      $this->mysql = null;
    }
    // Update a account get data
    function Update_Account_GET($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      echo json_encode($result);

      $this->mysql = null;
    }
    // Update account
    function Update_Account($Ref, $Name, $Short, $Address, $Contact, $Billing, $Site, $Shared, $Discount, $Status)
    {
      $this->mysql = new MySQL;

      $Last_Updated = date("Y-m-d H:i:s");


      $stmt = $this->mysql->dbc->prepare("UPDATE accounts SET Name = ?, ShortName = ?, Address = ?, Contact_Email = ?, Billing_Email = ?, Site = ?, Shared = ?, Discount_Vouchers = ?, Status = ?, Last_Updated = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Name);
      $stmt->bindParam(2, $Short);
      $stmt->bindParam(3, $Address);
      $stmt->bindParam(4, $Contact);
      $stmt->bindParam(5, $Billing);
      $stmt->bindParam(6, $Site);
      $stmt->bindParam(7, $Shared);
      $stmt->bindParam(8, $Discount);
      $stmt->bindParam(9, $Status);
      $stmt->bindParam(10, $Last_Updated);
      $stmt->bindParam(11, $Ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = array('Result' => '1', 'Message' => 'Account successfully added to ParkingManager');
      } else {
        $result = array('Result' => '0', 'Message' => 'Account was NOT added to ParkingManager, please try again');
      }

      echo json_encode($result);

      $this->mysql = null;
    }
    // Register Fleet Vehicles
    function Update_Fleet_GET($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts_trucks WHERE Account = ? AND Deleted < 1 ORDER BY Plate ASC");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      $html = '<table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Date Added</th>
                      <th scope="col"><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                <tbody>';
      foreach($stmt->fetchAll() as $row) {
        $Uniqueref = '\''.$row['Uniqueref'].'\'';
        $html .= '
            <tr>
              <td>'.$row['Plate'].'</td>
              <td>'.date("d/m/y H:i:s", strtotime($row['Last_Updated'])).'</td>
              <td>
                <button type="button" onClick="Fleet_Delete('.$Uniqueref.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
              </td>
            </tr>';
      }
      $html .= '
      </tbody>
      </table>';

      echo json_encode($html);

      $this->mysql = null;
    }
    // Add Fleet Vehicle
    function Update_Fleet($Ref, $Plate)
    {
      $this->mysql = new MySQL;

      $Uniqueref = date("YmdHis").mt_rand(1111, 9999);
      $Last_Updated = date("Y-m-d H:i:s");

      $Plate = str_replace(" ", "", strtoupper($Plate));

      $stmt = $this->mysql->dbc->prepare("INSERT INTO accounts_trucks VALUES('', ?, ?, ?, '0', ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, $Ref);
      $stmt->bindParam(3, $Plate);
      $stmt->bindParam(4, $Last_Updated);
      $stmt->execute();

      echo $stmt->rowCount();

      $this->mysql = null;
    }
    // Delete Fleet Vehicle
    function Delete_Fleet_Record($Ref)
    {
      $this->mysql = new MySQL;

      $Last_Updated = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("UPDATE accounts_trucks SET Deleted = '1', Last_Updated = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Last_Updated);
      $stmt->bindParam(2, $Ref);
      $stmt->execute();

      echo $stmt->rowCount();

      $this->mysql = null;
    }
    // Account Dropdown
    function Account_DropdownOpt()
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $Site = $this->user->Info("Site");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Site = ? AND Status < 2 OR Shared = 1 AND Status < 2 ORDER BY Name ASC");
      $stmt->bindParam(1, $Site);
      $stmt->execute();

      $html = '';

      foreach($stmt->fetchAll() as $row) {
        if($row['Status'] > 0) {
          $html .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - Suspended</option>';
        } else {
          $html .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].'</option>';
        }
      }

      return $html;

      $this->mysql = null;
      $this->user = null;
    }
    // Account Report
    function Account_Report($Account, $Date1, $Date2)
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $Start = date("Y-m-d 00:00:00", strtotime($Date1));
      $End = date("Y-m-d 23:59:59", strtotime($Date2));

      $column = array('Name', 'Plate', 'Service_Name', 'Gross', 'Nett', 'Processed_Time');
      $search = $_POST['search']['value'];
      $search = '%'.$search.'%';
      $Site = $this->user->Info("Site");


      $query = 'SELECT * FROM transactions ';

        if(isset($Start) && isset($End) && $Start != '' && $End != '')
        {
         $query .= 'WHERE Deleted = 0 AND AccountID = '.$Account.' AND Processed_Time BETWEEN ? AND ? ';
        }
        if(isset($_POST['order']))
        {
         $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
         $query .= 'ORDER BY Processed_Time DESC ';
        }

        $query1 = '';

        if($_POST["length"] != -1)
        {
         $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        // die($query.$query1);
      $data = array();

      $stmt = $this->mysql->dbc->prepare($query);
      $stmt->bindParam(1, $Start);
      $stmt->bindParam(2, $End);
      $stmt->execute();
      $count_filter = $stmt->rowCount();

      $stmt2 = $this->mysql->dbc->prepare($query.$query1);
      $stmt2->bindParam(1, $Start);
      $stmt2->bindParam(2, $End);
      $stmt2->execute();
      $count_total = $stmt2->rowCount();

      $data = array();


      foreach($stmt2->fetchAll() as $row) {
        $ref = '\''.$row['Uniqueref'].'\'';

        $options = '<div class="btn-group float-right" role="group" aria-label="Options">
                      <button type="button" class="btn btn-danger" onClick="DeleteTransaction('.$row['Uniqueref'].')"><i class="fa fa-trash"></i></button>
                    </div>';
        $sub_array = array();
        $sub_array[] = $row['Name'];
        $sub_array[] = $row['Plate'];
        $sub_array[] = $row['Service_Name'];
        $sub_array[] = '£'.$row['Gross'];
        $sub_array[] = '£'.$row['Nett'];
        $sub_array[] = date("d/m/y H:i:s", strtotime($row['Processed_Time']));
        $sub_array[] = $options;
        $data[] = $sub_array;
      }
      $output = array("data" =>  $data,
                      "recordsFiltered" => $count_filter,
                      "recordsTotal" => $count_total);

      echo json_encode($output);



      $this->mysql = null;
      $this->user = null;
    }


    // This function quickly adds all current fleets to new structure.
    // function Dave() {
    //   $this->mysql = new MySQL;
    //
    //
    //   $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts_fleet WHERE account_id = ?");
    //   $stmt->bindValue(1, '19');
    //   $stmt->execute();
    //   foreach($stmt->fetchAll() as $row) {
    //     $plate = $row['account_vehicle_plate'];
    //     $this->Update_Fleet("201908301121502885", $plate);
    //   }
    // }
  }
?>
