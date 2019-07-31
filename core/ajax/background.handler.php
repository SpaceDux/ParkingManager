<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Background.Automation_Exit") {
    $background->Automation_Exit();
  }


?>
