<?php
  require($_SERVER['DOCUMENT_ROOT']."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Vehicles.Vehicles_MyPlatesAsTbl") {
    $vehicles->Vehicles_MyPlatesAsTbl();
  } else if($handler == "Vehicles.Vehicles_AddPlate") {
    $vehicles->Vehicles_AddPlate(htmlspecialchars($_POST['Plate']), htmlspecialchars($_POST['Name']));
  } else if($handler == "Vehicles.Vehicles_DeletePlate") {
    $vehicles->Vehicles_DeletePlate($_POST['Ref']);
  }
?>
