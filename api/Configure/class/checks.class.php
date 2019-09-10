<?php
  namespace ParkingManager_API;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  class Checks
  {
    protected $mysql;

    function Check_Site_Exists($site)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites WHERE Uniqueref = ?");
      $stmt->bindParam(1, $site);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        return TRUE;
      } else {
        return FALSE;
      }

      $this->mysql = null;
    }
    function Check_On_SNAP($Plate)
    {
      try {
        global $_CONFIG;
        $API = $_CONFIG['ETP']['API'];
        $client = new Client(['base_uri' => $API['api_uri']]);
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => 'holyhead',
            'locationpassword' => '2hst36sg',
            'serviceid' => "4439",
            'regno' => $Plate,
            'drivername' => "ISITSNAP",
            'committransaction' => '0'
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        if($return['outputstatus'] > 0) {
          return TRUE;
        } else {
          return FALSE;
        }
      } catch(\PDOException $e) {
        return FALSE;
      }
    }
    function Check_On_Account($Plate)
    {
      $this->mysql = new MySQL;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts_trucks WHERE Plate = ? AND Deleted = 0");
      $stmt->bindParam(1, $Plate);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM accounts WHERE Uniqueref = ? AND Status = 0");
        $stmt->bindValue(1, $result['Account']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          return TRUE;
        } else {
          return FALSE;
        }
      } else {
          return FALSE;
      }
      $this->mysql = null;
    }
    function Site_Info($Site, $What) {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Site);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$What];

      $this->mysql = null;
    }
  }

?>
