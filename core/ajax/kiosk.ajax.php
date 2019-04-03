<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Kiosk_Plate_Search") {
    $kiosk->Kiosk_Search($_POST['Plate']);
  }

?>
