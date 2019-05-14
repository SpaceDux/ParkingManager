<?php
  namespace ParkingManager;

  class User
  {
    // Authorize user session(s)
    public function Login($email = '', $password = '')
    {
      global $_CONFIG;

      $this->mysql = new MySQL;
      if(!empty(strip_tags($email)) && !empty(strip_tags($password))) {
        $query = $this->mysql->dbc->prepare("SELECT id, email, password FROM pm_users WHERE email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        if($query->rowCount() > 0) {
          $result = $query->fetch(\PDO::FETCH_ASSOC);
          if(password_verify($password, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            $date = date("Y-m-d H:i:s");
            $set = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 1, last_log = ? WHERE id = ?");
            $set->bindParam(1, $date);
            $set->bindParam(2, $result['id']);
            $set->execute();
            $result = [
              'Code' => '0',
              'Text' => 'Successfully logged in. You will be redirected in 3 seconds...'
            ];
          } else {
            $result = [
              'Code' => '1',
              'Text' => 'Your password doesn\'t match our records, please try again.'
            ];
          }
        } else {
          $result = [
            'Code' => '2',
            'Text' => 'We can\'t seem to find an account associated with that email address, please check your information is correct.'
          ];
        }
        $this->mysql = null;
        $this->PM = null;
      } else {
        $result = [
          'Code' => '3',
          'Text' => 'Please ensure all fields are filled.'
        ];
      }
      echo json_encode($result);
    }
    // Terminate user session & return to index
    public function Logout()
    {
      $this->mysql = new MySQL;
      $id = $_SESSION['id'];
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        session_destroy();
      }
      $this->mysql = null;
    }
    // Checks if session exists
    public function LoggedIn()
    {
      if(isset($_SESSION['id'])) {
        $return = [
          "Code" => "1"
        ];
      } else {
        $return = [
          "Code" => "0"
        ];
      }
      echo json_encode($return);
    }
    // User Info
    public function Info($what)
    {
      $this->mysql = new MySQL;

      if(isset($_SESSION['id'])) {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
        $stmt->bindParam(1, $_SESSION['id']);
        if($stmt->execute()) {
          $result = $stmt->fetch();
          return $result[$what];
        } else {
          echo "ERROR";
        }
      }

      $this->mysql = null;
    }
  }

?>
