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
      $API = $_CONFIG['ETP']['API'];
      //Begin API client
      $client = new Client(['base_uri' => $API['api_uri']]);

      $response = $client->post('services/list', [
        'auth' => array($API['api_user'], $API['api_pass']),
        'json' => [
          'locationusername' => $API['holyhead_user'],
          'locationpassword' => $API['holyhead_pass']
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
    //Process SNAP transaction
    public function Proccess_Transaction_SNAP($etpid, $plate, $name) {
      global $_CONFIG;
      $this->user = new User;
      $campus = $this->user->Info("campus");
      $API = $_CONFIG['ETP']['API'];

      $client = new Client(['base_uri' => $API['api_uri']]);
      if($campus == 1 OR $campus == 0) {
        //Begin API client
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['holyhead_user'],
            'locationpassword' => $API['holyhead_pass'],
            'serviceid' => $etpid,
            'regno' => $plate,
            'drivername' => $name
          ]
        ]);
        $return = json_decode($response->getBody(), true);
        if($return['outputstatus'] == 1) {
          return $return['outputtransactionid'];
        } else {
          die($return['outputmessage']." - ".$etpid);
          return FALSE;
        }
      } else if ($campus == 2) {
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['hollies_user'],
            'locationpassword' => $API['hollies_pass'],
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
      $campus = $this->user->Info("campus");
      $API = $_CONFIG['ETP']['API'];

      $client = new Client(['base_uri' => $API['api_uri']]);

      if ($campus == 1 OR $campus == 0) {
        $response = $client->post('transaction/add', [
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['holyhead_user'],
            'locationpassword' => $API['holyhead_pass'],
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
          'auth' => array($API['api_user'], $API['api_pass']),
          'json' => [
            'locationusername' => $API['hollies_user'],
            'locationpassword' => $API['hollies_pass'],
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
      }
    }
    //check is SNAP
    public function Check_SNAP($Plate) {
      global $_CONFIG;
      $API = $_CONFIG['ETP']['API'];
      $client = new Client(['base_uri' => $API['api_uri']]);
      //Begin API client
      $response = $client->post('transaction/add', [
        'auth' => array($API['api_user'], $API['api_pass']),
        'json' => [
          'locationusername' => $API['holyhead_user'],
          'locationpassword' => $API['holyhead_pass'],
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
    }
  }
?>
