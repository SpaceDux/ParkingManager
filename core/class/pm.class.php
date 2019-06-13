<?php
  namespace ParkingManager;
  class PM
  {
    // VARS
    protected $mysql;

    // Get notifications
    function GET_Notifications() {
      $this->mysql = new MySQL;
      $this->user = new User;

      $campus = $this->user->Info("campus");

      $html = "";

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_notifications WHERE notification_site = ? ORDER BY notification_created DESC LIMIT 25");
      $stmt->bindParam(1, $campus);
      $stmt->execute();

      foreach($stmt->fetchAll() as $row) {
        if($row['notification_urgency'] == 0) {
          $urg = "alert-success";
        } else if($row['notification_urgency'] == 1) {
          $urg = "alert-warning";
        } else if($row['notification_urgency'] == 2) {
          $urg = "alert-danger";
        }

        $html .= '<div class="alert '.$urg.'" role="alert">
                    <p>'.$row['notification_text'].'</p>
                    <hr>
                    <p class="mb-0" style="text-align: right;"><i class="fa fa-clock"></i> '.date("H:i:s", strtotime($row['notification_created'])).'</p>
                  </div>';
      }

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
    // GET site information
    function Site_Info($site, $key) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_sites WHERE id = ?");
      $stmt->bindParam(1, $site);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];

      $this->mysql = null;
      $this->user = null;
    }
    // Hour Calculations ONLY returns hour
    function Hour($time1, $time2) {
      if(isset($time1)) {
        $d1 = new \DateTime($time1);
        $d2 = new \DateTime($time2);
        $int = $d2->diff($d1);
        $h = $int->h;
        $h = $h + ($int->days*24);
        return $h;
      } else {
        echo "ERROR!";
      }
    }
    // Vehicle Types list
    function Vehicle_Types_DropdownOpt() {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_vehicle_types ORDER BY id ASC");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $html = "";
      foreach($result as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
    // 
  }
?>
