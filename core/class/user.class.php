<?php
  namespace ParkingManager;

  class User
  {
    #Variables
    protected $mysql;
    private $PM;

    //Login Authentication
    function Login($email, $pass) {
      $this->mysql = new MySQL;
      $this->PM = new PM;
      if (!empty(strip_tags($email)) && !empty(strip_tags($pass))) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        if($query->rowCount() > 0) {
          $result = $query->fetch(\PDO::FETCH_ASSOC);
          if(password_verify($pass, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            $set = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 1, last_log = ? WHERE id = ?");
            $set->bindParam(1, date("Y-m-d H:i:s"));
            $set->bindParam(2, $_SESSION['id']);
            $set->execute();
            header('Location: main');
            die($_SESSION['id']);
          } else {
            $this->PM->err = 'your password does not match up with our records, please try again';
            return $this->PM->ErrorHandler();
          }
        } else {
          $this->PM->err = 'we can\'t seem to find that account in our records, please try again';
          return $this->PM->ErrorHandler();
        }
        $this->mysql = null;
        $this->PM = null;
      }
    }
    //Register User

    //Logout User, kill session
    function Logout() {
      $this->mysql = new MySQL;
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        session_destroy();
        $this->mysql = null;
        header('Location: index');
      } else {
        header('Location: index');
      }
    }
    //Check user hasn't been forced to logout, and do as needed
    function forceLogout() {
      $this->mysql = new MySQL;
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("SELECT active FROM pm_users WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        $this->mysql = null;
        if ($result['active'] < 1) {
          session_destroy();
          header('Location: index');
        }
      }
    }
    function isLogged() {
      if(isset($_SESSION['id'])) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    //Get User Details
    function userInfo($key) {
      $this->mysql = new MySQL;
      if(!empty($key)) {
        if(isset($_SESSION['id'])) {
          $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
          $query->bindParam(1, $_SESSION['id']);
          if($query->execute()) {
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result[$key];
          }
        }
      }
      $this->mysql = null;
    }

  }
?>
