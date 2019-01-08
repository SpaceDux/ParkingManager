<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  class ETP {
    function SNAP_ListServices() {
      global $_CONFIG;
      $this->user = new User;
      //Begin API client
      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);

      $response = $client->post('services/list', [
          'auth' => array('Po5r9023', 'a9(K)LK_ee_47$$2'),
          'json' => [
              'locationusername' => 'holyhead',
              'locationpassword' => '2hst36sg'
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
    //Add SNAP transaction
    function Proccess_Transaction_SNAP($etpid, $plate, $name) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");

      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);
      if($campus == 1 OR $campus == 0) {
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
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
          'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
          'json' => [
            'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
            'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
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
    public function Fuel_String_Prepare($string, $start, $end) {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
    }
    public function Proccess_Transaction_Fuel($etpid, $plate, $name, $fuel_string) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->userInfo("campus");
      //Dissect Card
      $cardno = $this->Fuel_String_Prepare($fuel_string, ";", "=");
      $expiry = $this->Fuel_String_Prepare($fuel_string, "=", "?");
      $expiry_yr = substr($expiry, "0", "2");
      $expiry_m = substr($expiry, "2", "2");
      $rc = substr($expiry, "6", "2");
      $expiry = $expiry_m."/20".$expiry_yr;

      $client = new Client(['base_uri' => $_CONFIG['etp_api']['base_uri']]);
      if($campus == 1 OR $campus == 0) {
        if(substr($cardno, "0", "6") === "704310") {
          //DKV
          if($rc == "90") {
            $response = $client->post('transaction/add', [
              'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
              'json' => [
                'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
                'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
                'serviceid' => $etpid,
                'regno' => $plate,
                'drivername' => $name,
                'cardno' => $cardno,
                'cardexpiry' => $expiry
              ]
            ]);
            $return = json_decode($response->getBody(), true);
            if($return['outputstatus'] == 1) {
              return $return['outputtransactionid'];
            } else {
              return "FALSE";
            }
          } else {
            return FALSE;
          }
        } else if(substr($cardno, "0", "6") === "707821") {
          //Key fuels
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        } else if(substr($cardno, "0", "6") === "789666") {
          //Key fuels
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        } else if(substr($cardno, "0", "6") === "706000") {
          //UTA
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        } else if(substr($cardno, "0", "6") === "700048") {
          //MORGAN
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        } else if(substr($cardno, "0", "6") === "708284") {
          //MORGAN
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        } else if(substr($cardno, "0", "6") === "700676") {
          //BP
          $response = $client->post('transaction/add', [
            'auth' => array($_CONFIG['etp_api']['user-holyhead'], $_CONFIG['etp_api']['pass-holyhead']),
            'json' => [
              'locationusername' => $_CONFIG['etp_api']['location_user-holyhead'],
              'locationpassword' => $_CONFIG['etp_api']['location_pass-holyhead'],
              'serviceid' => $etpid,
              'regno' => $plate,
              'drivername' => $name,
              'cardno' => $cardno,
              'cardexpiry' => $expiry
            ]
          ]);
          $return = json_decode($response->getBody(), true);
          if($return['outputstatus'] == 1) {
            return $return['outputtransactionid'];
          } else {
            return "FALSE";
          }
        }
      }
    }
  }
?>
