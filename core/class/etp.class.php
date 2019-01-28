<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  class ETP {
    //Add SNAP transaction
    function SNAP_ListServices() {
      global $_CONFIG;
      $this->user = new User;
      //Begin API client
      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);

      $response = $client->post('services/list', [
        'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
        'json' => [
          'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
          'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead']
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
    }
    //String Preperation
    public function Fuel_String_Prepare($string, $start, $end) {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
    }
    //Process SNAP transaction
    function Proccess_Transaction_SNAP($etpid, $plate, $name) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);
      if($campus == 1 OR $campus == 0) {
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
          'json' => [
            'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
            'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
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
      } else if ($campus == 2) {
        $response = $client->post('transaction/add', [
          'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
          'json' => [
            'locationusername' => $_CONFIG['etp_api']['location_user-cannock'],
            'locationpassword' => $_CONFIG['etp_api']['location_pass-cannock'],
            'serviceid' => $etpid,
            'regno' => $plate,
            'drivername' => $name
          ]
        ]);
        $return =  json_decode($response->getBody(), true);
        if($return['outputstatus'] == 1) {
          return $return['outputtransactionid'];
        } else {
          return FALSE;
        }
      }
      $this->user = null;
    }
    //Process Fuelcard Transaction
    public function Proccess_Transaction_Fuel($etpid, $plate, $name, $Card, $Expiry) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);
      if ($campus == 1 OR $campus == 0) {
        $response = $client->post('transaction/add', [
          'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
          'json' => [
            'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
            'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
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
      } else if ($campus == 2) {
        $response = $client->post('transaction/add', [
          'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
          'json' => [
            'locationusername' => $_CONFIG['etp_api']['location_user-cannock'],
            'locationpassword' => $_CONFIG['etp_api']['location_pass-cannock'],
            'serviceid' => $etpid,
            'regno' => $plate,
            'drivername' => $name,
            'cardno' => $Card,
            'cardexpiry' => $Expiry
          ]
        ]);
      }
    }
    //check is SNAP
    public function Check_SNAP($Plate) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");
      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);
      //Begin API client
      $response = $client->post('transaction/add', [
        'auth' => array($_CONFIG['etp_api']['user'], $_CONFIG['etp_api']['pass']),
        'json' => [
          'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
          'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
          'serviceid' => "4439",
          'regno' => $Plate,
          'drivername' => "ISITSNAP",
          'committransaction' => '0'
        ]
      ]);
      $return = json_decode($response->getBody(), true);
      if($return['outputstatus'] > 0) {
        $html = '<i style="color: green;" class="fas fa-dot-circle"></i>';
      } else {
        $html = '<i style="color: red;" class="fas fa-dot-circle"></i>';
      }

      return $html;
    }
    //BreakUpCard
    function ETP_CardBreak($string) {
      $Card = $this->Fuel_String_Prepare($string, ";", "=");
      $expiry = $this->Fuel_String_Prepare($string, "=", "?");
      $expiry_yr = substr($expiry, "0", "2");
      $expiry_m = substr($expiry, "2", "2");
      $rc = substr($expiry, "6", "2");
      $expiry = $expiry_m."/20".$expiry_yr;

      $result = [
        'cardno' => $Card,
        'expiry' => $expiry,
      ];

      echo json_encode($result);
    }
  }
?>
