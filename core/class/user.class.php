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
        $check = $this->mysql->dbc->prepare("SELECT * FROM users WHERE Email = ?");
        $check->bindParam(1, $Email);
        $check->execute();
        if($check->rowCount() < 1) {
          echo json_encode(array('Result' => 1, 'Message' => 'It appears that the email you\'ve supplied, already exists on our system.'));
        } else {
          echo json_encode(array('Result' => 0, 'Message' => 'It appears that the email you\'ve supplied, already exists on our system.'));
        }
      } else {
        echo json_encode(array('Result' => 0, 'Message' => 'Please ensure all details are supplied and try again.'));
      }

      $this->mysql = null;
    }
  }

?>
