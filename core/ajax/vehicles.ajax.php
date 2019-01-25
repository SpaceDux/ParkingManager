<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "ANPR_Feed") { //Exit Vehicle from PM
    $vehicles->get_anprFeed();
  }

?>
