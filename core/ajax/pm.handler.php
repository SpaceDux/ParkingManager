<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "PM.GET_Notifications") {
    $pm->GET_Notifications();
  }

?>
