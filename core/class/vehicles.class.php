<?php
  namespace ParkingManager;
  class Vehicles
  {
    protected $mysql;
    // ANPR Feed is called via ajax when ID="ANPR_FEED" is loaded in tpl
    function ANPR_Feed() {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      $this->user = new User;
      $campus = $this->user->Info("campus");
      if($this->user->Info("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->pm = new PM;
        $query = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date, Patch FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
        $query->execute();
        $result = $query->fetchAll();
        $table = '<table class="table table-dark table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th scope="col">Registration</th>
            <th scope="col">Time IN</th>
            <th scope="col">Patch</th>
            <th scope="col"><i class="fa fa-cog"></i></th>
          </tr>
          </thead>
        <tbody>';
        foreach ($result as $row) {
          //Get The right Path now.
          if(isset($campus)) {
            $patch = str_replace($this->pm->Site_Info($campus, 'site_anpr_imgstr'), $this->pm->Site_Info($campus, 'site_anpr_img'), $row['Patch']);
            // $patch = "";
          } else {
            $patch = "";
          }
          $number = $this->pm->Hour($row['Capture_Date'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          //Begin Table.
          $table .= '<tr class="'.$style.'">';
          $table .= '<td>'.$row['Plate'].'</td>';
          $table .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
          $table .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" id="ANPR_Edit" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                        <button type="button" onClick="PaymentPaneToggle('.$row['Uniqueref'].', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                        <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
          $table .= '</tr>';
        }
        $table .= '</tbody>
                </table>';
        echo $table;
        $this->mssql = null;
        $this->pm = null;
      } else {
        //nothing yet.
      }
      $this->user = null;
    }
    // PAID Feed is called via ajax when ID="PAID_FEED" is loaded in tpl
    function ALLVEH_Feed() {
      $this->user = new User;
      $this->mysql = new MySQL;

      $campus = $this->user->Info("campus");
      $html_paid = '';
      $html_renew = '';
      $html_exit = '';

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_records WHERE Parked_Site = ? AND Parked_Deleted != '1' AND Parked_Column != '2' ORDER BY Parked_Expiry DESC");
      $stmt->bindParam(1, $campus);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_records WHERE Parked_Site = ? AND Parked_Deleted != '1' AND Parked_Column == '2' ORDER BY Parked_Departure DESC");
      $stmt2->bindParam(1, $campus);
      $stmt2->execute();
      $html_paid .= '<table class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th scope="col">Company</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Time IN</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col"><i class="fa fa-cog"></i></th>
                      </tr>
                      </thead>
                      <tbody>';
      $html_renew .= '<table class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th scope="col">Company</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Time IN</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col"><i class="fa fa-cog"></i></th>
                      </tr>
                      </thead>
                      <tbody>';
      $html_exit .= '<table class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th scope="col">Company</th>
                        <th scope="col">Registration</th>
                        <th scope="col">Time OUT</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col"><i class="fa fa-cog"></i></th>
                      </tr>
                      </thead>
                      <tbody>';

      foreach($stmt->fetchAll() as $row) {
        // Paid
        if(strtotime($row['Parked_Expiry']) >= date("Y-m-d H:i:s")) {
          $html_paid .= '<tr>';
          $html_paid .= '<td>'.$row['Parked_Name'].'</td>';
          $html_paid .= '<td>'.$row['Parked_Plate'].'</td>';
          $html_paid .= '<td>'.$row['Parked_Arrival'].'</td>';
          $html_paid .= '<td>'.$row['Parked_Type'].'</td>';
          $html_paid .= '</tr>';
        }
        // Renewal
        if(strtotime($row['Parked_Expiry']) <= date("Y-m-d H:i:s")) {
          $html_renew .= '<tr>';
          $html_renew .= '<td>'.$row['Parked_Name'].'</td>';
          $html_renew .= '<td>'.$row['Parked_Plate'].'</td>';
          $html_renew .= '<td>'.$row['Parked_Arrival'].'</td>';
          $html_renew .= '<td>'.$row['Parked_Type'].'</td>';
          $html_renew .= '</tr>';
        }
      }
      foreach($stmt2->fetchAll() as $row) {
        $html_exit .= '<tr>';
        $html_exit .= '<td>'.$row['Parked_Name'].'</td>';
        $html_exit .= '<td>'.$row['Parked_Plate'].'</td>';
        $html_exit .= '<td>'.$row['Parked_Departure'].'</td>';
        $html_exit .= '<td>'.$row['Parked_Type'].'</td>';
        $html_exit .= '</tr>';
      }


      $html_paid .= '</tbody></table>';
      $html_renew .= '</tbody></table>';
      $html_exit .= '</tbody></table>';

      $data = array("Paid" => $html_paid,
                    "Renew" => $html_renew,
                    "Exit" => $html_exit);

      echo json_encode($data);

      $this->mysql = null;
      $this->user = null;
    }
  }
?>
