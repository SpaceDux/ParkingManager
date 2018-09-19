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
  } else if($handler == "ANPR_Search") {
    $ajax->ANPR_Search($_POST['ANPRKey']);
  } else if($handler == "ANPR_Duplicate") {
    $ajax->ANPR_Duplicate($_POST['anpr_id']);
  } else if($handler == "ANPR_Update_Get") {
    $ajax->ANPR_Update_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Update") {
    $ajax->ANPR_Update($_POST['anpr_id'], $_POST['Plate'], $_POST['Capture_Date']);
  } else if($handler == "ANPR_Add") {
    $ajax->ANPR_Add($_POST['Plate'], $_POST['Date']);
  } else if($handler == "PM_Search") {
    $ajax->PM_Search($_POST['PMKey']);
  } else if($handler == "ANPR_Image_Get") {
    $ajax->ANPR_Image_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Barrier") {
    $ajax->ToggleBarrier($_POST['barrier']);
  }
?>
