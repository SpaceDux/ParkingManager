<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Psr7\Request;

  class ETP {
    function SNAP_ListServices() {
      $this->mysql = new MySQL;
      $this->user = new User;
      //Begin API client
      $client = new Client(['base_uri' => 'https://test.etpcp.com/etp/']);

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
      $this->mysql = null;
      $this->user = null;
    }
  }
?>
