<?php
  namespace ParkingManager;
  class Vehicles
  {
    protected $mysql;
    protected $mssql;
    public $count_paid;
    public $count_renewal;
    public $count_anpr;
    // ANPR TOOLS
    // ANPR Feed is called via ajax when ID="ANPR_FEED" is loaded in tpl
    function ANPR_Feed() {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      $this->user = new User;
      $campus = $this->user->Info("campus");
      $count_anpr = 0;
      if($this->user->Info("anpr") == 1) {
        $this->mssql = new MSSQL;
        $this->pm = new PM;
        $query = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
        $query->execute();
        $result = $query->fetchAll();
        $table = '<table class="table table-dark table-bordered table-hover">
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
          $count_anpr++;
          $plate = '\''.$row['Plate'].'\'';
          $trl = '\''.$row['Notes'].'\'';
          $date = '\''.$row['Capture_Date'].'\'';
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
          $table .= '<tr id="ANPR_Feed_'.$row['Uniqueref'].'" class="'.$style.'">';
          $table .= '<td>'.$row['Plate'].'</td>';
          $table .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
          $table .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
          $table .= '<td>
                      <div class="btn-group" role="group" aria-label="Options">
                        <button type="button" onClick="ANPR_Update('.$row['Uniqueref'].', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                        <button type="button" onClick="PaymentPaneToggle('.$row['Uniqueref'].', '.$plate.', '.$trl.', '.$date.', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                        <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                      </div>
                    </td>';
          $table .= '</tr>';
        }
        $table .= '</tbody>
                </table>';
        $result = array("Feed" => $table);
        echo json_encode($result);
        $this->mssql = null;
        $this->pm = null;
      } else {
        //nothing yet.
        echo "ANPR has been disabled on your account.";
      }
      $this->user = null;
    }
    // ANPR Duplicate vehicle, remove from feed.
    function ANPR_Duplicate($ref) {
      $this->mssql = new MSSQL;

      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 11 WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      if($stmt->execute()) {
        print_r("SUCCESSFUL");
      } else {
        print_r("SUCCESSFUL");
      }

      $this->mssql = null;
    }
    // Add a vehicle into the anpr
    function ANPR_AddPlate($plate, $time) {
      $this->mssql = new MSSQL;
      //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID, BarcodeExpression)

      if(!empty($plate) AND !empty($time)) {
        $plate = strip_tags(strtoupper($plate));
        //Includes latest anpr update.
        $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, :createdDate, null, 'RoadKing - Added VIA PM', '0', null, '0', :plate2, null, null, :capDate2, null, '', '', '')");
        $stmt->bindParam(':plate', $plate);
        $stmt->bindParam(':capDate', $time);
        $stmt->bindParam(':createdDate', $time);
        $stmt->bindParam(':plate2', $plate);
        $stmt->bindParam(':capDate2', $time);
        if($stmt->execute()) {
          echo "SUCCESSFUL";
        } else {
          echo "UNSUCCESSFUL";
        }
      }

      $this->mssql = null;
    }
    // Update ANPR Record
    function ANPR_Update($ref, $plate, $trl = '', $time) {
      $this->mssql = new MSSQL;
      if(!empty($plate) AND !empty($time)) {
        $plate = strip_tags(strtoupper($plate));
        $trl = strip_tags(strtoupper($trl));
        $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Plate = ?, Capture_Date = ?, Notes = ? WHERE Uniqueref = ?");
        $stmt->bindParam(1, $plate);
        $stmt->bindParam(2, $time);
        $stmt->bindParam(3, $trl);
        $stmt->bindParam(4, $ref);
        if($stmt->execute()) {
          echo "SUCCESSFUL";
        } else {
          echo "UNSUCCESSFUL";
        }
      }

      $this->mssql = null;
    }
    // get images
    function ANPR_GetImages($ref) {
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("campus");

      $html = "";

      $stmt = $this->mssql->dbc->prepare("SELECT Overview, Patch FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if(count($result) > 0) {
        if($result['Patch'] != "") {
          $patch = str_replace($this->pm->Site_Info($campus, 'site_anpr_imgstr'), $this->pm->Site_Info($campus, 'site_anpr_img'), $result['Patch']);
          $overview = str_replace($this->pm->Site_Info($campus, 'site_anpr_imgstr'), $this->pm->Site_Info($campus, 'site_anpr_img'), $result['Overview']);
          $html .= '<img src="'.$patch.'" alt="" class="img-thumbnail">';
          $html .= '<img src="'.$overview.'" alt="" class="img-thumbnail">';
        } else {
          $html .= "";
        }
        echo json_encode($html);
      } else {
        $html .= "";
      }

      $this->mssql = null;
      $this->user = null;
      $this->pm = null;
    }
    // get images
    function ANPR_Info($ref, $what) {
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("campus");

      $html = "";

      $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if(count($result) > 0) {
        return $result[$what];
      } else {

      }

      $this->mssql = null;
      $this->user = null;
      $this->pm = null;
    }
    // ALL VEHICLE TOOLS
    // PAID Feed is called via ajax when ID="PAID_FEED" is loaded in tpl
    function ALLVEH_Feed() {
      $this->user = new User;
      $this->mysql = new MySQL;

      $campus = $this->user->Info("campus");
      $html_paid = '';
      $html_renew = '';
      $html_exit = '';

      $count_paid = 0;
      $count_renewal = 0;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_records WHERE Site = ? AND Deleted != '1' AND Parked_Column != '2' ORDER BY Expiry DESC");
      $stmt->bindParam(1, $campus);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_records WHERE Site = ? AND Deleted != '1' AND Parked_Column == '2' ORDER BY Departure DESC");
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
        if(strtotime($row['Expiry']) >= date("Y-m-d H:i:s")) {
          $count_paid++;
          $html_paid .= '<tr>';
          $html_paid .= '<td>'.$row['Name'].'</td>';
          $html_paid .= '<td>'.$row['Plate'].'</td>';
          $html_paid .= '<td>'.$row['Arrival'].'</td>';
          $html_paid .= '<td>'.$row['Type'].'</td>';
          $html_paid .= '</tr>';
        }
        // Renewal
        if(strtotime($row['Expiry']) <= date("Y-m-d H:i:s")) {
          $count_renewal++;
          $html_renew .= '<tr>';
          $html_renew .= '<td>'.$row['Name'].'</td>';
          $html_renew .= '<td>'.$row['Plate'].'</td>';
          $html_renew .= '<td>'.$row['Arrival'].'</td>';
          $html_renew .= '<td>'.$row['Type'].'</td>';
          $html_renew .= '</tr>';
        }
      }
      foreach($stmt2->fetchAll() as $row) {
        $html_exit .= '<tr>';
        $html_exit .= '<td>'.$row['Name'].'</td>';
        $html_exit .= '<td>'.$row['Plate'].'</td>';
        $html_exit .= '<td>'.$row['Departure'].'</td>';
        $html_exit .= '<td>'.$row['Type'].'</td>';
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
    //Time Calculation, displays in a msg
    function timeCalc($time1, $time2) {
      try {
        if(isset($time1)) {
          $d1 = new \DateTime($time1);
          $d2 = new \DateTime($time2);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);
          echo "Parked for <b>".$h."</b> hours and <b>".$int->format('%i')."</b> minutes";
        }
      } catch (\Exception $e) {
        echo "<red>Time Construction error, please check & correct</red>";
      }
    }
    // Create Parking Record
    function Parking_Record_Create($ANPRRef, $Plate, $Trl, $Name, $TimeIN, $Expiry, $VehType, $Account_ID) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $site = $this->user->Info("campus");
      $uid = $this->user->Info("campus");
      $Author = $this->user->Info("first_name");
      $Uniqueref = $uid.date("YmdHis").$site;
      $ExitKey = mt_rand(111111, 999999);
      $Patch = $this->ANPR_Info($ANPRRef, "Patch");
      $Overview = $this->ANPR_Info($ANPRRef, "Overview");
      $Patch = str_replace($this->pm->Site_Info($site, 'site_anpr_imgstr'), $this->pm->Site_Info($site, 'site_anpr_img'), $Patch);
      $Overview = str_replace($this->pm->Site_Info($site, 'site_anpr_imgstr'), $this->pm->Site_Info($site, 'site_anpr_img'), $Overview);
      $Plate = strtoupper($Plate);


      $stmt = $this->mysql->dbc->prepare("INSERT INTO pm_parking_records (id, Uniqueref, ANPRRef, Site, Plate, Name, Type, Arrival, Expiry, Departure, Parked_Column, Account_ID, Trailer_No, Author, Flagged, Deleted, Notes, ExitKey, Img_Patch, Img_Overview) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', 1, ?, ?, ?, '0', '0', '', ?, ?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindParam(2, $ANPRRef);
      $stmt->bindParam(3, $site);
      $stmt->bindParam(4, $Plate);
      $stmt->bindParam(5, $Name);
      $stmt->bindParam(6, $VehType);
      $stmt->bindParam(7, $TimeIN);
      $stmt->bindParam(8, $Expiry);
      $stmt->bindParam(9, $Account_ID);
      $stmt->bindParam(10, $Trl);
      $stmt->bindParam(11, $Author);
      $stmt->bindParam(12, $ExitKey);
      $stmt->bindParam(13, $Patch);
      $stmt->bindParam(14, $Overview);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        echo "UNSUCCESSFUL";
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
  }
?>
