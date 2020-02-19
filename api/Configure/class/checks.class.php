<?php
  namespace ParkingManager_API;
  use GuzzleHttp\Client;
  use GuzzleHttp\Handler\MockHandler;
  use GuzzleHttp\HandlerStack;
  use GuzzleHttp\Psr7\Response;
  use GuzzleHttp\Psr7\Request;
  use GuzzleHttp\Exception\RequestException;

  class Checks
  {
    protected $mysql;
    // Check the site exists
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
    // Check SNAP will accept the vehicle
    function Check_On_SNAP($Plate)
    {
      try {
        global $_CONFIG;
        $API = $_CONFIG['ETP']['API'];
        $client = new Client(['base_uri' => $API['api_uri'], 'timeout' => '5.0']);
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
      } catch(RequestException $e) {
        if($e->getResponse() != null) {
          if($e->getResponse()->getStatusCode() != 200) {
            return 0;
          }
        } else {
          return 0;
        }
      }
    }
    // Check vehicle exists in accounts fleet
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
    // Site Info return
    function Site_Info($Site, $What)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM sites WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Site);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$What];

      $this->mysql = null;
    }
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
    // Vehicle information
    function Vehicle_Info($ref, $what)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];
      $this->mysql = null;
    }
    function Get_Account($Plate)
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
          $data = $stmt->fetch(\PDO::FETCH_ASSOC);
          return $data['Uniqueref'];
        } else {
          return FALSE;
        }
      } else {
          return FALSE;
      }

      $this->mysql = null;
    }

    function Process_SNAP_Transaction($Plate, $ID, $Name)
    {
      try {
        global $_CONFIG;
        $API = $_CONFIG['ETP']['API'];
        $client = new Client(['base_uri' => $API['api_uri'], 'timeout' => '5.0']);
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['site_user'],
            'locationpassword' => $API['site_pass'],
            'serviceid' => $ID,
            'regno' => $Plate,
            'drivername' => $Name,
            'committransaction' => '0'
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        if($return['outputstatus'] > 0) {
          return $return['outputtransactionid'];
        } else {
          return FALSE;
        }
      } catch(RequestException $e) {
        if($e->getResponse() != null) {
          if($e->getResponse()->getStatusCode() != 200) {
            return FALSE;
          }
        } else {
          return FALSE;
        }
      }
    }
    function Process_Fuel_Transaction($Plate, $ID, $Name, $Cardno, $Expiry)
    {
      try {
        global $_CONFIG;
        $API = $_CONFIG['ETP']['API'];
        $client = new Client(['base_uri' => $API['api_uri'], 'timeout' => '5.0']);
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['site_user'],
            'locationpassword' => $API['site_pass'],
            'serviceid' => $ID,
            'regno' => $Plate,
            'drivername' => $Name,
            'cardno' => $Cardno,
            'cardexpiry' => $Expiry
            // 'committransaction' => '0'
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        if($return['outputstatus'] > 0) {
          return $return['outputtransactionid'];
        } else {
          return FALSE;
        }
      } catch(RequestException $e) {
        if($e->getResponse() != null) {
          if($e->getResponse()->getStatusCode() != 200) {
            return FALSE;
          }
        } else {
          return FALSE;
        }
      }
    }

    //Break Up Fuel Card str
    //String Preperation
    public function Fuel_String_Prepare($string, $start, $end)
    {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
    }
    function RemoveSlashes($string)
    {
      $string=implode("",explode("\\",$string));
      $string=implode("",explode("//",$string));
      $string=implode("",explode(":",$string));
      $string=implode("",explode(";",$string));
      return stripslashes(trim($string));
    }
    function Payment_FC_Break($string)
    {
      $Card = $this->Fuel_String_Prepare($string, ";", "=");
      $expiry = $this->Fuel_String_Prepare($string, "=", "?");
      $expiry_yr = substr($expiry, "0", "2");
      $expiry_m = substr($expiry, "2", "2");
      $rc = substr($expiry, "6", "2");
      $expiry = $expiry_m."/20".$expiry_yr;

      $Card = $this->RemoveSlashes($Card);

      $result = [
        'cardno' => $Card,
        'expiry' => $expiry,
        'rc' => $rc
      ];

      return $result;
    }
  }

?>
