<?php
  require("global.php");

  //$etp->Proccess_Transaction_SNAP("4706", "MC14MCC", "McCulla");
  //$etp->SNAP_ListServices();


  $cardno = substr(";7077188573285001476=20031003836710581? ", "1", "19");
  $expiry_yr = substr(";7077188573285001476=20031003836710581? ", "21", "2");
  $expiry_m = substr(";7077188573285001476=20031003836710581? ", "23", "2");

  echo $cardno."<br>";
  echo $expiry_m."/20".$expiry_yr;

 ?>
