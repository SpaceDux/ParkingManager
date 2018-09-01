<?php
  require(__DIR__."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "exit") {
    $ajax->exitVehicle($_POST['veh_id']);
  } else if($handler == "markRenewal") {
    $ajax->markRenewal($_POST['veh_id']);
  } else if($handler == "setFlag") {
    $ajax->setFlag($_POST['veh_id']);
  } else if($handler == "searchDb_vehLogs") {
    $ajax->searchDb_veh_logs($_POST['query']);
  } else if($handler == "deleteVehicle") {
    $ajax->deleteVehicle($_POST['veh_id']);
  } else if($handler == "deleteNotice") {
    $ajax->deleteNotice($_POST['notice_id']);
  }
?>
