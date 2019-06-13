<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Payment.GET_PaymentOptions") {
    $payment->PaymentOptions($_POST['Plate']);
  }

?>
