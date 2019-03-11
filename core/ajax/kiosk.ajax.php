<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Kiosk_ParkingPage") {
    //Return the parking page with relevant information
    $kiosk->GetParkingPage();
  }

?>
