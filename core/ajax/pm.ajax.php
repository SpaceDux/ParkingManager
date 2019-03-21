<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "ExitKeypad") { //Exit Vehicle from PM
    $pm->PM_ExitKeyPad($_POST['Code']);
  } else if($handler == "PM_SiteSwap") {
    $pm->PM_SiteSwap();
  }

?>
