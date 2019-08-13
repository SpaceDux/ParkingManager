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
      $campus = $this->user->Info("campus");

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

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts ORDER BY Site");
      $stmt->execute();
      $html = '';

      foreach($stmt->fetchAll() as $row) {
        
      }

      $this->mysql = null;
    }
  }
?>
