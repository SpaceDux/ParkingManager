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
      $payment->Proccess_Transaction($_POST['Method'], $_POST['Type'], $_POST['Ref'], $_POST['Plate'], $_POST['Name'], $_POST['Trl'], $_POST['Time'], $_POST['VehType'], $_POST['Service'], null, $_POST['CardNo'], $_POST['CardExpiry'], $_POST['CardRC']);
    }
  } else if($handler == "Payment.FuelCard_Break") {
    $payment->Payment_FC_Break($_POST['CardStr']);
  } else if($handler == "Payment.GetVehPayments") {
    $payment->PerVehPayments($_POST['Ref']);
  } else if($handler == "Payment.Print_Ticket") {
    $payment->PrintTicket($_POST['Ref']);
  } else if($handler == "Payment.Transaction_List") {
    $payment->Transaction_List($_POST['DateStart'], $_POST['DateEnd'], $_POST['Cash'], $_POST['Card'], $_POST['Account'], $_POST['Snap'], $_POST['Fuel'], $_POST['Group'], $_POST['Settlement_Group'], $_POST['Deleted']);
  } else if($handler == "Payment.DeleteTransaction") {
    $payment->Payment_Delete($_POST['Ref']);
  } else if($handler == "Payment.GetTariffs") {
    $payment->List_Tariffs($_POST['Site']);
  } else if($handler == "Payment.Settlement_DropdownOpt") {
    $payment->Settlement_DropdownOpt($_POST['Site'], $_POST['Type']);
  } else if($handler == "Payment.New_Tariff") {
    $payment->New_Tariff($_POST['Tariff_Name'], $_POST['Tariff_TicketName'], $_POST['Tariff_Gross'], $_POST['Tariff_Nett'], $_POST['Tariff_Expiry'], $_POST['Tariff_Group'], $_POST['Tariff_Cash'], $_POST['Tariff_Card'], $_POST['Tariff_Account'], $_POST['Tariff_SNAP'], $_POST['Tariff_Fuel'], $_POST['Tariff_ETPID'], $_POST['Tariff_Meal'], $_POST['Tariff_Shower'], $_POST['Tariff_Discount'], $_POST['Tariff_WiFi'], $_POST['Tariff_VehType'], $_POST['Tariff_Site'], $_POST['Tariff_Status'], $_POST['Tariff_SettlementGroup'], $_POST['Tariff_SettlementMulti'], $_POST['Tariff_Kiosk'], $_POST['Tariff_Portal']);
  } else if($handler == "Payment.Update_Tariff") {
    $payment->Update_Tariff($_POST['Tariff_Ref_Update'], $_POST['Tariff_Name_Update'], $_POST['Tariff_TicketName_Update'], $_POST['Tariff_Gross_Update'], $_POST['Tariff_Nett_Update'], $_POST['Tariff_Expiry_Update'], $_POST['Tariff_Group_Update'], $_POST['Tariff_Cash_Update'], $_POST['Tariff_Card_Update'], $_POST['Tariff_Account_Update'], $_POST['Tariff_SNAP_Update'], $_POST['Tariff_Fuel_Update'], $_POST['Tariff_ETPID_Update'], $_POST['Tariff_Meal_Update'], $_POST['Tariff_Shower_Update'], $_POST['Tariff_Discount_Update'], $_POST['Tariff_WiFi_Update'], $_POST['Tariff_VehType_Update'], $_POST['Tariff_Site_Update'], $_POST['Tariff_Status_Update'], $_POST['Tariff_SettlementGroup_Update'], $_POST['Tariff_SettlementMulti_Update'], $_POST['Tariff_AllowKiosk_Update'], $_POST['Tariff_Portal_Update']);
  } else if($handler == "Payment.Update_Tariff_GET") {
    $payment->Update_Tariff_GET($_POST['Ref']);
  } else if($handler == "Payment.Search_Payments") {
    $payment->Search_Payment_Records($_POST['Key']);
  } else if($handler == "Payment.UpdatePayment_GET") {
    $payment->UpdatePayment_GET($_POST['Ref']);
  } else if($handler == "Payment.UpdatePayment") {
    $payment->UpdatePayment($_POST['Ref'], $_POST['Time']);
  } else if($handler == "Payment.GetSettlementGroup") {
    $payment->List_SettlementGroups($_POST['Site'], $_POST['Type']);
  } else if($handler == "Payment.Update_SettlementGroup_Get") {
    $payment->Update_Settlement_Group_GET($_POST['Ref']);
  } else if($handler == "Payment.SettlementGroup_Update") {
    $payment->Update_Settlement_Group($_POST['Ref'], $_POST['Name'], $_POST['Order'], $_POST['Type'], $_POST['Site']);
  } else if($handler == "Payment.SettlementGroup_Add") {
    $payment->New_Settlement_Group($_POST['Name'], $_POST['Order'], $_POST['Type'], $_POST['Site']);
  } else if($handler == "Payment.Delete_Settlement_Group") {
    $payment->Delete_Settlement_Group($_POST['Ref']);
  } else if($handler == "Payment.CheckBlacklisted") {
    $payment->CheckBlacklisted($_POST['Plate']);
  }

?>
