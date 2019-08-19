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
    function ANPR_Feed()
    {
      //Lane ID is set to 0 for entry on SNAP's new ANPR (Otherwise 1)
      $this->user = new User;
      $campus = $this->user->Info("Site");
      $count_anpr = 0;
      if($this->user->Info("ANPR") == 1) {
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
            $patch = str_replace($this->pm->Site_Info($campus, 'ANPR_Imgstr'), $this->pm->Site_Info($campus, 'ANPR_Img'), $row['Patch']);
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
    function ANPR_Duplicate($ref)
    {
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
    function ANPR_AddPlate($plate, $time)
    {
      $this->mssql = new MSSQL;
      //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID, BarcodeExpression)
      $plate = str_replace(" ","", $plate);
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
    function ANPR_Update($ref, $plate, $trl = '', $time)
    {
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
    // Update ANPR Record (array)
    function ANPR_PaymentUpdate($ref, $expiry)
    {
      $this->mssql = new MSSQL;

      $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $expiry);
      $stmt->bindParam(2, $ref);
      $stmt->execute();

      $this->mssql = null;
    }
    // get images
    function ANPR_GetImages($ref)
    {
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");

      $html = "";

      $stmt = $this->mssql->dbc->prepare("SELECT Overview, Patch FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if(count($result) > 0) {
        if($result['Patch'] != "") {
          $patch = str_replace($this->pm->Site_Info($campus, 'ANPR_Imgstr'), $this->pm->Site_Info($campus, 'ANPR_Img'), $result['Patch']);
          $overview = str_replace($this->pm->Site_Info($campus, 'ANPR_Imgstr'), $this->pm->Site_Info($campus, 'ANPR_Img'), $result['Overview']);
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
    function ANPR_Info($ref, $what)
    {
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");

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
    function ALLVEH_Feed()
    {
      $this->user = new User;
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");
      $html_paid = '';
      $html_renew = '';
      $html_exit = '';

      $current = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Deleted != '1' AND Parked_Column != '2' ORDER BY Expiry DESC");
      $stmt->bindParam(1, $campus);
      $stmt->execute();

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Deleted != '1' AND Parked_Column = '2' ORDER BY Departure DESC LIMIT 30");
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
        $ref = '\''.$row['Uniqueref'].'\'';
        $plate = '\''.$row['Plate'].'\'';
        $trl = '\''.$row['Trailer_No'].'\'';
        $timein = '\''.$row['Arrival'].'\'';
        $date = '\''.$row['Expiry'].'\'';
        $flag = $row['Flagged'];

        if($flag == "1") {
          $flagIco = '<i style="color: red;" class="far fa-flag"></i>';
        } else {
          $flagIco = '';
        }
        // Paid
        if($row['Expiry'] >= $current) {
          $html_paid .= '<tr>';
          $html_paid .= '<td>'.$flagIco.' '.$row['Name'].'</td>';
          $html_paid .= '<td>'.$row['Plate'].'</td>';
          $html_paid .= '<td>'.date("d/H:i", strtotime($row['Arrival'])).'</td>';
          $html_paid .= '<td>'.$this->pm->GET_VehicleType($row['Type']).'</td>';
          $html_paid .= '<td>
                          <div class="btn-group" role="group" aria-label="Options">
                            <button type="button" class="btn btn-danger" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')"><i class="fa fa-cog"></i></button>
                            <button type="button" class="btn btn-danger" onClick="QuickExit('.$ref.')"><i class="fa fa-times"></i></button>
                          </div>
                          </td>';
          $html_paid .= '</tr>';
        }
        // Renewal
        if($row['Expiry'] <= $current) {
          $number = $this->pm->Hour($row['Expiry'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          $html_renew .= '<tr class="'.$style.'">';
          $html_renew .= '<td>'.$row['Name'].'</td>';
          $html_renew .= '<td>'.$row['Plate'].'</td>';
          $html_renew .= '<td>'.date("d/H:i", strtotime($row['Arrival'])).'</td>';
          $html_renew .= '<td>'.$this->pm->GET_VehicleType($row['Type']).'</td>';
          $html_renew .= '<td>
                            <div class="btn-group" role="group" aria-label="Options">
                              <button type="button" class="btn btn-danger" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')"><i class="fa fa-cog"></i></button>
                              <button type="button" class="btn btn-danger" onClick="PaymentPaneToggle('.$ref.', '.$plate.', '.$trl.', '.$date.', 2)"><i class="fa fa-pound-sign"></i></button>
                              <button type="button" class="btn btn-danger" onClick="QuickExit('.$ref.')"><i class="fa fa-times"></i></button>
                            </div>
                          </td>';
          $html_renew .= '</tr>';
        }
      }

      foreach($stmt2->fetchAll() as $row) {
        $ref = '\''.$row['Uniqueref'].'\'';
        $timein = '\''.$row['Arrival'].'\'';

        $html_exit .= '<tr>';
        $html_exit .= '<td>'.$row['Name'].'</td>';
        $html_exit .= '<td>'.$row['Plate'].'</td>';
        $html_exit .= '<td>'.date("d/H:i", strtotime($row['Departure'])).'</td>';
        $html_exit .= '<td>'.$this->pm->GET_VehicleType($row['Type']).'</td>';
        $html_exit .= '<td><button type="button" class="btn btn-danger" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')"><i class="fa fa-cog"></i></button></td>';
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
      $this->pm = null;
    }
    //Time Calculation, displays in a msg
    function timeCalc($time1, $time2)
    {
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
    function Parking_Record_Create($ANPRRef, $Plate, $Trl, $Name, $TimeIN, $Expiry, $VehType, $Account_ID)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $site = $this->user->Info("Site");
      $uid = $this->user->Info("id");
      $Author = $this->user->Info("FirstName");
      $ExitKey = mt_rand(11111, 99999);
      $ExitKey = str_replace("0", "9", $ExitKey);
      $Uniqueref = $uid.date("YmdHis").$ExitKey;
      $Patch = $this->ANPR_Info($ANPRRef, "Patch");
      $Overview = $this->ANPR_Info($ANPRRef, "Overview");
      $Patch = str_replace($this->pm->Site_Info($site, 'ANPR_Imgstr'), $this->pm->Site_Info($site, 'ANPR_Img'), $Patch);
      $Overview = str_replace($this->pm->Site_Info($site, 'ANPR_Imgstr'), $this->pm->Site_Info($site, 'ANPR_Img'), $Overview);
      $Plate = strtoupper($Plate);
      $Name = strtoupper($Name);
      $time = date("Y-m-d H:i:s");


      $stmt = $this->mysql->dbc->prepare("INSERT INTO parking_records (id, Uniqueref, ANPRRef, Site, Plate, Name, Type, Arrival, Expiry, Departure, Parked_Column, AccountID, Trailer_No, Author, Flagged, Deleted, Notes, ExitKey, Img_Patch, Img_Overview, Last_Updated) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', 1, ?, ?, ?, '0', '0', '', ?, ?, ?, ?)");
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
      $stmt->bindParam(15, $time);
      if($stmt->execute()) {
        return $Uniqueref;
      } else {
        echo "UNSUCCESSFUL Parking";
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    // get images
    function GetImages($ref)
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $campus = $this->user->Info("Site");

      $html = "";

      $stmt = $this->mysql->dbc->prepare("SELECT Img_Overview, Img_Patch FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if($result['Img_Patch'] != "") {
        $patch = $result['Img_Patch'];
        $overview = $result['Img_Overview'];
        $html .= '<img src="'.$patch.'" alt="" class="img-thumbnail">';
        $html .= '<img src="'.$overview.'" alt="" class="img-thumbnail">';
      } else {
        $html .= "";
      }
      echo json_encode($html);

      $this->mssql = null;
      $this->user = null;
    }
    // Vehicle information
    function Info($ref, $what)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $result[$what];
      $this->mysql = null;
    }
    // Update a vehicles expiry time.
    function ExpiryUpdate($ref, $time)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Expiry = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $time);
      $stmt->bindParam(2, $ref);
      $stmt->execute();

      $this->mysql = null;
    }
    // Get all details for updating record
    function GetDetails($ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);

      $this->mysql = null;
    }
    // Update Vehicle record
    function UpdateRecord($ref, $plate, $name, $trl, $type, $column, $arrival, $exit, $comment)
    {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $name = strtoupper($name);
      $plate = strtoupper($plate);
      $time = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Plate = ?, Name = ?, Trailer_No = ?, Type = ?, Parked_Column = ?, Arrival = ?, Departure = ?, Notes = ?, Last_Updated = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $plate);
      $stmt->bindParam(2, $name);
      $stmt->bindParam(3, $trl);
      $stmt->bindParam(4, $type);
      $stmt->bindParam(5, $column);
      $stmt->bindParam(6, $arrival);
      $stmt->bindParam(7, $exit);
      $stmt->bindParam(8, $comment);
      $stmt->bindParam(9, $time);
      $stmt->bindParam(10, $ref);
      if($stmt->execute()) {
        $this->pm->POST_Notifications("A vehicle record has been updated @ ".date("d/H:i:s").", Ref: ".$ref, '0');
      } else {
        echo "UNSUCCESSFUL";
      }


      $this->mysql = null;
      $this->pm = null;
    }
    // Check Duplicate
    function CheckDuplicate($plate)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $site = $this->user->Info("Site");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Plate = ? AND Parked_Column < 2");
      $stmt->bindParam(1, $site);
      $stmt->bindParam(2, $plate);
      $stmt->execute();
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      $result = $stmt->rowCount();

      if($result > 0) {
        $response = array('Response' => 'TRUE', 'Ref' => $data['Uniqueref'], 'Time' => $data['Arrival']);
        echo json_encode($response);
      } else {
        $response = array('Response' => 'FALSE');
        echo json_encode($response);
      }

      $this->mysql = null;
      $this->user = null;
    }
    // Quick Exit
    function QuickExit($ref)
    {
      $this->mysql = new MySQL;
      $cur = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = 2 WHERE Uniqueref = ?");
      $stmt->bindParam(1, $cur);
      $stmt->bindParam(2, $ref);
      $stmt->execute();

      $this->mysql = null;
    }
    // Quick Flag
    function QuickFlag($ref, $flag)
    {
      $this->mysql = new MySQL;

      if($flag == "1") {
        $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Flagged = 0 WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
      } else {
        $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Flagged = 1 WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
      }

      $this->mysql = null;
    }
  }

?>
