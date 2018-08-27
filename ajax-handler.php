<?php
  require(__DIR__."/global.php");
  $page = isset($_GET['p'])?$_GET['p']:'';

  if($page == "exit") {
    $ajax->exitVehicle($_POST['veh_id']);
  }
?>
