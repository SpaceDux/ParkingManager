<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Vehicles.ANPR_Feed") {
    $vehicles->ANPR_Feed();
  } else if($handler == "Vehicles.ALLVEH_Feed") {
    $vehicles->ALLVEH_Feed();
  } else if($handler == "Vehicles.ANPR_Duplicate") {
    $vehicles->ANPR_Duplicate($_POST['Uniqueref']);
  } else if($handler == "Vehicles.ANPR_Secondary_Duplicate") {
    $vehicles->ANPR_Secondary_Duplicate($_POST['Uniqueref']);
  } else if($handler == "Vehicles.ANPR_AddPlate") {
    $vehicles->ANPR_AddPlate($_POST['Plate'], $_POST['Time']);
  } else if($handler == "Vehicles.ANPR_GetImages") {
    $vehicles->ANPR_GetImages($_POST['Ref']);
  } else if($handler == "Vehicles.ANPR_Update") {
    $vehicles->ANPR_Update($_POST['Update_Ref'], $_POST['Update_Plate'], $_POST['Update_Trl'], $_POST['Update_Time']);
  } else if($handler == "Vehicles.ANPR_Secondary_Update") {
    $vehicles->ANPR_Secondary_Update($_POST['Update_Secondary_Ref'], $_POST['Update_Secondary_Plate'], $_POST['Update_Secondary_Trl'], $_POST['Update_Secondary_Time']);
  } else if($handler == "Vehicles.TimeCalc") {
    $vehicles->timeCalc($_POST['Time1'], $_POST['Time2']);
  } else if($handler == "Vehicles.Parking_GetImages") {
    $vehicles->GetImages($_POST['Ref']);
  } else if($handler == "Vehicles.GetDetails") {
    $vehicles->GetDetails($_POST['Ref']);
  } else if($handler == "Vehicles.UpdateRecord") {
    $vehicles->UpdateRecord($_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trailer'], $_POST['VehType'], $_POST['Column'], $_POST['Arrival'], $_POST['Exit'], $_POST['Notes']);
  } else if($handler == "Vehicles.CheckDuplicate") {
    $vehicles->CheckDuplicate($_POST['Plate']);
  } else if($handler == "Vehicles.QuickExit") {
    $vehicles->QuickExit($_POST['Ref']);
  } else if($handler == "Vehicles.QuickFlag") {
    $vehicles->QuickFlag($_POST['Ref'], $_POST['Flagged']);
  } else if($handler == "Vehicles.Search_Parking") {
    $vehicles->Search_Parking_Records($_POST['Key']);
  } else if($handler == "Vehicles.Search_ANPR") {
    $vehicles->Search_ANPR_Records($_POST['Key']);
  }

?>
