<?php
  namespace ParkingManager;

  class PM
  {
    protected $mysql;

    // List Sites (AS HTML Select's)
    function PM_ListSitesAsSelect()
    {
      $this->mysql = new MySQL;

      $html = '';

      $stmt = $this->mysql->dbc->prepare("SELECT id, SiteName FROM settings WHERE Status = 0");
      $stmt->execute();
      foreach($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['SiteName'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }

    function PM_SiteInfo($Site, $What)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM settings WHERE id = ?");
      $stmt->bindParam(1, $Site);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result[$What];
      } else {
        return "Unable to find";
      }

      $this->mysql = null;
    }

    // Authenticate user via api
    function PM_SiteAuthenticate_API($User, $Pass)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM settings WHERE API_User = ? AND Status = 0 LIMIT 1");
      $stmt->bindParam(1, $User);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($result['API_Password'] === $Pass) {
          return array("Status" => 1, "Message" => 'Successfully authenticated.', 'Site_ID' => $result['id']);
        } else {
          return array("Status" => 0, "Message" => 'That password does not match our record.');
        }
      } else {
        return array("Status" => 0, "Message" => 'Cant find that user?');
      }

      $this->mysql = null;
    }

    // API
    // List all bays to that site. (API)
    function PM_GetAllBaysBySite_API($User, $Pass)
    {
      $this->mysql = new MySQL;

      $Auth = $this->PM_SiteAuthenticate_API($User, $Pass);
      if($Auth['Status'] == 1) {
        $Site = $Auth['Site_ID'];
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Site = ? ORDER BY id ASC");
        $stmt->bindParam(1, $Site);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $ReturnData = [];
          foreach($stmt->fetchAll() as $row) {
            $data = [];
            $data['BayID'] = $row['id'];
            $data['BayName'] = $row['Number'];
            $data['Last_Updated'] = $row['Last_Updated'];
            $data['Status'] = $row['Status'];
            $data['Temp'] = $row['Temp'];
            array_push($ReturnData, $data);
          }
          echo json_encode(array('Status' => '1', 'Message' => 'Successfully found bays for your site.', 'Data' => $ReturnData));
        } else {
          echo json_encode(array('Status' => '0', 'Message' => 'No bays available.'));
        }
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Unable to authenticate API access.'));
      }
      $stmt = $this->mysql->dbc->prepare("");

      $this->mysql = null;
    }

    // Add a new bay to the portal.
    function PM_AddNewBayToSite_API($User, $Pass, $BayNameOrNumber, $Temp, $Status)
    {
      $this->mysql = new MySQL;

      // Ensure they don't auto set it to allocated/temp allocated.
      if($Status == 1 OR $Status == 2) {
        $Status = 0;
      }

      $Auth = $this->PM_SiteAuthenticate_API($User, $Pass);
      if($Auth['Status'] == 1) {
        $Site = $Auth['Site_ID'];
        $Time = date("Y-m-d H:i:s");
        $stmt = $this->mysql->dbc->prepare("INSERT INTO bays (Site, Number, Expiry, Author, Temp, Last_Updated, Status) VALUES (?, ?, ?, '', ?, ?, ?)");
        $stmt->bindParam(1, $Site);
        $stmt->bindParam(2, $BayNameOrNumber);
        $stmt->bindParam(3, $Time);
        $stmt->bindParam(4, $Temp);
        $stmt->bindParam(5, $Time);
        $stmt->bindParam(6, $Status);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          echo json_encode(array('Status' => '1', 'Message' => 'Successfully added bay to the portal.'));
        } else {
          echo json_encode(array('Status' => '1', 'Message' => 'Could not add bay to the portal.'));
        }
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Unable to authenticate API access.'));
      }

      $this->mysql = null;
    }

    // Update bay via API
    function PM_UpdateBay_API($User, $Pass, $Bay, $Name = '', $Temp = '', $Status = '')
    {
    $this->mysql = new MySQL;

    $Auth = $this->PM_SiteAuthenticate_API($User, $Pass);
    if($Auth['Status'] == 1) {
      $Time = date("Y-m-d H:i:s");
      if($Name != '' OR $Name != null) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Number = ?, Last_Updated = ? WHERE id = ?");
        $stmt->bindParam(1, $Name);
        $stmt->bindParam(2, $Time);
        $stmt->bindParam(3, $Bay);
        $stmt->execute();
      }
      if($Temp != '' OR $Temp != null) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Temp = ?, Last_Updated = ? WHERE id = ?");
        $stmt->bindParam(1, $Temp);
        $stmt->bindParam(2, $Time);
        $stmt->bindParam(3, $Bay);
        $stmt->execute();
      }
      if($Status != '' OR $Status != null) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = ?, Last_Updated = ? WHERE id = ?");
        $stmt->bindParam(1, $Status);
        $stmt->bindParam(2, $Time);
        $stmt->bindParam(3, $Bay);
        $stmt->execute();
      }
      echo json_encode(array('Status' => '1', 'Message' => 'Successfully updated bay on the portal.'));
      } else {
        echo json_encode(array('Status' => '0', 'Message' => 'Unable to authenticate API access.'));
      }


      $this->mysql = null;
    }
  }

?>
