<?php
  namespace ParkingManager;
  class Vehicles
  {
    // ANPR Feed is called via ajax when ID="ANPR_FEED" is loaded in tpl
    function ANPR_Feed() {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      $this->user = new User;
      $this->pm = new PM;
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
          } else {
            $patch = "";
          }
          $number = $this->PM->Hour($row['Capture_Date'], "");
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
          $table .= '<td><img style="max-width: 140px; max-height: 50px;" src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" id="ANPR_Edit" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                        <a href="{URL}/new_transaction/'.$row['Uniqueref'].'" class="btn btn-danger"><i class="fa fa-pound-sign"></i></a>
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
      $this->pm = null;
    }
    // PAID Feed is called via ajax when ID="PAID_FEED" is loaded in tpl
    function PAID_Feed() {

    }
    // RENEWAL Feed is called via ajax when ID="RENEWAL_FEED" is loaded in tpl
    function RENEWAL_Feed() {

    }
  }
?>
