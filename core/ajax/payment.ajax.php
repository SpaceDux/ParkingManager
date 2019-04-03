<?php
  require(__DIR__."..\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "ExitKeypad") { //Exit Vehicle from PM
    $pm->PM_ExitKeyPad($_POST['Code']);
  } else if($handler == "Payment_Add_Service") {
    $payment->Payment_Services_New($_POST['Service_Name'], $_POST['Service_Ticket_Name'], $_POST['Service_Price_Gross'], $_POST['Service_Price_Net'], $_POST['Service_Expiry'], $_POST['Service_Cash'], $_POST['Service_Card'], $_POST['Service_Account'], $_POST['Service_SNAP'], $_POST['Service_Fuel'], $_POST['Service_Campus'], $_POST['Service_Meal_Amount'], $_POST['Service_Shower_Amount'], $_POST['Service_Group'], $_POST['Service_Vehicles'], $_POST['Service_ETPID'], $_POST['Service_Active'], $_POST['Service_WiFi_Amount'], $_POST['Service_Discount_Amount']);
  } else if ($handler == "Payment_Service_Update_GET") {
    $payment->Payment_Service_Update_Get($_POST['id']);
  } else if ($handler == "Payment_Service_Update") {
    $payment->Payment_Service_Update($_POST['Service_ID_Update'], $_POST['Service_Name_Update'], $_POST['Service_Ticket_Name_Update'], $_POST['Service_Price_Gross_Update'], $_POST['Service_Price_Net_Update'], $_POST['Service_Expiry_Update'], $_POST['Service_Cash_Update'], $_POST['Service_Card_Update'], $_POST['Service_Account_Update'], $_POST['Service_SNAP_Update'], $_POST['Service_Fuel_Update'], $_POST['Service_Campus_Update'], $_POST['Service_Vehicles_Update'], $_POST['Service_Meal_Amount_Update'], $_POST['Service_Shower_Amount_Update'], $_POST['Service_Group_Update'], $_POST['Service_ETPID_Update'], $_POST['Service_Active_Update'], $_POST['Service_WiFi_Amount_Update'], $_POST['Service_Discount_Amount_Update']);
  } else if($handler == "Payment_Update_GET") {
    $payment->Payment_Upate_GET($_POST['id']);
  } else if($handler == "Payment_Update_POST") {
    $payment->Payment_Upate_POST($_POST['Payment_Update_ID'], $_POST['Payment_Update_DateTime']);
  }

?>
