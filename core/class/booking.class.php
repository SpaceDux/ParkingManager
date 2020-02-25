<?php
  namespace ParkingManager;
  class Booking
  {
    protected $mysql;

    function __construct()
    {
      $this->Booking_RestoreBookedBays();
    }
    // TO BE USED VIA CONSTRUCT, restore bookings if time greater than expiry AND status == 2
    function Booking_RestoreBookedBays()
    {
      $this->mysql = new MySQL;

      $Date = date("Y-m-d H:i:s");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status = 2");
      $stmt->execute();
      foreach($stmt->fetchAll() as $bookings) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = '0', Last_Updated = ? WHERE id = ?");
        $stmt->bindParam(1, $Date);
        $stmt->bindValue(2, $bookings['Bay']);
        if($stmt->execute()) {
          $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = 3 AND Last_Updated = ? WHERE Uniqueref = ?");
          $stmt->bindValue(1, $bookings['Uniqueref']);
          $stmt->bindParam(2, $Date);
          $stmt->execute();
        }
      }

      $this->mysql = null;
    }
    // Allocate Bay Temporarily (MAX 5 min)
    function Booking_AllocateBayTemp($Site)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Status = 0 AND Site = ? LIMIT 1");
      $stmt->bindParam(1, $Site);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        $Expiry = date("Y-m-d H:i:s", strtotime('+ 5 minutes'));
        $Date = date("Y-m-d H:i:s");

        $upd = $this->mysql->dbc->prepare("UPDATE bays SET Status = 1, Expiry = ?, Last_Updated = ?, Author = ? WHERE id = ? AND Status = 0");
        $upd->bindParam(1, $Expiry);
        $upd->bindParam(2, $Date);
        $upd->bindValue(3, $_SESSION['ID']);
        $upd->bindValue(4, $result['id']);
        $upd->execute();
        if($upd->rowCount() > 0) {
          echo json_encode(array('Result' => 1, 'Message' => 'Success, we have allocated you a space. <br><br>You must complete your booking before <b>'.date("H:i:s", strtotime($Expiry)).'</b> to guarantee your space.'));
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'Sorry, there are currently no bays available, please check back in a few minutes.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Sorry, there are currently no bays available, please check back in a few minutes.'));
      }

      $this->mysql = null;
    }
    // Create a booking
    function Booking_Create_Booking($Plate, $Type, $ETA, $Break)
    {
      $this->mysql = new MySQL;

      $Ref = mt_rand(1111, 9999).date("YmdHis").my_rand(1111, 9999);
      $Date = date("Y-m-d H:i:s");

      if(!empty($Plate) AND !empty($Type) AND !empty($ETA) AND !empty($Break)) {

      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all fields are supplied.'));
      }

      $this->mysql = null;
    }
  }
?>
