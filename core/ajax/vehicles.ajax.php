<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "ANPR_Feed") { //Exit Vehicle from PM
    $vehicles->get_anprFeed();
  } else if($handler == "PAID_Feed") {
    $vehicles->get_paidFeed();
  } else if($handler == "RENEWAL_Feed") {
    $vehicles->get_renewalFeed();
  } else if($handler == "EXIT_Feed") {
    $vehicles->get_exitFeed();
  } else if($handler == "Vehicle_Exit") {
    $vehicles->Vehicle_Exit($_POST['veh_id']);
  } else if($handler == "Vehicle_Flag") {
    $vehicles->Vehicle_Flag($_POST['veh_id']);
  } else if($handler == "ANPR_Filter") {
    $anpr->ANPR_FilterSearch($_POST['Filter']);
  }

?>
