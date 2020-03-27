<?php
  namespace ParkingManager;
  class Booking
  {
    protected $mysql;

    function __construct()
    {
      $this->Booking_RestoreBookedBays();
    }
    // TO BE USED VIA CONSTRUCT, Restore Bays
    function Booking_RestoreBookedBays()
    {
      $this->mysql = new MySQL;
      $this->mail = new Mailer;

      $Date = date("Y-m-d H:i:s");

      // From booking records that have checked out
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status = 3");
      $stmt->execute();
      foreach($stmt->fetchAll() as $bookings) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = '0', Last_Updated = ?, Author = '' WHERE id = ?");
        $stmt->bindParam(1, $Date);
        $stmt->bindValue(2, $bookings['Bay']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = '4', Last_Updated = ? WHERE Uniqueref = ?");
          $stmt->bindParam(1, $Date);
          $stmt->bindValue(2, $bookings['Uniqueref']);
          $stmt->execute();
        }
      }

      // If has been cancelled.
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status = 5");
      $stmt->execute();
      foreach($stmt->fetchAll() as $bookings) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Status = '0', Last_Updated = ?, Author = '' WHERE id = ?");
        $stmt->bindParam(1, $Date);
        $stmt->bindValue(2, $bookings['Bay']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = '6', Last_Updated = ? WHERE Uniqueref = ?");
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

      // Booking Expiry
      $Expiry = date("Y-m-d H:i:s", strtotime($Date.' -30 minutes'));
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status < 1");
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        foreach($stmt->fetchAll() as $row) {
          if($Expiry > $row['ETA']) {
            $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = '5' WHERE id = ?");
            $stmt->bindParam(1, $row['id']);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
              // SEND LATE CANCEL EMAIL
              $stmt = $this->mysql->dbc->prepare("UPDATE users SET Strikes = Strikes + 1, Last_Updated = ? WHERE Uniqueref = ?");
              $stmt->bindParam(1, $Date);
              $stmt->bindValue(2, $row['Author']);
              $stmt->execute();
            }
          }
        }
      }


      $this->mysql = null;
      $this->mail = null;
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
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status < 3 AND Author = ?");
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
          echo json_encode(array('Result' => 0, 'Message' => 'Sorry, you\'ve hit your allowed limit of '.$MaxSpace.' spaces per day.'));
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
    // View bookings as html
    function Booking_ListAllBookingsAsHtml()
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;

      $html = '';
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status < 2 AND Author = ?");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        foreach($stmt->fetchAll() as $row) {
          if($row['Status'] == 0) {
            $Status = 'Not Checked In';
          } else if($row['Status'] == 1) {
            $Status = 'Arrived';
          } else if($row['Status'] == 2) {
            $Status = 'Checked In.';
          } else if($row['Status'] == 3) {
            $Status = 'Checked Out';
          } else if($row['Status'] == 4) {
            $Status = 'Checked out, Thank\'s for staying with us.';
          } else if($row['Status'] == 5) {
            $Status = 'Cancelled.';
          } else if($row['Status'] == 6) {
            $Status = 'Cancelled.';
          }
          $Ref = '\''.$row['Uniqueref'].'\'';
          $html .=  '
                    <div class="col-md-4">
                      <div class="card" style="width: 100%;">
                        <div class="card-body">
                          <h5 class="card-title">'.$row['Plate'].'</h5>
                          <p class="card-text">Thanks '.$this->user->User_Info("FirstName").', your booking has been confirmed.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><i class="fa fa-location-arrow"></i> '.$this->pm->PM_SiteInfo($row['Site'], "SiteName").'</li>
                          <li class="list-group-item"><i class="fa fa-clock"></i> ETA: '.date("d/m/y @ H:i", strtotime($row['ETA'])).'</li>
                          <li class="list-group-item"><i class="far fa-clock"></i> ETD: '.date("d/m/y @ H:i", strtotime($row['ETD'])).'</li>
                          <li class="list-group-item">'.$Status.'</li>
                        </ul>
                        <div class="card-body">
                          <a href="#" class="card-link" onClick="Booking_Modify('.$Ref.')">Modify Booking</a>
                          <a href="#" style="color:red;" class="card-link" onClick="Booking_Cancel('.$Ref.')">Cancel Booking</a>
                        </div>
                      </div>
                    </div>
                    ';
        }
      } else {
        $html .= '<div class="col-md-4">You have no active bookings.</div>';
      }

      return $html;

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    // View bookings as html
    function Booking_ListAllPreviousBookingsAsHtml()
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;

      $html = '';
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status >= 3 AND Author = ? ORDER BY ETA DESC LIMIT 6");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        foreach($stmt->fetchAll() as $row) {
          if($row['Status'] == 0) {
            $Status = 'Not Checked In';
          } else if($row['Status'] == 1) {
            $Status = 'Arrived';
          } else if($row['Status'] == 2) {
            $Status = 'Checked In.';
          } else if($row['Status'] == 3) {
            $Status = 'Checked Out';
          } else if($row['Status'] == 4) {
            $Status = 'Checked out, Thank\'s for staying with us.';
          } else if($row['Status'] == 5) {
            $Status = 'Cancelled.';
          } else if($row['Status'] == 6) {
            $Status = 'Cancelled.';
          }

          $Ref = '\''.$row['Uniqueref'].'\'';
          $html .=  '
                    <div class="col-md-4">
                      <div class="card" style="width: 100%;">
                        <div class="card-body">
                          <h5 class="card-title">'.$row['Plate'].'</h5>
                          <p class="card-text">Thanks '.$this->user->User_Info("FirstName").', your booking has been confirmed.</p>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><i class="fa fa-location-arrow"></i> '.$this->pm->PM_SiteInfo($row['Site'], "SiteName").'</li>
                          <li class="list-group-item"><i class="fa fa-clock"></i> ETA: '.date("d/m/y @ H:i", strtotime($row['ETA'])).'</li>
                          <li class="list-group-item"><i class="far fa-clock"></i> ETD: '.date("d/m/y @ H:i", strtotime($row['ETD'])).'</li>
                          <li class="list-group-item">'.$Status.'</li>
                        </ul>
                      </div>
                    </div>
                    ';
        }
      } else {
        $html .= '<div class="col-md-4">You have no previous bookings.</div>';
      }

      return $html;

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
    }
    // Cancel a booking, set status 4
    function Booking_CancelBooking($Ref)
    {
      $this->mysql = new MySQL;

      $Date = date("Y-m-d H:i:s");

      if(!empty($Ref)) {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Uniqueref = ? AND Status = 0");
        $stmt->bindParam(1, $Ref);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $result = $stmt->fetch(\PDO::FETCH_ASSOC);
          $ETA = date("Y-m-d H:i:s", strtotime($result['ETA'].' + 30 minutes'));
          if($ETA > $Date) {
            // Cancel, but dont strike
            $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = 5, Last_Updated = ? WHERE Uniqueref = ?");
            $stmt->bindParam(1, $Date);
            $stmt->bindParam(2, $Ref);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
              echo json_encode(array('Result' => 1, 'Message' => 'Thanks, we\'ve cancelled your booking as requested.<br><br>Sorry you couldn\'t make it, hopefully we\'ll see you soon!'));
            } else {
              echo json_encode(array('Result' => 0, 'Message' => 'Something wen\'t wrong. Please try again.'));
            }
          } else {
            // Cancel BUT strike as over eta
            $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = 5, Last_Updated = ? WHERE Uniqueref = ?");
            $stmt->bindParam(1, $Date);
            $stmt->bindParam(2, $Ref);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
              $stmt = $this->mysql->dbc->prepare("UPDATE users SET Strikes = Strikes + 1, Last_Updated = ? WHERE Uniqueref = ?");
              $stmt->bindParam(1, $Date);
              $stmt->bindValue(2, $_SESSION['ID']);
              $stmt->execute();
              if($stmt->rowCount() > 0) {
                echo json_encode(array('Result' => 1, 'Message' => 'Thanks, we\'ve cancelled your booking as requested.<br><br>Sorry you couldn\'t make it, however as you\'ve cancelled more than 30 minutes after your ETA, your account has been given 1 strike. <br>'));
              } else {
                echo json_encode(array('Result' => 0, 'Message' => 'Something wen\'t wrong. Please try again.'));
              }
            } else {
              echo json_encode(array('Result' => 0, 'Message' => 'Something wen\'t wrong. Please try again.'));
            }
          }
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'Sorry, we can\'t locate that booking on our system. Please try again.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all data is present.'));
      }

      $this->mysql = null;
    }
    // Midway cancellation
    function Booking_MidwayCancel()
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bays WHERE Author = ? AND Status < 2");
      $stmt->bindValue(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $stmt = $this->mysql->dbc->prepare("UPDATE bays SET Author = '', Expiry = '', Status = 0 WHERE Author = ? AND Status < 2");
        $stmt->bindValue(1, $_SESSION['ID']);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          echo json_encode(array('Result' => 1, 'Message' => 'Successfully cancelled that booking.'));
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'Something has gone wrong with that request.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Something wen\'t wrong'));
      }

      $this->mysql = null;
    }
    // API FUNCTIONS
    // Get All active bookings via API
    function Booking_GetAllActiveBookings_API($User, $Pass)
    {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      if(isset($User) AND isset($Pass)) {
        $Auth = $this->pm->PM_SiteAuthenticate_API($User, $Pass);
        if($Auth['Status'] == "1") {
          $Site = $Auth['Site_ID'];
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM bookings WHERE Status < 2 AND Site = ?");
          $stmt->bindParam(1, $Site);
          $stmt->execute();
          if($stmt->rowCount() > 0) {
            $data = [];
            foreach($stmt->fetchAll() as $row) {
              $dataEach = [];
              $dataEach['Uniqueref'] = $row['Uniqueref'];
              $dataEach['Plate'] = $row['Plate'];
              $dataEach['ETA'] = $row['ETA'];
              $dataEach['VehicleType'] = $row['VehicleType'];
              $dataEach['Date'] = $row['Date'];
              array_push($data, $dataEach);
            }
            echo json_encode(array("Status" => "1", "Message" => "Successfully found bookings.", "Data" => $data));
          } else {
            echo json_encode(array("Status" => "0", "Message" => "No active bookings found."));
          }
        } else {
          echo json_encode(array("Status" => "0", "Message" => $Auth['Message']));
        }
      } else {
        echo json_encode(array("Status" => "0", "Message" => "Please ensure all data is present."));
      }

      $this->mysql = null;
    }
    // Update a booking remotely
    function Booking_UpdateBooking_API($User, $Pass, $Ref, $ETA, $Status, $VehicleType)
    {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      if(isset($User) AND isset($Pass)) {
        $Auth = $this->pm->PM_SiteAuthenticate_API($User, $Pass);
          if($Auth['Status'] == "1") {
            if($ETA != null OR $ETA != '') {
              $stmt = $this->mysql->dbc->prepare("SELECT ETA FROM bookings WHERE Uniqueref = ?");
              $stmt->bindParam(1, $Ref);
              $stmt->execute();
              $result = $stmt->fetch(\PDO::FETCH_ASSOC);

              $NewETA = date("Y-m-d H:i:s", strtotime($ETA));

              $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET ETA = ? WHERE Uniqueref = ?");
              $stmt->bindParam(1, $NewETA);
              $stmt->bindParam(2, $Ref);
              $stmt->execute();
            }
            if($Status != null OR $Status != '') {
              $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET Status = ? WHERE Uniqueref = ?");
              $stmt->bindParam(1, $Status);
              $stmt->bindParam(2, $Ref);
              $stmt->execute();
            }
            if($VehicleType != null OR $VehicleType != '') {
              $stmt = $this->mysql->dbc->prepare("UPDATE bookings SET VehicleType = ? WHERE Uniqueref = ?");
              $stmt->bindParam(1, $VehicleType);
              $stmt->bindParam(2, $Ref);
              $stmt->execute();
            }
            echo json_encode(array("Status" => "1", "Message" => "Successfully found & updated booking."));
          } else {
            echo json_encode(array("Status" => "0", "Message" => "Could not authenticate."));
          }
        } else {
          echo json_encode(array("Status" => "0", "Message" => "Missing data. Please ensure all data is present."));
        }

      $this->mysql = null;
      $this->pm = null;
    }
  }
?>
