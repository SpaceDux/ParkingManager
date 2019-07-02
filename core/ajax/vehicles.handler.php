<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Vehicles.ANPR_Feed") {
    $vehicles->ANPR_Feed();
  } else if($handler == "Vehicles.ALLVEH_Feed") {
    $vehicles->ALLVEH_Feed();
  } else if($handler == "Vehicles.ANPR_Duplicate") {
    $vehicles->ANPR_Duplicate($_POST['Uniqueref']);
  } else if($handler == "Vehicles.ANPR_AddPlate") {
    $vehicles->ANPR_AddPlate($_POST['Plate'], $_POST['Time']);
  } else if($handler == "Vehicles.ANPR_GetImages") {
    $vehicles->ANPR_GetImages($_POST['Ref']);
  } else if($handler == "Vehicles.ANPR_Update") {
    $vehicles->ANPR_Update($_POST['Update_Ref'], $_POST['Update_Plate'], $_POST['Update_Trl'], $_POST['Update_Time']);
  } else if($handler == "Vehicles.TimeCalc") {
    $vehicles->timeCalc($_POST['Time1'], $_POST['Time2']);
  }

?>
