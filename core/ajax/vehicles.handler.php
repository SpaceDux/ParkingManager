<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Vehicles.ANPR_Feed") {
    $vehicles->ANPR_Feed();
  } else if($handler == "Vehicles.ALLVEH_Feed") {
    $vehicles->ALLVEH_Feed();
  }

?>
