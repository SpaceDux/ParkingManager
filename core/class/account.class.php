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

      $sql1 = $this->mysql->dbc->prepare("SELECT Uniqueref FROM accounts_trucks WHERE Plate = ?");
      $sql1->bindParam(1, $plate);
      $sql1->execute();
      $result1 = $sql1->fetch(\PDO::FETCH_ASSOC);
      $count = $sql1->rowCount();
      if ($count > 0) {
        $id = $result1['Uniqueref'];

        $sql2 = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ? AND Suspended = 0 AND Deleted = 0");
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
        $ref = ''.$row['Uniqueref'].'';
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
            <p>'.$row['Address'].'</p>
            <hr>
            <p><i class="fa fa-phone"></i> '.$row['Contact_No'].'</p>
            <p><i class="fa fa-envelope"></i> '.$row['Billing_Email'].'</p>
            <p><i class="fa fa-location-arrow"></i> Site</p>
            <p><i class="fa fa-history"></i> '.$row['Last_Updated'].'</p>';
            if($row['Status'] == 2) {
              $html .= '
              <div class="alert alert-danger">
                This account has been suspended.
              </div>';
            } else if($row['Status'] == 2) {
              $html .=  '
              <div class="alert alert-warning">
                This account has been terminated.
              </div>';
            } else {}

            $html .= '
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <button type="button" class="btn btn-secondary" onClick="Account_Settings('.$ref.')"><i class="fa fa-cog"></i> Settings</button>
              <button type="button" class="btn btn-secondary" onClick="Account_Settings_Fleet('.$ref.')"><i class="fa fa-truck"></i> Fleet</button>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#Suspend" onClick="Account_Suspend('.$ref.')">Suspend Account</a>
                  <a class="dropdown-item" href="#Disable" onClick="Account_Terminate('.$ref.')">Disable Account</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        ';
      }

      return $html;

      $this->mysql = null;
      $this->pm = null;
    }

    function Register_Account($Name, $Short, $Address, $Contact, $Billing, $Site = 1, $Shared, $Discount, $Status)
    {
      $this->mysql = new MySQL;

      $Uniqueref = date("YmdHis").mt_rand(1111, 9999).$Site;

      $stmt = $this->mysql->dbc->prepare("INSERT INTO accounts (id, Uniqueref, Site, Shared, Name, ShortName, Address, Billing_Email, Discount_Vouchers, Status, Last_Updated) VALUE ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, "1");
      $stmt->bindParam(3, $Shared);
      $stmt->bindParam(4, $Name);
      $stmt->bindParam(5, $ShortName);
      $stmt->bindParam(6, $Address);
      $stmt->bindParam(7, $Contact);
      $stmt->bindParam(8, $Billing);
      $stmt->bindParam(9, $Discount);
      $stmt->bindParam(10, $Status);
      $stmt->bindParam(11, $Last_Updated);
      $stmt->execute();

      $this->mysql = null;
    }
  }
?>
