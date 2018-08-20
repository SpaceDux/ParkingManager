<?php
  namespace ParkingManager;

  class User implements iUser
  {
    #Variables
    private $dbc;
    private $PM;

    //Initiating Class'
    function __construct() {
      $this->dbc = new MySQL;
      $this->PM = new PM;
    }

    //Login Authentication
    function Login($email, $pass) {
      if (!empty(strip_tags($email)) && !empty(strip_tags($pass))) {
        $query = $this->dbc->dbc->prepare("SELECT * FROM pm_users WHERE email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        if($query->rowCount() > 0) {
          $result = $query->fetch(\PDO::FETCH_ASSOC);
          if(password_verify($pass, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            $set = $this->dbc->dbc->prepare("UPDATE pm_users SET active = 1, last_log = ? WHERE id = ?");
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
        $this->dbc->dbc = null;
      }
    }
    //Register User

    //Logout User, kill session
    function Logout() {
      if(isset($_SESSION['id'])) {
        $query = $this->dbc->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        session_destroy();
        $this->dbc->dbc = null;
        header('Location: index');
      } else {
        header('Location: index');
      }
    }
    //Check user hasn't been forced to logout, and do as needed
    function forceLogout() {
      if(isset($_SESSION['id'])) {
        $query = $this->dbc->dbc->prepare("SELECT active FROM pm_users WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if ($result['active'] < 1) {
          session_destroy();
          $this->dbc->dbc = null;
          header('Location: index');
        }
      }
    }
    //Get User Details
    function userInfo($key) {
      if(!empty($key)) {
        if(isset($_SESSION['id'])) {
          $query = $this->dbc->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
          $query->bindParam(1, $_SESSION['id']);
          if($query->execute()) {
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result[$key];
          }
          $this->dbc->dbc = null;
        }
      }
    }

  }
?>
