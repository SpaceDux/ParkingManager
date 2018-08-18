<?php
  namespace ParkingManager;

  interface iUser
  {
    public function Login($email, $pass);

    public function Logout();

    public function forceLogout();

    public function userInfo($what);
  }
?>
