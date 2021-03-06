<?php
  namespace ParkingManager;
  class Vehicles
  {
    protected $mysql;
    protected $mssql;
    // ANPR TOOLS
    // ANPR Feed is called via ajax when ID="ANPR_FEED" is loaded in tpl
    function ANPR_Feed_OLD()
    {
      global $_CONFIG;
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->Info("Site");
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        if($this->user->Info("ANPR") == 1) {
          $this->mssql = new MSSQL;
          $html = '';
          if($this->pm->Site_Info($campus, "Secondary_ANPR") == 1) {
            // My Site ANPR Feed
            $mine = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
            $mine->execute();
            // My Site  Exit ANPR Feed
            $mine2 = $this->mssql->dbc->prepare("SELECT TOP 100 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 1 AND Lane_ID = 2 ORDER BY Capture_Date DESC");
            $mine2->execute();

            $sec_tbl = '<table class="table table-dark table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Registration</th>
                <th scope="col">Time IN</th>
                <th scope="col">Patch</th>
                <th scope="col"><i class="fa fa-cog"></i></th>
              </tr>
              </thead>
            <tbody>';
            if($this->mssql->dbc2 != null)
            {
              // Secondary ANPR Feed
              $sec = $this->mssql->dbc2->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
              $sec->execute();
              // Mine Table
              foreach ($sec->fetchAll() as $row) {
                $plate = '\''.$row['Plate'].'\'';
                $trl = '\''.$row['Notes'].'\'';
                $date = '\''.$row['Capture_Date'].'\'';
                //Get The right Path now.
                if(isset($campus)) {
                  $patch = str_replace($this->pm->Site_Info($campus, 'Secondary_ANPR_Imgstr'), $this->pm->Site_Info($campus, 'Secondary_ANPR_Img'), $row['Patch']);
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
                $sec_tbl .= '<tr id="ANPR_Secondary_Feed_'.$row['Uniqueref'].'" class="'.$style.'">';
                $sec_tbl .= '<td>'.$row['Plate'].'</td>';
                $sec_tbl .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
                $sec_tbl .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
                $sec_tbl .= '<td>
                            <div class="btn-group" role="group" aria-label="Options">
                              <button type="button" onClick="ANPR_Secondary_Update('.$row['Uniqueref'].', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                              <button type="button" onClick="ANPR_Secondary_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                          </td>';
                $sec_tbl .= '</tr>';
              }
              $sec_tbl .= '</tbody>
                      </table>';
            } else {
              $sec_tbl .= "";
            }
            $mine_tbl = '<table class="table table-dark table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Registration</th>
                <th scope="col">Time IN</th>
                <th scope="col">Patch</th>
                <th scope="col"><i class="fa fa-cog"></i></th>
              </tr>
              </thead>
            <tbody>';
            $mine2_tbl = '<table class="table table-dark table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Registration</th>
                <th scope="col">Time IN</th>
                <th scope="col">Patch</th>
              </tr>
              </thead>
            <tbody>';
            // Mine Table
            foreach ($mine->fetchAll() as $row) {
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
              $mine_tbl .= '<tr id="ANPR_Feed_'.$row['Uniqueref'].'" class="'.$style.'">';
              $mine_tbl .= '<td>'.$row['Plate'].'</td>';
              $mine_tbl .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
              $mine_tbl .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
              $mine_tbl .= '<td>
                          <div class="btn-group" role="group" aria-label="Options">
                            <button type="button" onClick="ANPR_Update('.$row['Uniqueref'].', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                            <button type="button" onClick="PaymentPaneToggle('.$row['Uniqueref'].', '.$plate.', '.$trl.', '.$date.', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                            <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                          </div>
                        </td>';
              $mine_tbl .= '</tr>';
            }
            $mine_tbl .= '</tbody>
                    </table>';
            // Mine2 Table
            foreach ($mine2->fetchAll() as $row) {
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
              //Begin Table.
              $mine2_tbl .= '<tr id="ANPR_Feed_'.$row['Uniqueref'].'">';
              $mine2_tbl .= '<td>'.$row['Plate'].'</td>';
              $mine2_tbl .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
              $mine2_tbl .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
              $mine2_tbl .= '</tr>';
            }
            $mine2_tbl .= '</tbody>
                    </table>';

            $html .= '<ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="primary-tab" data-toggle="tab" href="#primary" role="tab" aria-controls="primary" aria-selected="true"><i class="fa fa-video red"></i> My ANPR Feed</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="primary2-tab" data-toggle="tab" href="#primary2" role="tab" aria-controls="primary2" aria-selected="false">Exit ANPR Feed</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="secondary-tab" data-toggle="tab" href="#secondary" role="tab" aria-controls="secondary" aria-selected="false">Secondary ANPR Feed</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="primary" role="tabpanel" aria-labelledby="primary-tab">'.$mine_tbl.'</div>
                        <div class="tab-pane fade" id="primary2" role="tabpanel" aria-labelledby="primary2-tab">'.$mine2_tbl.'</div>
                        <div class="tab-pane fade" id="secondary" role="tabpanel" aria-labelledby="secondary-tab">'.$sec_tbl.'</div>
                      </div>';

            echo json_encode(array("Feed" => $html));
          } else {
            $mine_tbl = '<table class="table table-dark table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Registration</th>
                <th scope="col">Time IN</th>
                <th scope="col">Patch</th>
                <th scope="col"><i class="fa fa-cog"></i></th>
              </tr>
              </thead>
            <tbody>';
            // My Site ANPR Feed
            $mine = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Capture_Date DESC");
            $mine->execute();
            // Mine Table
            foreach ($mine->fetchAll() as $row) {
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
              $mine_tbl .= '<tr id="ANPR_Feed_'.$row['Uniqueref'].'" class="'.$style.'">';
              $mine_tbl .= '<td>'.$row['Plate'].'</td>';
              $mine_tbl .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
              $mine_tbl .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
              $mine_tbl .= '<td>
                          <div class="btn-group" role="group" aria-label="Options">
                            <button type="button" onClick="ANPR_Update('.$row['Uniqueref'].', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                            <button type="button" onClick="PaymentPaneToggle('.$row['Uniqueref'].', '.$plate.', '.$trl.', '.$date.', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                            <button type="button" onClick="ANPR_Duplicate('.$row['Uniqueref'].')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                          </div>
                        </td>';
              $mine_tbl .= '</tr>';
            }
            $mine_tbl .= '</tbody>
                    </table>';
            // My Site ANPR Feed
            $mine2 = $this->mssql->dbc->prepare("SELECT TOP 100 Uniqueref, Plate, Capture_Date, Patch, Notes FROM ANPR_REX WHERE Direction_Travel = 1 AND Lane_ID = 2 ORDER BY Capture_Date DESC");
            $mine2->execute();
            $mine2_tbl = '<table class="table table-dark table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col">Registration</th>
                <th scope="col">Time IN</th>
                <th scope="col">Patch</th>
              </tr>
              </thead>
            <tbody>';
            // Mine2 Table
            foreach ($mine2->fetchAll() as $row) {
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
              //Begin Table.
              $mine2_tbl .= '<tr id="ANPR_Feed_'.$row['Uniqueref'].'">';
              $mine2_tbl .= '<td>'.$row['Plate'].'</td>';
              $mine2_tbl .= '<td>'.date("d/H:i", strtotime($row['Capture_Date'])).'</td>';
              $mine2_tbl .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
              $mine2_tbl .= '</tr>';
            }
            $mine2_tbl .= '</tbody>
                    </table>';

            $html .= '<ul class="nav nav-tabs" id="myTab3" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="primary-tab" data-toggle="tab" href="#primary" role="tab" aria-controls="primary" aria-selected="true"><i class="fa fa-video red"></i> My ANPR Feed</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="primary2-tab" data-toggle="tab" href="#primary2" role="tab" aria-controls="primary2" aria-selected="false">Exit ANPR Feed</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent3">
                        <div class="tab-pane fade show active" id="primary" role="tabpanel" aria-labelledby="primary-tab">'.$mine_tbl.'</div>
                        <div class="tab-pane fade" id="primary2" role="tabpanel" aria-labelledby="primary2-tab">'.$mine2_tbl.'</div>
                      </div>';
            echo json_encode(array("Feed" => $html));
          }
        } else {
          echo json_encode("Your ANPR has been disabled.");
        }
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE LaneID = 1 AND Status = 0 ORDER BY CaptureTime DESC LIMIT 200");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $html = '<table class="table table-dark table-hover">
                    <thead>
                      <th>Plate</th>
                      <th>Capture Time</th>
                      <th>Options</th>
                    </thead>
                    <tbody>';
          foreach($stmt->fetchAll() as $row) {
            $trl = '\''.''.'\'';
            $plate = '\''.$row['Plate'].'\'';
            $date = '\''.$row['CaptureTime'].'\'';
            $ref = '\''.$row['Uniqueref'].'\'';
            $number = $this->pm->Hour($row['CaptureTime'], "");
            $style = "";
            if($number >= 2 && $number < 4) {
              $style = "table-warning";
            } else if ($number >= 4) {
              $style = "table-danger";
            }
            $html .= '<tr class="'.$style.'">
                        <td>'.$row['Plate'].'</td>
                        <td>'.$row['CaptureTime'].'</td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Options">
                            <button type="button" onClick="ANPR_Update('.$ref.', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$row['Uniqueref'].'"><i class="fa fa-cog"></i></button>
                            <button type="button" onClick="PaymentPaneToggle('.$ref.', '.$plate.', '.$trl.', '.$date.', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                            <button type="button" onClick="ANPR_Duplicate('.$ref.')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                      </tr>';
          }
          $html .= '</tbody></table>';
          echo json_encode(array("Feed" => $html));
        } else {
          echo json_encode(array("Feed" => "No Records"));
        }
      }
    }
    // REV
    function ANPR_Feed()
    {
      global $_CONFIG;
      if($_CONFIG)
      $this->rev = new Rev;
      $this->pm = new PM;
      $html = '';

      $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE LaneGroup = 1 AND LaneID = 1 AND Status < 1 ORDER BY CaptureTime DESC LIMIT 200");
      $stmt->execute();
      if($stmt->rowCount() > 0)
      {
        $html .= '<table class="table table-dark table-hover table-bordered">
                    <thead>
                      <th>Plate</th>
                      <th>Arrival</th>
                      <th>Image</th>
                      <th><i class="fa fa-cogs"></i></th>
                    </thead>';
        foreach($stmt->fetchAll() as $row)
        {
          $number = $this->pm->Hour($row['CaptureTime'], "");
          $style = "";
          if($number >= 2 && $number < 4) {
            $style = "table-warning";
          } else if ($number >= 4) {
            $style = "table-danger";
          }
          if($row['Images'] != null OR $row['Images'] != '') {
            $images = json_decode($row['Images'], true);
            $img = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/".$images['Plate'];
          } else {
            $img = "";
          }
          $plate = '\''.$row['Plate'].'\'';
          $date = '\''.$row['CaptureTime'].'\'';
          $ref = '\''.$row['Uniqueref'].'\'';
          $trl = '\''.''.'\'';
          $html .= '<tr class="'.$style.'" id="ANPR_Feed_'.$row['Uniqueref'].'">
                      <td>'.$row['Plate'].'</td>
                      <td>'.date("d/H:i:s", strtotime($row['CaptureTime'])).'</td>
                      <td><img style="max-width: 300px;" src="'.$img.'"></img></td>
                      <td>
                        <div class="btn-group">
                          <button type="button" onClick="ANPR_Update('.$ref.', '.$plate.', '.$date.', '.$trl.')" class="btn btn-danger" data-id="'.$ref.'"><i class="fa fa-cog"></i></button>
                          <button type="button" onClick="PaymentPaneToggle('.$ref.', '.$plate.', '.$trl.', '.$date.', 1)" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                          <button type="button" onClick="ANPR_Duplicate('.$ref.')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                      </td>
                    </tr>';
        }
      }
      else
      {
        $html .= 'No records.';
      }

      echo json_encode(array("Feed" => $html));

      $this->rev = null;
      $this->pm = null;
    }
    // // Count all vehicles in ANPR
    function ANPR_Feed_Count()
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->user = new User;

        if($this->user->Info("ANPR") == 1) {
          $this->mssql = new MSSQL;
          $this->anprCount = $this->mssql->dbc->prepare("SELECT TOP 200 Uniqueref FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status = 0 ORDER BY Capture_Date DESC");
          $this->anprCount->execute();
          return count($this->anprCount->fetchAll());

          $this->mssql = null;
          $this->anprCount = null;
        } else {
          return $this->anprCount = 0;
        }

        $this->user = null;
        $this->mssql = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->user = new User;
        $this->rev = new Rev;
        if($this->user->Info("ANPR") == 1) {
          $stmt = $this->rev->dbc->prepare("SELECT id FROM rev_plates WHERE LaneID = 1 AND Status < 1");
          $stmt->execute();
          return $stmt->rowCount();
        }
        $this->user = null;
        $this->rev = null;
      }
    }
    // ANPR Duplicate vehicle, remove from feed.
    function ANPR_Duplicate($ref)
    {
      global $_CONFIG;

      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;

        $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 11 WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        if($stmt->execute()) {
          print_r("SUCCESSFUL");
        } else {
          print_r("UNSUCCESSFUL");
        }

        $this->mssql = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $stmt = $this->rev->dbc->prepare("UPDATE rev_plates SET Status = 99 WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        if($stmt->execute()) {
          print_r("SUCCESSFUL");
        } else {
          print_r("UNSUCCESSFUL");
        }
        $this->rev = null;
      }
    }
    // ANPR Duplicate vehicle, remove from feed.
    function ANPR_Secondary_Duplicate($ref)
    {
      $this->mssql = new MSSQL;

      $stmt = $this->mssql->dbc2->prepare("UPDATE ANPR_REX SET Status = 11 WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      if($stmt->execute()) {
        print_r("SUCCESSFUL");
      } else {
        print_r("UNSUCCESSFUL");
      }

      $this->mssql = null;
    }
    // Add a vehicle into the anpr
    function ANPR_AddPlate($plate, $time)
    {
      global $_CONFIG;
      $this->pm = new PM;

      $plate = str_replace(" ","", $plate);
      $plate = str_replace("-","", $plate);
      $plate = strip_tags(stripslashes(strtoupper($plate)));
      $plate = $this->pm->RemoveSlashes($plate);

      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;
        //(Uniqueref, UID, Plate, ANPR, Overview, Patch, Area, Lane_ID, Lane_Name, Capture_Date, Station_ID, Station_Name, Direction_Travel, Confidence, Status, Original_Plate, Notes, Link_Uniqueref, Expiry, EuroSalesID, BarcodeExpression)
        if(!empty($plate) AND !empty($time)) {
          //Includes latest anpr update.
          $stmt = $this->mssql->dbc->prepare("INSERT INTO ANPR_REX VALUES ('1', :plate, null, null, null, null, '1', 'Entry Lane 01', :capDate, :createdDate, null, 'RoadKing - Added VIA PM', '0', null, '0', :plate2, null, null, :capDate2, null, '', '', '')");
          $stmt->bindParam(':plate', $plate);
          $stmt->bindParam(':capDate', $time);
          $stmt->bindParam(':createdDate', $time);
          $stmt->bindParam(':plate2', $plate);
          $stmt->bindParam(':capDate2', $time);
          $stmt->execute();
        }

        $this->mssql = null;
        $this->pm = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;

        $Uniqueref = mt_rand(11111111, 99999999);
        $stmt = $this->rev->dbc->prepare("INSERT INTO rev_plates (Uniqueref, Plate, OriginalPlate, Country, CaptureTime, ExpiryTime, Images, CameraID, LaneID, LaneName, LaneGroup, Parkingref, ExitCode, ManualEntry, Status) VALUES (?, ?, ?, 'NON', ?, ?, '', '0', '1', 'Entry Lane', '1', '', '00000', '1', '0')");
        $stmt->bindParam(1, $Uniqueref);
        $stmt->bindParam(2, $plate);
        $stmt->bindParam(3, $plate);
        $stmt->bindParam(4, $time);
        $stmt->bindParam(5, $time);
        $stmt->execute();

        $this->rev = null;
      }
    }
    // Update ANPR Record
    function ANPR_Update($ref, $plate, $trl = '', $time)
    {
      global $_CONFIG;
      $this->pm = new PM;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        if(!empty($plate) AND !empty($time)) {
          $this->mssql = new MSSQL;
          $plate = strip_tags(strtoupper($plate));
          $trl = strip_tags(strtoupper($trl));
          $plate = $this->pm->RemoveSlashes($plate);
          $trl = $this->pm->RemoveSlashes($trl);
          $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Plate = ?, Capture_Date = ?, Notes = ? WHERE Uniqueref = ?");
          $stmt->bindParam(1, $plate);
          $stmt->bindParam(2, $time);
          $stmt->bindParam(3, $trl);
          $stmt->bindParam(4, $ref);
          if($stmt->execute()) {
            if($stmt->rowCount() > 0) {
              echo json_encode(array('Status' => 1, 'Message' => 'Successfully updated registration '.$plate));
            } else {
              echo json_encode(array('Status' => 0, 'Message' => $plate.' has not been updated, please check and try again.'));
            }
          } else {
            echo json_encode(array('Status' => 0, 'Message' => $plate.' has not been updated, please check and try again.'));
          }
        }
        $this->mssql = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $plate = strip_tags(strtoupper($plate));
        $trl = strip_tags(strtoupper($trl));
        $plate = $this->pm->RemoveSlashes($plate);
        $trl = $this->pm->RemoveSlashes($trl);
        if(!empty($plate) AND !empty($time)) {
          $this->rev = new Rev;
          $stmt = $this->rev->dbc->prepare("UPDATE rev_plates SET Plate = ?, CaptureTime = ? WHERE Uniqueref = ?");
          $stmt->bindParam(1, $plate);
          $stmt->bindParam(2, $time);
          $stmt->bindParam(3, $ref);
          if($stmt->execute()) {
            if($stmt->rowCount() > 0) {
              echo json_encode(array('Status' => 1, 'Message' => 'Successfully updated registration '.$plate));
            } else {
              echo json_encode(array('Status' => 0, 'Message' => $plate.' has not been updated, please check and try again.'));
            }
          } else {
            echo json_encode(array('Status' => 0, 'Message' => $plate.' has not been updated, please check and try again.'));
          }
        }
        $this->rev = null;
      }
      $this->pm = null;
    }
    // Update ANPR Secondary Record
    function ANPR_Secondary_Update($ref, $plate, $trl = '', $time)
    {
      $this->mssql = new MSSQL;
      if(!empty($plate) AND !empty($time)) {
        $plate = strip_tags(strtoupper($plate));
        $trl = strip_tags(strtoupper($trl));
        $stmt = $this->mssql->dbc2->prepare("UPDATE ANPR_REX SET Plate = ?, Capture_Date = ?, Notes = ? WHERE Uniqueref = ?");
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
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;

        $stmt = $this->mssql->dbc->prepare("UPDATE ANPR_REX SET Status = 100, Expiry = ? WHERE Uniqueref = ?");
        $stmt->bindParam(1, $expiry);
        $stmt->bindParam(2, $ref);
        $stmt->execute();

        $this->mssql = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;

        $stmt = $this->rev->dbc->prepare("UPDATE rev_plates SET Status = 1, ExpiryTime = ? WHERE Uniqueref = ?");
        $stmt->bindParam(1, $expiry);
        $stmt->bindParam(2, $ref);
        $stmt->execute();

        $this->rev = null;
      }
    }
    // get images
    function ANPR_GetImages($ref)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
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
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $html = '';

        $stmt = $this->rev->dbc->prepare("SELECT Images FROM rev_plates WHERE Uniqueref = ?");
        $stmt->bindValue(1, $ref);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $row = $stmt->fetch(\PDO::FETCH_ASSOC);
          if($row['Images'] != null OR $row['Images'] != '') {
            $images = json_decode($row['Images'], true);
            $plate = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/".$images['Plate'];
            $front = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/".$images['Front'];
            $html .= '<hr>';
            $html .= '<img src="'.$plate.'" alt="" class="img-thumbnail">';
            $html .= '<img src="'.$front.'" alt="" class="img-thumbnail">';
          } else {
            $html .= 'Can\'t find any images.';
          }
        } else {
          $html .= 'Can\'t find any images.';
        }
        echo json_encode($html);
        $this->rev = null;
      }
    }
    // get images secondary
    function ANPR_Secondary_GetImages($ref)
    {
      $this->mssql = new MSSQL;
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");

      $html = "";

      $stmt = $this->mssql->dbc2->prepare("SELECT Overview, Patch FROM ANPR_REX WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      if(count($result) > 0) {
        if($result['Patch'] != "") {
          $patch = str_replace($this->pm->Site_Info($campus, 'Secondary_ANPR_Imgstr'), $this->pm->Site_Info($campus, 'Secondary_ANPR_Img'), $result['Patch']);
          $overview = str_replace($this->pm->Site_Info($campus, 'Secondary_ANPR_Imgstr'), $this->pm->Site_Info($campus, 'Secondary_ANPR_Img'), $result['Overview']);
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
    function ANPR_Info($ref, $what)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;


        $stmt = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(count($result) > 0) {
          return $result[$what];
        } else {

        }
        $this->mssql = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE Uniqueref = ?");
        $stmt->bindParam(1, $ref);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          return $result[$what];
        }
        $this->rev = null;
      }
    }
    // Search ANPR Records VIA Modal
    function Search_ANPR_Records($key)
    {
      $string = "%".$key."%";
      $this->mssql = new MSSQL;
      $this->pm = new PM;
      $this->user = new User;
      $campus = $this->user->Info("Site");

      $stmt = $this->mssql->dbc->prepare("SELECT TOP 30 Plate, Capture_Date, Patch, Overview, Notes, Lane_Name FROM ANPR_REX WHERE Plate LIKE ? OR Notes LIKE ? ORDER BY Capture_Date DESC");
      $stmt->bindParam(1, $string);
      $stmt->bindParam(2, $string);
      $stmt->execute();

      $stmt2 = $this->mssql->dbc->prepare("SELECT TOP 30 Plate, Capture_Date, Patch, Overview, Notes, Lane_Name FROM ANPR_REX_Archive WHERE Plate LIKE ? OR Notes LIKE ? ORDER BY Capture_Date DESC");
      $stmt2->bindParam(1, $string);
      $stmt2->bindParam(2, $string);
      $stmt2->execute();

      $html = '<table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">Plate</th>
                    <th scope="col" style="width: 20%;">Trailer</th>
                    <th scope="col">Capture Date</th>
                    <th scope="col">Lane</th>
                  </tr>
                </thead>
                <tbody>';

      foreach($stmt->fetchAll() as $row) {
        $patch = str_replace($this->pm->Site_Info($campus, 'ANPR_Imgstr'), $this->pm->Site_Info($campus, 'ANPR_Img'), $row['Patch']);

        $html .= '<tr>';
        $html .= '<td>'.$row['Plate'].'</td>';
        $html .= '<td>'.$row['Notes'].'</td>';
        $html .= '<td>'.date("d/m/y H:i", strtotime($row['Capture_Date'])).'</td>';
        $html .= '<td>'.$row['Lane_Name'].'</td>';
        $html .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
      }

      $html .= '</tbody>
              </table>';


      $html2 = '<table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">Plate</th>
                    <th scope="col" style="width: 20%;">Trailer</th>
                    <th scope="col">Capture Date</th>
                    <th scope="col">Lane</th>
                  </tr>
                </thead>
                <tbody>';

      foreach($stmt2->fetchAll() as $row) {
        $patch = str_replace($this->pm->Site_Info($campus, 'ANPR_Imgstr'), $this->pm->Site_Info($campus, 'ANPR_Img'), $row['Patch']);

        $html2 .= '<tr>';
        $html2 .= '<td>'.$row['Plate'].'</td>';
        $html2 .= '<td>'.$row['Notes'].'</td>';
        $html2 .= '<td>'.date("d/m/y H:i", strtotime($row['Capture_Date'])).'</td>';
        $html2 .= '<td>'.$row['Lane_Name'].'</td>';
        $html2 .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
      }

      $html2 .= '</tbody>
              </table>';

      $return = '<ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="rex-tab" data-toggle="tab" href="#rex" role="tab" aria-controls="rex" aria-selected="true">Default</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="arc-tab" data-toggle="tab" href="#arc" role="tab" aria-controls="arc" aria-selected="false">Archived</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="rex" role="tabpanel" aria-labelledby="rex-tab">'.$html.'</div>
        <div class="tab-pane fade" id="arc" role="tabpanel" aria-labelledby="arc-tab">'.$html2.'</div>
      </div>';

      echo json_encode($return);

      $this->mssql = null;
      $this->pm = null;
      $this->user = null;
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
        } else if($flag == "2") {
          $flagIco = '<i class="fas fa-user-edit" style="color: red; font-size: 25px;"></i>';
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
          $html_renew .= '<td>'.$flagIco.' '.$row['Name'].'</td>';
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
        $flag = $row['Flagged'];
        $ref = '\''.$row['Uniqueref'].'\'';
        $timein = '\''.$row['Arrival'].'\'';
        if($flag == "1") {
          $flagIco = '<i style="color: red;" class="far fa-flag"></i>';
        } else if($flag == "2") {
          $flagIco = '<i class="fas fa-user-edit" style="color: red; font-size: 25px;"></i>';
        } else {
          $flagIco = '';
        }

        $html_exit .= '<tr>';
        $html_exit .= '<td>'.$flagIco.' '.$row['Name'].'</td>';
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
    function Parking_Record_Create($ANPRRef, $Plate, $Trl, $Name, $TimeIN, $Expiry, $VehType, $Account_ID, $Booking)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $site = $this->user->Info("Site");
      $uid = $this->user->Info("id");
      $Author = $this->user->Info("FirstName");
      $ExitKey = mt_rand(11111, 99999);
      $ExitKey = str_replace("0", "9", $ExitKey);
      $Uniqueref = $uid.date("YmdHis").$ExitKey;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $Patch = $this->ANPR_Info($ANPRRef, "Patch");
        $Overview = $this->ANPR_Info($ANPRRef, "Overview");
        $Patch = str_replace($this->pm->Site_Info($site, 'ANPR_Imgstr'), $this->pm->Site_Info($site, 'ANPR_Img'), $Patch);
        $Overview = str_replace($this->pm->Site_Info($site, 'ANPR_Imgstr'), $this->pm->Site_Info($site, 'ANPR_Img'), $Overview);
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $Images = $this->ANPR_Info($ANPRRef, "Images");
        $result = json_decode($Images, true);
        $Patch = $result['Plate'];
        $Overview = $result['Front'];
      }
      $Plate = strtoupper($Plate);
      $Name = strtoupper($Name);
      $time = date("Y-m-d H:i:s");


      $stmt = $this->mysql->dbc->prepare("INSERT INTO parking_records (id, Uniqueref, ANPRRef, Site, Plate, Name, Type, Arrival, Expiry, Departure, Parked_Column, AccountID, Trailer_No, Author, Flagged, Deleted, Notes, ExitKey, Img_Patch, Img_Overview, Bookingref, Last_Updated) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', 1, ?, ?, ?, '0', '0', '', ?, ?, ?, ?, ?)");
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
      $stmt->bindParam(15, $Booking);
      $stmt->bindParam(16, $time);
      if($stmt->execute()) {
        return array('Status' => '1', 'VID' => $Uniqueref);
      } else {
        return array('Status' => '0');
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    // get images
    function GetImages($ref)
    {
      global $_CONFIG;
      $this->mysql = new MySQL;
      $this->user = new User;

      $campus = $this->user->Info("Site");

      $html = "";

      $stmt = $this->mysql->dbc->prepare("SELECT Img_Overview, Img_Patch FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);
      $url = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/";
      if($result['Img_Patch'] != "") {
        $patch = $result['Img_Patch'];
        $overview = $result['Img_Overview'];
        $html .= '<img src="'.$url.$patch.'" alt="" class="img-thumbnail">';
        $html .= '<img src="'.$url.$overview.'" alt="" class="img-thumbnail">';
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
      $this->external = new External;
      $cur = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Uniqueref = ?");
      $stmt->bindParam(1, $ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($result['Bookingref'] != '' OR $result['Bookingref'] != null) {
          $return = $this->external->ModifyStatus_Portal($result['Bookingref'], "3");
          $result = json_decode($return, true);
          if($result['Status'] == 1) {
            $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = 2 WHERE Uniqueref = ?");
            $stmt->bindParam(1, $cur);
            $stmt->bindParam(2, $ref);
            $stmt->execute();
            echo json_encode(array('Status' => '1', 'Message' => 'Vehicle has exit and Portal has been notified.'));
          } else {
            $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = 2 WHERE Uniqueref = ?");
            $stmt->bindParam(1, $cur);
            $stmt->bindParam(2, $ref);
            $stmt->execute();
            echo json_encode(array('Status' => '0', 'Message' => 'Unable to exit vehicle on Portal. Please check the booking via Portal Management. '.$row['Plate']));
          }
        } else {
          $stmt = $this->mysql->dbc->prepare("UPDATE parking_records SET Departure = ?, Parked_Column = 2 WHERE Uniqueref = ?");
          $stmt->bindParam(1, $cur);
          $stmt->bindParam(2, $ref);
          $stmt->execute();
          echo json_encode(array('Status' => '1', 'Message' => 'Vehicle has exit.'));
        }
      }


      $this->mysql = null;
      $this->external = null;
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
    // Renewal Counter
    function Renewal_Feed_Count()
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Expiry =< CURRENT_TIMESTAMP AND Parked_Column != 2");
      $stmt->bindValue(1, $this->user->Info("Site"));
      $stmt->execute();

      return $stmt->rowCount();

      $this->mysql = null;
      $this->user = null;
    }
    // Parked Counter
    function Parked_Feed_Count()
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $stmt = $this->mysql->dbc->prepare("SELECT id FROM parking_records WHERE Site = ? AND Expiry >= CURRENT_TIMESTAMP AND Parked_Column != 2");
      $stmt->bindValue(1, $this->user->Info("Site"));
      $stmt->execute();

      return $stmt->rowCount();

      $this->mysql = null;
      $this->user = null;
    }
    // Yard Check
    function YardCheck()
    {
      global $_CONFIG;

      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mysql = new MySQL;
        $this->mssql = new MSSQL;
        $this->user = new User;

        $Site = $this->user->Info("Site");

        $stmt1 = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Parked_Column < 2 ORDER BY Plate ASC");
        $stmt1->bindParam(1, $Site);
        $stmt1->execute();

        $stmt2 = $this->mssql->dbc->prepare("SELECT TOP 200 * FROM ANPR_REX WHERE Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11 ORDER BY Plate DESC");
        $stmt2->execute();

        $html = '<table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col" style="width: 20%;">Trailer</th>
                      <th scope="col">Arrival</th>
                      <th scope="col" style="text-align: right"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>';

        foreach($stmt1->fetchAll() as $row) {
          $ref = '\''.$row['Uniqueref'].'\'';
          $ref2 = $row['Uniqueref'];
          $id = "YC".$ref2;
          $html .= '<tr id="YC'.$ref2.'">';
          $html .= '<td>'.$row['Plate'].'</td>';
          $html .= '<td style="max-width: 0px;">'.$row['Trailer_No'].'</td>';
          $html .= '<td>'.date("d/H:i", strtotime($row['Arrival'])).'</td>';
          $html .= '<td>
                        <div class="btn-group-toggle btn-lg float-right" data-toggle="buttons">
                          <button type="button" class="btn btn-danger" onClick="Checked('.$ref.')"><i class="fa fa-tick"></i> CONFIRMED </button>
                          <button type="button" class="btn btn-danger" onClick="QuickExit('.$ref.')"><i class="fa fa-times"></i></button>
                        </div>
                    </td>';
          $html .= '</tr>';
        }
        foreach($stmt2->fetchAll() as $row2) {
          $ref = $row2['Uniqueref'];
          $id = "YC".$ref;
          $html .= '<tr id="YC'.$ref.'">';
          $html .= '<td>'.$row2['Plate'].'</td>';
          $html .= '<td>'.$row2['Notes'].'</td>';
          $html .= '<td>'.date("d/H:i", strtotime($row2['Capture_Date'])).'</td>';
          $html .= '<td>
                        <div class="btn-group-toggle btn-lg float-right" data-toggle="buttons">
                          <button type="button" class="btn btn-danger" onClick="Checked('.$ref.')"><i class="fa fa-tick"></i> CONFIRMED </button>
                          <button type="button" onClick="ANPR_Duplicate('.$ref.')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                    </td>';
          $html .= '</tr>';
        }

        $html .= '</tbody>
        </table>';

        return $html;

        $this->mysql = null;
        $this->mssql = null;
        $this->user = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->mysql = new MySQL;
        $this->rev = new Rev;
        $this->user = new User;

        $Site = $this->user->Info("Site");

        $stmt1 = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Site = ? AND Parked_Column < 2 ORDER BY Plate ASC");
        $stmt1->bindParam(1, $Site);
        $stmt1->execute();

        $stmt2 = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE LaneID = 1 AND Status < 1 ORDER BY Plate DESC");
        $stmt2->execute();

        $html = '<table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col" style="width: 20%;">Trailer</th>
                      <th scope="col">Arrival</th>
                      <th scope="col" style="text-align: right"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>';

        foreach($stmt1->fetchAll() as $row) {
          $ref = '\''.$row['Uniqueref'].'\'';
          $ref2 = $row['Uniqueref'];
          $id = "YC".$ref2;
          $html .= '<tr id="YC'.$ref2.'">';
          $html .= '<td>'.$row['Plate'].'</td>';
          $html .= '<td style="max-width: 0px;">'.$row['Trailer_No'].'</td>';
          $html .= '<td>'.date("d/H:i", strtotime($row['Arrival'])).'</td>';
          $html .= '<td>
                        <div class="btn-group-toggle btn-lg float-right" data-toggle="buttons">
                          <button type="button" class="btn btn-danger" onClick="Checked('.$ref.')"><i class="fa fa-tick"></i> CONFIRMED </button>
                          <button type="button" class="btn btn-danger" onClick="QuickExit('.$ref.')"><i class="fa fa-times"></i></button>
                        </div>
                    </td>';
          $html .= '</tr>';
        }
        foreach($stmt2->fetchAll() as $row2) {
          $ref = '\''.$row2['Uniqueref'].'\'';
          $ref2 = $row2['Uniqueref'];
          $id = "YC".$ref2;
          $html .= '<tr id="YC'.$ref2.'">';
          $html .= '<td>'.$row2['Plate'].'</td>';
          $html .= '<td>N/A</td>';
          $html .= '<td>'.date("d/H:i", strtotime($row2['CaptureTime'])).'</td>';
          $html .= '<td>
                        <div class="btn-group-toggle btn-lg float-right" data-toggle="buttons">
                          <button type="button" class="btn btn-danger" onClick="Checked('.$ref.')"><i class="fa fa-tick"></i> CONFIRMED </button>
                          <button type="button" onClick="ANPR_Duplicate('.$ref.')" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                    </td>';
          $html .= '</tr>';
        }

        $html .= '</tbody>
        </table>';

        return $html;

        $this->mysql = null;
        $this->rev = null;
        $this->user = null;
      }
    }
    // Search Vehicle Records VIA Modal
    function Search_Parking_Records($key)
    {
      $string = "%".$key."%";
      $this->mysql = new MySQL;
      $this->user = new User;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate LIKE ? OR Name LIKE ? OR Trailer_No LIKE ? ORDER BY Arrival DESC LIMIT 20");
      $stmt->bindParam(1, $string);
      $stmt->bindParam(2, $string);
      $stmt->bindParam(3, $string);
      $stmt->execute();
      $html = '<table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col" style="width: 20%;">Name</th>
                    <th scope="col">Plate</th>
                    <th scope="col" style="width: 20%;">Trailer</th>
                    <th scope="col">Arrival</th>
                    <th scope="col" style="text-align: right"><i class="fa fa-cogs"></i></th>
                  </tr>
                </thead>
                <tbody>';

      foreach($stmt->fetchAll() as $row) {
        $ref = '\''.$row['Uniqueref'].'\'';
        $timein = '\''.$row['Arrival'].'\'';
        $html .= '<tr>';
        $html .= '<td>'.$row['Name'].'</td>';
        $html .= '<td>'.$row['Plate'].'</td>';
        $html .= '<td>'.$row['Trailer_No'].'</td>';
        $html .= '<td>'.date("d/m/y H:i", strtotime($row['Arrival'])).'</td>';
        $html .= '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Search_Records_Modal" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')"><i class="fa fa-cog"></i></button></td>';
      }

      $html .= '</tbody>
              </table>';

      echo json_encode($html);

      $this->mysql = null;
      $this->user = null;
    }
    // Director
    function Director($Plate)
    {
      global $_CONFIG;
      if($_CONFIG['ANPR']['Type'] == "ETP") {
        $this->mssql = new MSSQL;
        $this->mysql = new MySQL;
        $this->user = new User;
        $this->pm = new PM;
        // Params
        $Site = $this->user->Info("Site");

        $Plate = '%'.$Plate.'%';

        $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate LIKE ? AND Site = ? AND Parked_Column = 1");
        $stmt->bindParam(1, $Plate);
        $stmt->bindParam(2, $Site);
        $stmt->execute();
        $stmt2 = $this->mssql->dbc->prepare("SELECT * FROM ANPR_REX WHERE Plate LIKE ? AND Direction_Travel = 0 AND Lane_ID = 1 AND Status < 11", array(\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
        $stmt2->bindParam(1, $Plate);
        $stmt2->execute();
        $data = '';
        foreach($stmt->fetchAll() as $row) {
          $ref = '\''.$row['Uniqueref'].'\'';
          $timein = '\''.$row['Arrival'].'\'';
          $data .= '<tr>';
          $data .= '<td>'.$row['Plate'].' <span class="badge badge-primary">PM</span></td>';
          $data .= '<td>'.date("d/m/y H:i:s", strtotime($row['Arrival'])).'</td>';
          $data .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$row['Img_Patch'].'"></img></td>';
          $data .= '<td><button type="button" class="btn btn-danger" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')" data-toggle="modal" data-target="#PM_Director_Modal"><i class="fa fa-cog"></i></button></td>';
          $data .= '</tr>';
        }
        $html = '<table class="table table-dark table-hover table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Arrival</th>
                      <th scope="col">Patch</th>
                      <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>';

        foreach($stmt2->fetchAll() as $row) {
          $patch = str_replace($this->pm->Site_Info($Site, 'ANPR_Imgstr'), $this->pm->Site_Info($Site, 'ANPR_Img'), $row['Patch']);

          $ref = '\''.$row['Uniqueref'].'\'';
          $trl = '\''.$row['Notes'].'\'';
          $plate = '\''.$row['Plate'].'\'';
          $timein = '\''.$row['Capture_Date'].'\'';
          $data .= '<tr>';
          $data .= '<td>'.$row['Plate'].' <span class="badge badge-success">ANPR</span></td>';
          $data .= '<td>'.date("d/m/y H:i:s", strtotime($row['Capture_Date'])).'</td>';
          $data .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$patch.'"></img></td>';
          $data .= '<td><button type="button" class="btn btn-danger" onClick="PaymentPaneToggle('.$ref.', '.$plate.', '.$trl.', '.$timein.', 1)" data-toggle="modal" data-target="#PM_Director_Modal"><i class="fa fa-cog"></i></button></td>';
          $data .= '</tr>';
        }

        $html .= $data;
        $html .= '</tbody>
                </table>';

        echo json_encode($html);
        $this->mssql = null;
        $this->mysql = null;
        $this->user = null;
        $this->pm = null;
      } else if($_CONFIG['ANPR']['Type'] == "Rev") {
        $this->rev = new Rev;
        $this->mysql = new MySQL;
        $this->user = new User;
        $this->pm = new PM;
        // Params
        $Site = $this->user->Info("Site");

        $Plate = '%'.$Plate.'%';

        $stmt = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Plate LIKE ? AND Site = ? AND Parked_Column = 1");
        $stmt->bindParam(1, $Plate);
        $stmt->bindParam(2, $Site);
        $stmt->execute();
        $stmt2 = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE Plate LIKE ? AND LaneGroup = 1 AND LaneID = 1 AND Status < 1");
        $stmt2->bindParam(1, $Plate);
        $stmt2->execute();
        $data = '';
        foreach($stmt->fetchAll() as $row) {

          $url = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/";

          $ref = '\''.$row['Uniqueref'].'\'';
          $timein = '\''.$row['Arrival'].'\'';
          $data .= '<tr>';
          $data .= '<td>'.$row['Plate'].' <span class="badge badge-primary">PM</span></td>';
          $data .= '<td>'.date("d/m/y H:i:s", strtotime($row['Arrival'])).'</td>';
          $data .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$url.$row['Img_Patch'].'"></img></td>';
          $data .= '<td><button type="button" class="btn btn-danger" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')" data-toggle="modal" data-target="#PM_Director_Modal"><i class="fa fa-cog"></i></button></td>';
          $data .= '</tr>';
        }
        $html = '<table class="table table-dark table-hover table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Arrival</th>
                      <th scope="col">Patch</th>
                      <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>';

        foreach($stmt2->fetchAll() as $row) {
          if($row['Images'] != null OR $row['Images'] != '') {
            $images = json_decode($row['Images'], true);
            $img = $_CONFIG['ANPR']['HTTP_HOST'].':'.$_CONFIG['ANPR']['HTTP_PORT']."/".$images['Plate'];
          } else {
            $img = "";
          }
          $ref = '\''.$row['Uniqueref'].'\'';
          $plate = '\''.$row['Plate'].'\'';
          $timein = '\''.$row['CaptureTime'].'\'';
          $trl = '\''.''.'\'';
          $data .= '<tr>';
          $data .= '<td>'.$row['Plate'].' <span class="badge badge-success">ANPR</span></td>';
          $data .= '<td>'.date("d/m/y H:i:s", strtotime($row['CaptureTime'])).'</td>';
          $data .= '<td><img style="max-width: 120px; max-height: 50px;" src="'.$img.'"></img></td>';
          $data .= '<td><button type="button" class="btn btn-danger" onClick="PaymentPaneToggle('.$ref.', '.$plate.', '.$trl.', '.$timein.', 1)" data-toggle="modal" data-target="#PM_Director_Modal"><i class="fa fa-cog"></i></button></td>';
          $data .= '</tr>';
        }

        $html .= $data;
        $html .= '</tbody>
                </table>';

        echo json_encode($html);
        $this->rev = null;
        $this->mysql = null;
        $this->user = null;
        $this->pm = null;
      }
    }
    // Blacklist
    function ViewBlacklist($Type)
    {
      $this->mysql = new MySQL;
      $table = '<table class="table table-dark table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Reason</th>
                      <th scope="col">Date</th>
                      <th scope="col"><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>';
      $table_end = '</tbody></table>';
      $table_1 = '';
      $table_2 = '';
      if($Type == 1) {
        // Alert Security
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM blacklists WHERE Type = 1");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          foreach($stmt->fetchAll() as $row) {
            $table_1 .= '<tr>
                          <td>'.$row['Plate'].'</td>
                          <td>'.$row['Message'].'</td>
                          <td>'.$row['Added'].'</td>
                          <td><button class="btn btn-danger" onClick="Blacklist_Delete(\''.$row['Uniqueref'].'\')"><i class="fa fa-trash"></i></button></td>
                        </tr>';
          }
        }
        return $table.$table_1.$table_end;
      } else {
        // Banned from Parking
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM blacklists WHERE Type = 2");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          foreach($stmt->fetchAll() as $row) {
            $table_2 .= '<tr>
                          <td>'.$row['Plate'].'</td>
                          <td>'.$row['Message'].'</td>
                          <td>'.$row['Added'].'</td>
                          <td><button class="btn btn-danger" onClick="Blacklist_Delete(\''.$row['Uniqueref'].'\')"><i class="fa fa-trash"></i></button></td>
                        </tr>';
          }
        }
        return $table.$table_2.$table_end;
      }

      $this->mysql = null;
    }
    // Add vehicle to blacklist
    function AddToBlacklist($Plate, $Type, $Message)
    {
      $this->mysql = new MySQL;

      $Date = date("Y-m-d H:i:s");
      $Uniqueref = date("YmdHis").mt_rand(11111, 99999);

      $stmt = $this->mysql->dbc->prepare("INSERT INTO blacklists VALUES('', ?, ?, ?, ? ,? ,?, ?)");
      $stmt->bindParam(1, $Uniqueref);
      $stmt->bindValue(2, strtoupper($Plate));
      $stmt->bindParam(3, $Message);
      $stmt->bindValue(4, $Date);
      $stmt->bindValue(5, $_SESSION['id']);
      $stmt->bindParam(6, $Type);
      $stmt->bindParam(7, $Date);
      if($stmt->execute()) {
        echo json_encode(array('Status' => '1', 'Message' => 'Successfully updated the blacklist.'));
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Can\'t update the blacklist.'));
      }
    }
    // Set Blacklist to remind later
    function RemindMeBlacklist($Ref)
    {
      $this->mysql = new MySQL;

      $Date = date("Y-m-d H:i:s", strtotime('+ 20 minutes'));

      $stmt = $this->mysql->dbc->prepare("UPDATE blacklists SET Reminder = ? WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Date);
      $stmt->bindParam(2, $Ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        echo json_encode(array('Status' => '1', 'Message' => 'Reminder set.'));
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Reminder cound not be set.'));
      }

      $this->mysql = null;
    }
    function Blacklist_Delete($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("DELETE FROM blacklists WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        echo json_encode(array('Status' => '1', 'Message' => 'Deleted blacklist entry.'));
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Couldn\'t delete blacklist entry.'));
      }

      $this->mysql = null;
    }

    // Is a portal booking
    function CheckPortal($Plate)
    {
      $this->external = new External;

      $Result = $this->external->Check_On_Portal($Plate);

      if($Result['Status'] > 0) {
        echo '<div class="alert alert-danger">This vehicle has prebooked using the Roadking Portal. Please ensure it is charged the correct <b>premium</b> fee.</div>';
      } else {
        // nothing
      }

      $this->external = null;
    }
    //
    function GetExpired()
    {
      $this->rev = new Rev;
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;

      $Site = $this->user->Info("Site");
      $Time = date("Y-m-d H:i:s", strtotime("+2 hours"));

      // Get REV expired
      $stmt = $this->rev->dbc->prepare("SELECT * FROM rev_plates WHERE LaneID = 1 AND Status < 1 ORDER BY CaptureTime DESC");
      $stmt->execute();

      // Get PM
      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM parking_records WHERE Parked_Column = 1 AND Site = ? ORDER BY Expiry DESC");
      $stmt2->bindParam(1, $Site);
      $stmt2->execute();

      $html = '<table class="table table-bordered table-hover table-dark">
                <thead>
                  <tr>
                    <td>Plate</td>
                    <td>Time Over (hours)</td>
                  </tr>
                </thead>
                <tbody>';

      foreach($stmt->fetchAll() as $row)
      {
        $hour = $this->pm->Hour($row['CaptureTime'], "");
        if($hour >= 2)
        {
          if($hour > 3) {
            $html .= '<tr class="table-danger">
                        <td>'.$row['Plate'].'</td>
                        <td>'.$hour.'</td>
                      </tr>';
          } else {
            $html .= '<tr class="table-warning">
                        <td>'.$row['Plate'].'</td>
                        <td>'.$hour.'</td>
                      </tr>';
          }
        }
      }

      foreach($stmt2->fetchAll() as $row)
      {
        $hour = $this->pm->Hour($row['Expiry'], "");
        if($Time >= $row['Expiry']) {
          if($hour >= 2) {
            if($hour > 3) {
              $html .= '<tr class="table-danger">
                          <td>'.$row['Plate'].'</td>
                          <td>'.$hour.'</td>
                        </tr>';
            } else {
              $html .= '<tr class="table-warning">
                          <td>'.$row['Plate'].'</td>
                          <td>'.$hour.'</td>
                        </tr>';
            }
          }
        }
      }


      $html .= '</tbody></table>';



      return $html;

      $this->rev = null;
      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
  }

?>
