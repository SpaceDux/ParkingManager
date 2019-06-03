<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Vehicles.ANPR_Feed") {
    $vehicles->ANPR_Feed();
  } else if($handler == "Vehicles.PAID_Feed") {
    $vehicles->PAID_Feed();

  }

?>
