<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Payment.GET_PaymentOptions") {
    $payment->PaymentOptions($_POST['Plate']);
  } else if($handler == "Payment.GET_PaymentServices") {
    $payment->PaymentServices_Dropdown($_POST['Type'], $_POST['Expiry'], $_POST['Plate']);
  }

?>
