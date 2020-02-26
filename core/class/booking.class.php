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

      // From booking records that have checked out
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status = 2");
      $stmt->execute();
      foreach($stmt->fetchAll() as $bookings) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = '0', Last_Updated = ?, Author = '' WHERE id = ?");
        $stmt->bindParam(1, $Date);
        $stmt->bindValue(2, $bookings['Bay']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = '3', Last_Updated = ? WHERE Uniqueref = ?");
          $stmt->bindParam(1, $Date);
          $stmt->bindValue(2, $bookings['Uniqueref']);
          $stmt->execute();
        }
      }

      // IF STATUS = 1 AND EXPIRY < CUR TIME

      $Date = date("Y-m-d H:i:s");

      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Status = 1");
      $stmt2->execute();
      foreach($stmt2->fetchAll() as $row) {
        if($Date > $row['Expiry']) {
          $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Author = '', Expiry = '', Status = 0, Last_Updated = ? WHERE id = ?");
          $stmt->bindParam(1, $Date);
          $stmt->bindValue(2, $row['id']);
          $stmt->execute();
        }
      }


      $this->mysql = null;
    }
    // Allocate Bay Temporarily (MAX 5 min)
    function Booking_AllocateBayTemp($Site)
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $Expiry = date("Y-m-d H:i:s", strtotime('+ 5 minutes'));
      $Date = date("Y-m-d H:i:s");

      $MaxSpace = $this->user->User_Info("MaxSpaces");

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Author = ? AND Status < 2");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        echo json_encode(array('Result' => 1, 'Message' => 'Success, we have allocated you a space. <br><br>You must complete your booking before <b>'.date("H:i:s", strtotime($result['Expiry'])).'</b> to guarantee your space.'));
      } else {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status < 2 AND Author = ?");
        $stmt->bindValue(1, $_SESSION['ID']);
        $stmt->execute();
        if($stmt->rowCount() < $MaxSpace) {
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
              echo json_encode(array('Result' => 0, 'Message' => 'Sorry, there are currently no spaces available, please check back in a few minutes.'));
            }
          } else {
            echo json_encode(array('Result' => 0, 'Message' => 'Sorry, there are currently no spaces available, please check back in a few minutes.'));
          }
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'Sorry, you\'ve hit your allowed limit of '.$MaxSpace.' spaces.'));
        }
      }



      $this->mysql = null;
      $this->user = null;
    }
    // Create a booking
    function Booking_Create_Booking($Vehicle, $Type, $ETA, $Break)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->vehicles = new Vehicles;

      $MaxSpace = $this->user->User_Info("MaxSpaces");

      $Ref = mt_rand(1111, 9999).date("YmdHis").mt_rand(1111, 9999);
      $Date = date("Y-m-d H:i:s");
      $ETA = date("Y-m-d H:i:s", strtotime($ETA));
      if($Break == "1") {
        $ETD = date("Y-m-d H:i:s", strtotime($ETA.' + 12 hours'));
      } else if($Break == "2") {
        $ETD = date("Y-m-d H:i:s", strtotime($ETA.' + 24 hours'));
      } else {
        $ETD = date("Y-m-d H:i:s", strtotime($ETA.' + 48 hours'));
      }

      if(!empty($Vehicle) AND !empty($Type) AND !empty($ETA) AND !empty($Break)) {
        $Plate = $this->vehicles->Vehicles_Info($Vehicle, "Plate");

        $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Author = ?");
        $stmt->bindValue(1, $_SESSION['ID']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $bay = $stmt->fetch(\PDO::FETCH_ASSOC);
          $stmt  = $this->mysql->dbc->prepare("SELECT id FROM bookings WHERE Author = ? AND Status < 2");
          $stmt->bindValue(1, $_SESSION['ID']);
          $stmt->execute();
          if($stmt->rowCount() < $MaxSpace) {
            $bay = $stmt->fetch(\PDO::FETCH_ASSOC);
            $stmt  = $this->mysql->dbc->prepare("SELECT id FROM bookings WHERE Plate = ? AND Status < 2");
            $stmt->bindValue(1, $Plate);
            $stmt->execute();
            if($stmt->rowCount() < 1) {
              // Begin Booking
              // Add Booking
              $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Author = ? AND Status = 1");
              $stmt->bindValue(1, $_SESSION['ID']);
              $stmt->execute();
              if($stmt->rowCount() > 0) {
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                $Site = $result['Site'];
                $Bay = $result['id'];
                // Insert Booking
                $stmt = $this->mysql->dbc->prepare("INSERT INTO bookings VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0')");
                $stmt->bindParam(1, $Ref);
                $stmt->bindParam(2, $Site);
                $stmt->bindParam(3, $Plate);
                $stmt->bindParam(4, $Type);
                $stmt->bindParam(5, $Date);
                $stmt->bindParam(6, $ETA);
                $stmt->bindParam(7, $ETD);
                $stmt->bindParam(8, $Bay);
                $stmt->bindValue(9, $_SESSION['ID']);
                $stmt->bindParam(10, $Date);
                if($stmt->execute()) {
                  $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = 2, Expiry = ?, Last_Updated = ? WHERE id = ?");
                  $stmt->bindParam(1, $ETD);
                  $stmt->bindParam(2, $Date);
                  $stmt->bindParam(3, $Bay);
                  if($stmt->execute()) {
                    echo json_encode(array('Result' => 1, 'Message' => 'That\'s been confirmed for you '.$this->user->User_Info("FirstName").'. <br><br>An email confirmation has been sent to<b> '.$this->user->User_Info("EmailAddress").'</b>. Thank you for booking through the Roadking Portal.'));
                  } else {
                    echo json_encode(array('Result' => 0, 'Message' => 'Sorry, we couldn\'t finalise that booking. Please try again'));
                  }
                } else {
                  echo json_encode(array('Result' => 0, 'Message' => 'Sorry, we couldn\'t finalise that booking. Please try again'));
                }
              } else {
                echo json_encode(array('Result' => 0, 'Message' => 'It appears that you have lost your allocation due to expiry. Please cancel and try again.'));
              }
            } else {
              echo json_encode(array('Result' => 0, 'Message' => 'That vehicle has already been pre-booked.'));
            }
          } else {
            echo json_encode(array('Result' => 0, 'Message' => 'Sorry, it appears you have reached your space allowance.'));
          }
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'It appears that your bay has been unallocated from your account due to expiry. Please start again.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all fields are supplied.'));
      }

      $this->mysql = null;
      $this->user = null;
      $this->vehicles = null;
    }
  }
?>
