<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Kiosk_Search") {
    $kiosk->Kiosk_Search($_POST['Plate']);
  } else if($handler == "Kiosk_GET_PaymentTypes") {
    $kiosk->Kiosk_GET_PaymentTypes($_POST['Kiosk_Plate']);
  } else if($handler == "Kiosk_GET_PaymentServices") {
    $kiosk->Kiosk_GET_PaymentServices($_POST['Kiosk_PayType'], $_POST['Kiosk_Expiry'], $_POST['Kiosk_Type']);
  } else if ($handler == "Kiosk_ConfirmInfo") {
    $kiosk->Kiosk_ConfirmInfo($_POST['Kiosk_Plate'], $_POST['Kiosk_PayType'], $_POST['Kiosk_Expiry'], $_POST['Kiosk_Type']);
  } else if ($handler == "Kiosk_Begin_Parking_Transaction") {
    $kiosk->Kiosk_Begin_Parking_Transaction($_POST['Kiosk_Plate'], $_POST['Kiosk_System'], $_POST['Kiosk_ID'], $_POST['Kiosk_Type'], $_POST['Kiosk_PayType'], $_POST['Kiosk_Service'], $_POST['Kiosk_FuelCard']);
  }

?> 
