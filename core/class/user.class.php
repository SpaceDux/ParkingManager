<?php
  namespace ParkingManager;

  class User
  {
    protected $mysql;

    // Register User to Portal
    function User_Registration($First, $Last, $Email, $Password, $ConPassword, $Tel)
    {
      $this->mysql = new MySQL;
      $this->mailer = new Mailer;

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
                  $Mail = $this->mailer->SendActivation($Email);
                  if($Mail == 1) {
                    echo json_encode(array('Result' => 1, 'Message' => 'Success, check your email for an activation link.'));
                  } else {
                    echo json_encode(array('Result' => 0, 'Message' => 'Something went wrong. Confirmation email could not be sent.'));
                  }
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
      $this->mailer = null;
    }
    // Activate Registered user following email confirm
    function User_Activate($Who)
    {
      $this->mysql = new MySQL;

      $Who = htmlspecialchars($Who);

      if(!empty($Who)) {
        $stmt = $this->mysql->dbc->prepare("UPDATE users SET Activated = 1 WHERE EmailAddress = ?");
        $stmt->bindParam(1, $Who);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          header("Location: index");
        } else {
          echo "That did not work";
        }
      } else {
        echo "No user was supplied";
      }

      $this->mysql = null;
    }
    // run checks, login user, set session
    function User_Login($Email, $Password)
    {
      $this->mysql = new MySQL;
      $this->mailer = new Mailer;

      $IPAddress = $_SERVER['REMOTE_ADDR'];

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM bans WHERE IPAddress = ? AND Status < 1");
      $stmt->bindParam(1, $IPAddress);
      $stmt->execute();
      if($stmt->rowCount() < 1) {
        // Isn't IP Banned; Begin checks
        if(!empty($Email) AND !empty($Password)) {
          $stmt = $this->mysql->dbc->prepare("SELECT * FROM users WHERE EmailAddress = ?");
          $stmt->bindParam(1, $Email);
          $stmt->execute();
          if($stmt->rowCount() > 0) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($result['Activated'] > 0) {
              if($result['Status'] == 0) {
                //Activated & hasnt been banned, begin login.
                if(password_verify($Password, $result['Password']) == TRUE) {
                  $Date = date("Y-m-d H:i:s");
                  $stmt = $this->mysql->dbc->prepare("UPDATE users SET LoggedIn = 1, Last_Updated = ?, Last_IP = ? WHERE EmailAddress = ?");
                  $stmt->bindParam(1, $Date);
                  $stmt->bindParam(2, $IPAddress);
                  $stmt->bindParam(3, $Email);
                  if($stmt->execute()) {
                    $_SESSION['ID'] = $result['Uniqueref'];
                    echo json_encode(array('Result' => 1, 'Message' => 'Successfully logged in, you\'ll be redirected in <b>3 seconds</b>...'));
                  } else {
                    echo json_encode(array('Result' => 0, 'Message' => 'Unable to login, please try again.'));
                  }
                } else {
                  echo json_encode(array('Result' => 0, 'Message' => 'Your password doesn\'t match our records.'));
                }
              } else if($result['Status'] == 1) {
                echo json_encode(array('Result' => 0, 'Message' => 'Your account has been suspended.'));
              } else if($result['Status'] == 2) {
                echo json_encode(array('Result' => 0, 'Message' => 'Your account has been banned.'));
              }
            } else {
              $resend = $this->mailer->SendActivation($Email);
              if($resend == 1) {
                echo json_encode(array('Result' => 0, 'Message' => 'Your account has not been activated. We have resent the activation email.'));
              } else {
                echo json_encode(array('Result' => 0, 'Message' => 'Your account has not been activated. Check your emails.'));
              }
            }
          } else {
            echo json_encode(array('Result' => 0, 'Message' => 'Sorry, we can\'t find an account associated with that email address.'));
          }
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all details are supplied and try again.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'You have been blocked from this service.'));
      }

      $this->mysql = null;
      $this->mailer = null;
    }
    // Logout & kill session
    function User_Logout()
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE users SET LoggedIn = '0' WHERE Uniqueref = ?");
      $stmt->bindValue(1, $_SESSION['ID']);
      if($stmt->execute()) {
        session_destroy();
        header('Location: index');
      } else {
        session_destroy();
      }

      $this->mysql = null;
    }
    // User information (For tpl etc)
    function User_Info($What)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM users WHERE Uniqueref = ?");
      $stmt->bindParam(1, $_SESSION['ID']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result[$What];
      } else {
        return "No Result";
      }


      $this->mysql = null;
    }
    // Update User Account information
    function User_UpdateInfo_Update($First, $Last, $Email, $Telephone)
    {
      $this->mysql = new MySQL;
      

      $this->mysql = null;
    }
  }

?>
