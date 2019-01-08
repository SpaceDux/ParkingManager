<?php
  require("global.php");

  //$etp->Proccess_Transaction_SNAP("4706", "MC14MCC", "McCulla");
  //$etp->SNAP_ListServices();


  //MORGAN FUEL CARD
  $str = ";7082840246402155=190630001000010710?";
  // DKV RC 10
  // $str = "%A                            ^76801       ^                                7?
  //         ;70431024123404214=2102001000000000000?
  //         ;:70431024123404214=2102001000000007060800011010101010101000000000000000000000000000000000000000000000000?";
  //DKV RC 90
    // $str = "%A                            ^MANIPULATED ^                                7?
    //         ;70431024123457048=1812009000000000000?
    //         ;:70431024123457048=1812009000000023112419263122113015141000000000000000000000000000000000000000000000000?
    //         ";

  // $cardno = $etp->Fuel_String_Prepare($str, ";", "=");
  // $expiry_yr = $etp->Fuel_String_Prepare($str, "=", "?");
  // $expiry_yr = substr($expiry_yr, "0", "2");
  // $expiry_m = $etp->Fuel_String_Prepare($str, "=", "?");
  // $expiry_m = substr($expiry_m, "2", "2");
  // $rcnum = $etp->Fuel_String_Prepare($str, "=", "?");
  // $rcnum = substr($rcnum, "6", "2");
  //
  // echo $cardno."<br>";
  // echo $expiry_m."/20".$expiry_yr."<br>";
  // echo "RC: ".$rcnum;

  $etp->Proccess_Transaction_Fuel("4410", "CY15GHX", "Ryan", $str);

  //$background->Automation_Exit();

 ?>
