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
    //Check if vehicle belongs to account.
    function Account_Check($plate) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $campus = $this->user->Info("campus");

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
        $count2 = $sql2->rowCount();
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
  }
?>
