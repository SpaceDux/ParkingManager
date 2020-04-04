<?php
  namespace ParkingManager;
  use GuzzleHttp\Client;
  use GuzzleHttp\Psr7\Response;
  use GuzzleHttp\Psr7\Request;
  use GuzzleHttp\Exception\RequestException;
  use GuzzleHttp\Exception\ConnectException;

  class External {

    protected $mysql;

    // Get all portal bookings
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
                      <th>Vehicle Type</th>
                      <th>Status</th>
                      <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>';
          foreach($return['Data'] as $row) {
            if($row['Status'] == 0) {
              $Status = 'Not Checked In.';
            } else if($row['Status'] == 1) {
              $Status = 'Arrived on-site';
            } else if($row['Status'] == 2) {
              $Status = 'Checked In';
            }
            $ref = '\''.$row['Uniqueref'].'\'';
            $eta_time = '\''.date("H:i", strtotime($row['ETA'])).'\'';
            $eta_date = '\''.date("d/m/y", strtotime($row['ETA'])).'\'';
            $html .= '<tr>';
            $html .= '<td>'.$row['Plate'].'</td>';
            $html .= '<td>'.date("d/H:i", strtotime($row['ETA'])).'</td>';
            $html .= '<td>'.date("d/H:i:s", strtotime($row['Date'])).'</td>';
            $html .= '<td>'.$this->pm->GET_VehicleType($row['VehicleType']).'</td>';
            $html .= '<td>'.$Status.'</td>';
            $html .= '<td>
                        <div class="btn-group" role="group">
                          <button class="btn btn-danger" onClick="Update_PortalBooking('.$ref.', '.$eta_date.', '.$eta_time.', '.$row['VehicleType'].')"><i class="fa fa-cog"></i></button>
                          <button class="btn btn-danger" onClick="Cancel_PortalBooking('.$ref.', 5)"><i class="fa fa-trash"></i></button>
                        </div>
                      </td>';
            $html .= '</tr>';
          }
          $html .= '</tbody></table>';
          echo $html;
        } else {
          echo 'No active bookings found.';
        }
      } else {
        echo "Your portal is not active.";
      }




      $this->pm = null;
      $this->user = null;
    }
    // Modify a booking.
    function ModifyBooking_Portal($Ref, $ETA, $Type)
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;

      $Site = $this->user->Info("Site");

      $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0', 'future' => true]);

      $response = $client->post('Bookings/Update', [
        'form_params' => [
          'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
          'Username' => $this->pm->Site_Info($Site, "Portal_User"),
          'Password' => $this->pm->Site_Info($Site, "Portal_Pass"),
          'Ref' => $Ref,
          'ETA' => $ETA,
          'VehicleType' => $Type
        ]
      ]);
      $return = json_decode($response->getBody(), true);
      if($return['Status'] > "0") {
        echo json_encode(array("Status" => "1", "Message" => "Successfully updated the portal booking."));
      } else {
        echo json_encode(array("Status" => "0", "Message" => "Unable to update booking."));
      }

      $this->user = null;
      $this->pm = null;
    }
    // Modify booking status ie- arrived etc
    function ModifyStatus_Portal($Ref, $Status)
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;

      $Site = $this->user->Info("Site");

      $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0', 'future' => true]);

      $response = $client->post('Bookings/Update', [
        'form_params' => [
          'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
          'Username' => $this->pm->Site_Info($Site, "Portal_User"),
          'Password' => $this->pm->Site_Info($Site, "Portal_Pass"),
          'Ref' => $Ref,
          'Status' => $Status
        ]
      ]);
      $return = json_decode($response->getBody(), true);
      if($return['Status'] > "0") {
        return json_encode(array("Status" => "1", "Message" => "Successfully updated the portal booking."));
      } else {
        return json_encode(array("Status" => "0", "Message" => "Unable to update booking."));
      }

      $this->user = null;
      $this->pm = null;
    }
    // Check if booking associated with account
    function Check_On_Portal($Plate)
    {
      global $_CONFIG;
      $this->pm = new PM;
      $this->user = new User;

      $Site = $this->user->Info("Site");
      if($this->pm->Site_Info($Site, "Portal_Active") == "1") {
        $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0']);

        $response = $client->post('Bookings/Search', [
          'form_params' => [
            'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
            'Username' => $this->pm->Site_Info($Site, "Portal_User"),
            'Password' => $this->pm->Site_Info($Site, "Portal_Pass"),
            'Plate' => $Plate
          ]
        ]);

        $return = json_decode($response->getBody(), true);

        if($return['Status'] == '1') {
          return array("Status" => "1", "Bookingref" => $return['Bookingref']);
        } else {
          return array("Status" => "0");
        }
      } else {
        return array("Status" => "0");
      }

      $this->pm = null;
      $this->user = null;
    }
    // Get Bookings as Array
    function ReturnBookingsAsArray()
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
        return $return;
      }

      $this->pm = null;
      $this->user = null;
    }
    // Get all bays
    function GetBaysFromPortal()
    {
      global $_CONFIG;
      $this->pm = new PM;
      $this->user = new User;

      $Site = $this->user->Info("Site");
      if($this->pm->Site_Info($Site, "Portal_Active") == "1") {
        $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0']);

        $response = $client->post('Bays/List', [
          'form_params' => [
            'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
            'Username' => $this->pm->Site_Info($Site, "Portal_User"),
            'Password' => $this->pm->Site_Info($Site, "Portal_Pass")
          ]
        ]);

        $return = json_decode($response->getBody(), true);
        if($return['Status'] == "1") {
          $html = '<table class="table table-hover table-bordered">
                    <thead>
                      <th>Name/Number</th>
                      <th>Type of Bay</th>
                      <th>Status</th>
                      <th>Last Update</th>
                      <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>';
          foreach($return['Data'] as $row) {
            if($row['Status'] == '0') {
              $Status = 'Unallocated';
            } else if($row['Status'] == '1') {
              $Status = 'Preparing Booking';
            } else if($row['Status'] == '2') {
              $Status = 'Booking Allocated';
            } else if($row['Status'] == '3') {
              $Status = 'Out of Service';
            }
            if($row['Temp'] == "1") {
              $Type = 'Temporary Bay';
            } else {
              $Type = 'Permenant Bay';
            }

            $html .= '<tr>
                        <td>'.$row['BayName'].'</td>
                        <td>'.$Type.'</td>
                        <td>'.$Status.'</td>
                        <td>'.date("d/m/y H:i:s", strtotime($row['Last_Updated'])).'</td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" onClick="ModifyBay_Portal('.$row['BayID'].', '.$row['Temp'].', '.$row['BayName'].')"><i class="fa fa-cog"></i></button>
                          </div>
                        </td>
                      </tr>';
          }
          $html .= '<tbody></table>';

          echo $html;
        } else {
          echo 'No bays found.';
        }
      } else {
        echo 'Your portal is not active.';
      }

      $this->pm = null;
      $this->user = null;
    }
    // Add a bay to the Portal
    function AddBayToPortal($Name, $Temp, $Status)
    {
      global $_CONFIG;
      $this->pm = new PM;
      $this->user = new User;

      $Site = $this->user->Info("Site");
      if($this->pm->Site_Info($Site, "Portal_Active") == "1") {
        $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0']);

        $response = $client->post('Bays/Add', [
          'form_params' => [
            'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
            'Username' => $this->pm->Site_Info($Site, "Portal_User"),
            'Password' => $this->pm->Site_Info($Site, "Portal_Pass"),
            'Name' => $Name,
            'Temp' => $Temp,
            'Status' => $Status,
          ]
        ]);

        $return = json_decode($response->getBody(), true);
        if($return['Status'] == "1") {
          echo json_encode(array('Status' => '1', 'Message' => 'Successfully added bay to the portal.'));
        } else {
          echo json_encode(array('Status' => '0', 'Message' => 'Couldn\'t add bay to the portal.'));
        }
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Your portal is not active.'));
      }

      $this->pm = null;
      $this->user = null;
    }
    // Update Bay
    function UpdateBayPortal($Bay, $Name, $Temp)
    {
      global $_CONFIG;
      $this->pm = new PM;
      $this->user = new User;

      $Site = $this->user->Info("Site");
      if($this->pm->Site_Info($Site, "Portal_Active") == "1") {
        $client = new Client(['base_uri' => $_CONFIG['Portal']['URL'], 'timeout' => '10.0']);

        $response = $client->post('Bays/Update', [
          'form_params' => [
            'AccessKey' => $this->pm->Site_Info($Site, "Portal_AccessKey"),
            'Username' => $this->pm->Site_Info($Site, "Portal_User"),
            'Password' => $this->pm->Site_Info($Site, "Portal_Pass"),
            'Bay' => $Bay,
            'Name' => $Name,
            'Temp' => $Temp,
          ]
        ]);

        $return = json_decode($response->getBody(), true);
        if($return['Status'] == "1") {
          echo json_encode(array('Status' => '1', 'Message' => 'Successfully updated bay.'));
        } else {
          echo json_encode(array('Status' => '0', 'Message' => 'Couldn\'t update bay on the portal.'));
        }
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Your portal is not active.'));
      }

      $this->pm = null;
      $this->user = null;
    }
  }
?>
