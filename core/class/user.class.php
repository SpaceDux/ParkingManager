<?php
  namespace ParkingManager;

  class User
  {
    protected $mysql;

    function User_Registration($First, $Last, $Email, $Password, $ConPassword, $Tel)
    {
      $this->mysql = new MySQL;

      $IPAddress = $_SERVER['REMOTE_ADDR'];
      // Ensure all data is present
      if(!empty($First) AND !empty($Last) AND !empty($Email) AND !empty($Password) AND !empty($ConPassword) AND !empty($Tel)) {
        // Begin Data Checks.
        $check = $this->mysql->dbc->prepare("SELECT * FROM users WHERE EmailAddress = ?");
        $check->bindParam(1, $Email);
        $check->execute();
        if($check->rowCount() < 1) {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM bans WHERE IPAddress = ? AND Status > 0");
          $stmt->bindParam(1, $IPAddress);
          $stmt->execute();
          if($stmt->rowCount() < 1) {
            $stmt = $this->mysql->dbc->prepare("SELECT * FROM users WHERE Registered_IP = ? OR Last_IP = ?");
            $stmt->bindParam(1, $IPAddress);
            $stmt->bindParam(2, $IPAddress);
            $stmt->execute();
            if($stmt->rowCount() < 2) {
              if($Password == $ConPassword) {
                $Uniqueref = mt_rand(111, 999).date("YmdHis").mt_rand(1111,9999);
                $Date = date("Y-m-d H:i:s");
                // NOW REG ACCOUNT
                $stmt = $this->mysql->dbc->prepare("INSERT INTO users VALUES ('', ?, ?, ?, ?, ?, ?, '', '', '1', '3', '0', ?, ?, ?, ?, '0', '0')");
                $stmt->bindParam(1, $Uniqueref);
                $stmt->bindParam(2, $First);
                $stmt->bindParam(3, $Last);
                $stmt->bindParam(4, $Email);
                $stmt->bindParam(5, $Tel);
                $stmt->bindValue(6, password_hash($Password, PASSWORD_BCRYPT));
                $stmt->bindParam(7, $Date);
                $stmt->bindParam(8, $Date);
                $stmt->bindParam(9, $IPAddress);
                $stmt->bindParam(10, $IPAddress);
                if($stmt->execute()) {
                  echo json_encode(array('Result' => 1, 'Message' => 'Success, check your email for an activation link.'));
                } else {
                  echo json_encode(array('Result' => 0, 'Message' => 'Something went wrong, please try again.'));
                  }
              } else {
                echo json_encode(array('Result' => 0, 'Message' => 'Your passwords do not match, please try again.'));
              }
            } else {
              echo json_encode(array('Result' => 0, 'Message' => 'You have exceded maximum account limit assigned to your IP.'));
            }
          } else {
            echo json_encode(array('Result' => 0, 'Message' => 'Sorry, were unable to process your request.'));
          }
        } else {
          $stmt = $this->mysql->dbc->prepare("UPDATE users SET Last_IP = ? WHERE EmailAddress = ?");
          $stmt->bindParam(1, $IPAddress);
          $stmt->bindParam(2, $Email);
          $stmt->execute();
          echo json_encode(array('Result' => 0, 'Message' => 'It appears that you already exists on our system. Please return to your login.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all details are supplied and try again.'));
      }

      $this->mysql = null;
    }
  }

?>
