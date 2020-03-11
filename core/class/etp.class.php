<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Psr7\Response;
  use GuzzleHttp\Psr7\Request;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Exception\ConnectException;

  class ETP {
    //Add SNAP transaction
    function SNAP_ListServices()
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;

      // $Site = $this->user->Info("Site");
      //
      // $ETP_User = $this->pm->Site_Info($Site, "ETP_User");
      // $ETP_Pass = $this->pm->Site_Info($Site, "ETP_Pass");

      $API = $_CONFIG['ETP']['API'];
      //Begin API client
      $client = new Client(['base_uri' => $API['api_uri']]);

      $response = $client->post('services/list', [
        'auth' => array($API['api_user'], $API['api_pass']),
        'json' => [
          'locationusername' => 'hollies',
          'locationpassword' => 'hollies'
          ]
      ]);


      $return =  json_decode($response->getBody(), true);

      $html = "<table>
                <thead>
                  <th>Service ID</th>
                  <th>Service Type</th>
                  <th>Service Name</th>
                  <th>Service Nett</th>
                  <th>Service Gross</th>
                  <th>Service Snap</th>
                  <th>Service Fuel</th>
                </thead>
                <tbody>";
      foreach($return['results'] as $row) {
        if($row['ServiceType'] == "Washing") {
          $html .= "<tr>";
          $html .= '<td>'.$row['ServiceId'].'</td>';
          $html .= '<td>'.$row['ServiceType'].'</td>';
          $html .= '<td>'.$row['Service'].'</td>';
          $html .= '<td>'.$row['Nett'].'</td>';
          $html .= '<td>'.$row['Gross'].'</td>';
          $html .= '<td>'.$row['Snap'].'</td>';
          $html .= '<td>'.$row['FuelCard'].'</td>';
          $html .= "</tr>";
        }

        // echo $row['ServiceType']." - ".$row['Service']." - ".$row['Nett']." - ".$row['Gross']." - Allow SNAP: ".$row['Snap']." -
        //  Allow Fuel Card: ".$row['FuelCard']." - ServiceID: ".$row['ServiceId']."<br>";
      }
      $html .= "</tbody>
                </table>";

      echo $html;
      $this->user = null;
      $this->pm = null;
    }
    //Process SNAP transaction
    public function Proccess_Transaction_SNAP($etpid, $plate, $name)
    {
      $this->user = new User;
      $this->pm = new PM;
      global $_CONFIG;
      try {
        $campus = $this->user->Info("Site");
        $API = $_CONFIG['ETP']['API'];

        $client = new Client(['base_uri' => $API['api_uri']]);
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $this->pm->Site_Info($campus, "ETP_User"),
            'locationpassword' => $this->pm->Site_Info($campus, "ETP_Pass"),
            'serviceid' => $etpid,
            'regno' => $plate,
            'drivername' => $name
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        $ETPMsg = $return['outputmessage'];
        $MSG = str_replace("[User]The specified [UserName] and [Password] are valid^[User]", "", $ETPMsg);
        if($return['outputstatus'] > "0") {
          return array('Status' => "1", 'Message' => 'ETP has accepted the transaction. ETPID; '.$return['outputtransactionid'].' <br><br> Message: '.$MSG.'', 'TID' => $return['outputtransactionid']);
        } else {
          return array('Status' => "0", 'Message' => 'ETP have rejected the transaction. Response; <br> '.$MSG);
        }
      } catch(RequestException $e) {
        if($e->getResponse() == null) {
          return array('Status' => "0", 'Message' => 'Unable to read response provided by ETP, please check your ETP application and ensure the transaction has not been made.');
        }
      }
      $this->user = null;
      $this->pm = null;
    }
    //Process Fuelcard Transaction
    public function Proccess_Transaction_Fuel($etpid, $plate, $name, $Card, $Expiry)
    {
      $this->user = new User;
      $this->pm = new PM;
      global $_CONFIG;
      try {
        $campus = $this->user->Info("Site");
        $API = $_CONFIG['ETP']['API'];

        $client = new Client(['base_uri' => $API['api_uri']]);

        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $this->pm->Site_Info($campus, "ETP_User"),
            'locationpassword' => $this->pm->Site_Info($campus, "ETP_Pass"),
            'serviceid' => $etpid,
            'regno' => $plate,
            'drivername' => $name,
            'cardno' => $Card,
            'cardexpiry' => $Expiry
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        $ETPMsg = $return['outputmessage'];
        $MSG = str_replace("[User]The specified [UserName] and [Password] are valid^Invalid Card No^[User]", "", $ETPMsg);
        if($return['outputstatus'] > "0") {
          return array('Status' => "1", 'Message' => 'ETP has accepted the transaction. ETPID; '.$return['outputtransactionid'], 'TID' => $return['outputtransactionid']);
        } else {
          return array('Status' => "0", 'Message' => 'ETP has rejected the transaction. Response by ETP; '.$MSG);
        }
      } catch(RequestException $e) {
        if($e->getResponse() == null) {
          return array('Status' => "0", 'Message' => 'Unable to read response provided by ETP, please check your ETP application and ensure the transaction has not been made.');
        }
      }
      $this->user = null;
      $this->pm = null;
    }
    //check is SNAP
    public function Check_SNAP($Plate)
    {
      $this->user = new User;
      $this->pm = new PM;
      global $_CONFIG;
      try {
        $campus = $this->user->Info("Site");

        $API = $_CONFIG['ETP']['API'];
        $client = new Client(['base_uri' => $API['api_uri'], 'timeout' => '1.0']);
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => 'holyhead',
            'locationpassword' => '2hst36sg',
            'serviceid' => "9745",
            'regno' => $Plate,
            'drivername' => "ISITSNAP",
            'committransaction' => '0'
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        if($return['outputstatus'] > "0") {
          return TRUE;
        } else {
          return FALSE;
        }
      } catch(RequestException $e) {
        if($e->getResponse() != null) {
          if($e->getResponse()->getStatusCode() != 200) {
            return "ERROR";
          }
        } else {
          return "ERROR";
        }
      }
      $this->user = null;
      $this->pm = null;
    }
    //Process SNAP transaction
    public function DeleteTransaction($tid)
    {
      $this->user = new User;
      $this->pm = new PM;
      global $_CONFIG;
      $campus = $this->user->Info("Site");

      $API = $_CONFIG['ETP']['API'];

      $client = new Client(['base_uri' => $API['api_uri']]);
      //Begin API client
      $response = $client->post('transaction/credit', [
        'auth' => array($API['api_user'], $API['api_pass']),
        'json' => [
          'locationusername' => $this->pm->Site_Info($campus, "ETP_User"),
          'locationpassword' => $this->pm->Site_Info($campus, "ETP_Pass"),
          'transactionid' => $tid
        ]
      ]);
      $return = json_decode($response->getBody(), true);
      if($return['outputstatus'] == "1") {
        return TRUE;
      } else {
        return FALSE;
      }
      $this->user = null;
      $this->pm = null;
    }
  }
?>
