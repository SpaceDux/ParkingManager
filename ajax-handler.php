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
  } else if($handler == "ANPR_Search}") {
    $ajax->searchMSSQL($_POST['search']);
  } else if($handler == "ANPR_Duplicate") {
    $ajax->ANPR_Duplicate($_POST['anpr_id']);
  } else if($handler == "ANPR_Update_Get") {
    $ajax->ANPR_Update_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Update") {
    $ajax->ANPR_Update($_POST['anpr_id'], $_POST['Plate'], $_POST['Capture_Date']);
  }
?>
