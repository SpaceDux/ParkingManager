<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Background.Automation_Exit") {
    $background->Automation_Exit();
  } else if($handler == "Background.Parking_Reinstate") {
    $background->Parking_Reinstate();
  } else if($handler == "Background.Blacklist_Check") {
    $background->Blacklist_Check();
  }


?>
