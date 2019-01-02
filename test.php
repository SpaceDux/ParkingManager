<?php
  require("global.php");

  //$etp->Proccess_Transaction_SNAP("4706", "MC14MCC", "McCulla");
  //$etp->SNAP_ListServices();


  //MORGAN FUEL CARD
  //;7082840246402155=190630001000010710?

  $str = ";7082840246402155=190630001000010710?";


  $cardno = $etp->Fuel_String_Prepare($str, ";", "=");

  $expiry_yr = $etp->Fuel_String_Prepare($str, "=", "?");
  $expiry_yr = substr($expiry_yr, "0", "2");
  $expiry_m = $etp->Fuel_String_Prepare($str, "=", "?");
  $expiry_m = substr($expiry_m, "2", "2");

  echo $cardno."<br>";
  echo $expiry_m."/20".$expiry_yr;

  //$background->Automation_Exit();

 ?>
