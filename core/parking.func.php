<?php
  require(__DIR__.'/manage/config.php');
  $site = $url."/update/";

  class Parking {
    //Fetch Breaks
    function fetchBreak() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '1' ORDER BY timein DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Paid
    function fetchPaid() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '2' AND h_light != '1' ORDER BY timein ASC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Renewals
    function fetchRenewals() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE h_light = '1' AND col < 3 ORDER BY timein DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Exits
    function fetchExits() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col = '3' ORDER BY timeout DESC LIMIT 40";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Yard (YRD CHK)
    function fetchYard() {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE col < 3";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Fetch Payments
    function fetchPayments($row_id) {
      global $dbConn;
      $sql = "SELECT * FROM payments WHERE veh_id = ? ORDER BY id DESC LIMIT 1";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $row_id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //Fetch All Payments
    function getPayments($row_id) {
      global $dbConn;
      $sql = "SELECT * FROM payments WHERE veh_id = ? ORDER BY service_date DESC";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $row_id);
      $stmt->execute();

      return $stmt->fetchAll();
    }
    //Get Details
    function fetchVehicle($veh_id) {
      global $dbConn;
      $sql = "SELECT * FROM parking WHERE id = ?";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $veh_id);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function updateVehicle($id) {
      global $dbConn;
        if(isset($_POST['upd_reg'])) {
          $company = strtoupper($_POST['upd_company']);
          $reg = strtoupper($_POST['upd_reg']);
          $trlno = strtoupper($_POST['upd_trl']);
          $comment = htmlspecialchars($_POST['upd_comment']);


          $sql = "UPDATE parking SET company = ?, reg = ?, trlno = ?, type = ?, timein = ?, col = ?, timeout = ?, comment = ? WHERE id = ?";
          $stmt = $dbConn->prepare($sql);
          $stmt->bindParam(1, $company);
          $stmt->bindParam(2, $reg); //sort
          $stmt->bindParam(3, $trlno);//sort
          $stmt->bindParam(4, $_POST['upd_type']); //sort
          $stmt->bindParam(5, $_POST['upd_timein']);
          $stmt->bindParam(6, $_POST['upd_col']);
          $stmt->bindParam(7, $_POST['upd_timeout']);
          $stmt->bindParam(8, $comment);
          $stmt->bindParam(9, $id);
          if($stmt->execute()) {
            header('Location:'.$site.$id.'');
          } else {
            //nothing
          }
        }
    }
    function updateTimeCalc($time1, $time2) {
      try {
        if(isset($time1)) {
          $d1 = new DateTime($time1);
          $d2 = new DateTime($time2);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);
          echo "Parked for <b>".$h."</b> hours and <b>".$int->format('%i')."</b> minutes";
        }
      } catch(Exception $e) {
        echo "<red>Time Construction error, please correct</red>";
      }
    }
    function graphDisplay($key, $key2) {
      global $dbConn;
      $sql = "SELECT * FROM payments WHERE service_date BETWEEN ? AND ?";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $key);
      $stmt->bindParam(2, $key2);
      $stmt->execute();
      return $stmt->rowCount();
    }
  }
?>
