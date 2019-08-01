<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Payment.GET_PaymentOptions") {
    $payment->PaymentOptions($_POST['Plate']);
  } else if($handler == "Payment.GET_PaymentServices") {
    $payment->PaymentServices_Dropdown($_POST['Type'], $_POST['Expiry'], $_POST['Plate']);
  } else if($handler == "Payment.Proccess_Transaction") {
    if($_POST['Method'] == 1) {
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], null, null, null);
    } else if($_POST['Method'] == 2) {
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], null, null, null);
    } else if($_POST['Method'] == 3) {
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], $_POST['Account_ID'], null, null);
    } else if($_POST['Method'] == 4) {
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], null, null, null);
    } else if($_POST['Method'] == 5) {
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], null, $_POST['CardNo'], $_POST['CardExpiry']);
    }
  } else if($handler == "Payment.FuelCard_Break") {
    $payment->Payment_FC_Break($_POST['CardStr']);
  } else if($handler == "Payment.GetVehPayments") {
    $payment->PerVehPayments($_POST['Ref']);
  } else if($handler == "Payment.Print_Ticket") {
    $payment->PrintTicket($_POST['Ref']);
  } else if($handler == "Payment.Transaction_List") {
    $payment->Transaction_List($_POST['DateStart'], $_POST['DateEnd']);
  }

?>
