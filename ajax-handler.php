<?php
  require(__DIR__."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "exit") {
    $ajax->exitVehicle($_POST['veh_id']);
  } else if($handler == "markRenewal") {
    $ajax->markRenewal($_POST['veh_id']);
  } else if($handler == "unmarkRenewal") {
    $ajax->unmarkRenewal($_POST['veh_id']);
  }
?>
