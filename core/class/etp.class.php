<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  class ETP {
    //Add SNAP transaction
    function SNAP_ListServices()
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;

      $Site = $this->user->Info("Site");

      $ETP_User = $this->pm->Site_Info($Site, "ETP_User");
      $ETP_Pass = $this->pm->Site_Info($Site, "ETP_Pass");

      $API = $_CONFIG['ETP']['API'];
      //Begin API client
      $client = new Client(['base_uri' => $API['api_uri']]);

      $response = $client->post('services/list', [
        'auth' => array($API['api_user'], $API['api_pass']),
        'json' => [
          'locationusername' => $ETP_User,
          'locationpassword' => $ETP_Pass
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
        $html .= "<tr>";
        $html .= '<td>'.$row['ServiceId'].'</td>';
        $html .= '<td>'.$row['ServiceType'].'</td>';
        $html .= '<td>'.$row['Service'].'</td>';
        $html .= '<td>'.$row['Nett'].'</td>';
        $html .= '<td>'.$row['Gross'].'</td>';
        $html .= '<td>'.$row['Snap'].'</td>';
        $html .= '<td>'.$row['FuelCard'].'</td>';
        $html .= "</tr>";

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
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
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
      if($return['outputstatus'] == 1) {
        return $return['outputtransactionid'];
      } else {
        return FALSE;
      }
      $this->user = null;
      $this->pm = null;
    }
    //Process Fuelcard Transaction
    public function Proccess_Transaction_Fuel($etpid, $plate, $name, $Card, $Expiry)
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
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
      if($return['outputstatus'] == 1) {
        return $return['outputtransactionid'];
      } else {
        return FALSE;
      }
      $this->user = null;
      $this->pm = null;

    }
    //check is SNAP
    public function Check_SNAP($Plate)
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");

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
      $this->user  = null;
      $this->pm = null;
    }
    //Process SNAP transaction
    public function DeleteTransaction($tid)
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
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
      if($return['outputstatus'] == 1) {
        return TRUE;
      } else {
        return FALSE;
      }
      $this->user = null;
      $this->pm = null;
    }
  }
?>
