<?php
  namespace ParkingManager;

  interface iVehicles
  {
    public function get_anprFeed();

    public function get_paidFeed();

    public function get_renewalFeed();

    public function veh_exit($key);

  }

?>
