<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Psr7\Response;
  use GuzzleHttp\Psr7\Request;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Exception\ConnectException;

  class External {

    protected $mysql;

    function GetBookings_Portal()
    {
      global $_CONFIG;
      $this->pm = new PM;
      $this->user = new User;

      $Site = $this->user->Info("Site");
      if($this->pm->Site_Info($Site, "Portal_Active") == "1") {
        $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0', 'future' => true]);

        $response = $client->post('Bookings/List', [
          'form_params' => [
            'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
            'Username' => $this->pm->Site_Info($Site, "Portal_User"),
            'Password' => $this->pm->Site_Info($Site, "Portal_Pass")
          ]
        ]);

        $return = json_decode($response->getBody(), true);

        if($return['Status'] == '1') {
          $html = '<table class="table table-hover table-bordered">
                    <thead>
                      <th>Plate</th>
                      <th>ETA</th>
                      <th>Booked</th>
                      <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>';
          foreach($return['Data'] as $row) {
            $html .= '<tr>';
            $html .= '<td>'.$row['Plate'].'</td>';
            $html .= '<td>'.date("d/H:i", strtotime($row['ETA'])).'</td>';
            $html .= '<td>'.date("d/H:i:s", strtotime($row['Date'])).'</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
          }
          $html .= '</tbody></table>';
          return $html;
        } else {
          return 'Failed.';
        }
      } else {
        return "Your portal is not active.";
      }




      $this->pm = null;
      $this->user = null;
    }
  }
?>
