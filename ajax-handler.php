<?php
  require(__DIR__."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "exit") { //Exit Vehicle from PM
    $vehicles->Vehicle_Exit($_POST['veh_id']);
  } else if($handler == "markRenewal") { //Mark Vehicle for Renewal
    $vehicles->Vehicle_MarkRenewal($_POST['veh_id']);
  } else if($handler == "setFlag") {
    $vehicles->Vehicle_Flag($_POST['veh_id']);
  } else if($handler == "deleteVehicle") {
    $vehicles->Vehicle_Delete($_POST['veh_id']);
  } else if($handler == "deleteNotice") {
    $pm->PM_DeleteNotice($_POST['notice_id']);
  } else if($handler == "ANPR_Search") {
    $anpr->ANPR_Search($_POST['ANPRKey']);
  } else if($handler == "ANPR_Duplicate") {
    $anpr->ANPR_Duplicate($_POST['anpr_id']);
  } else if($handler == "ANPR_Update_Get") {
    $anpr->ANPR_Update_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Update") {
    $anpr->ANPR_Update($_POST['anpr_id'], $_POST['Plate'], $_POST['Capture_Date']);
  } else if($handler == "ANPR_Add") {
    $anpr->ANPR_Add($_POST['Plate'], $_POST['Date']);
  } else if($handler == "PM_Search") {
    $pm->PM_Search($_POST['PMKey']);
  } else if($handler == "ANPR_Image_Get") {
    $anpr->ANPR_Image_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Barrier") {
    $anpr->ToggleBarrier($_POST['barrier']);
  } else if($handler == "Payment_Add_Service") {
    $payment->Add_Service($_POST['Service_Name'], $_POST['Service_Ticket'], $_POST['Service_Price_Gross'], $_POST['Service_Price_Net'], $_POST['Service_Expiry'], $_POST['Service_Cash'], $_POST['Service_Card'], $_POST['Service_Account'], $_POST['Service_Snap'], $_POST['Service_Fuel'], $_POST['Service_Campus'], $_POST['Service_Meal'], $_POST['Service_Shower'], $_POST['Service_Meal_Amount'], $_POST['Service_Shower_Amount']);
  } else if($handler == "Payment_Service_Delete") {
    $payment->DeleteService($_POST['Service']);
  } else if($handler == "Payment_Service_Update_Get") {
    $payment->Payment_Service_Update_Get($_POST['service_id']);
  } else if($handler == "Payment_Service_Update") {
    $payment->Payment_Service_Update($_POST['Service_ID'], $_POST['Service_Name'], $_POST['Service_Ticket'], $_POST['Service_Price_Gross'], $_POST['Service_Price_Net'], $_POST['Service_Expiry'], $_POST['Service_Cash'], $_POST['Service_Card'], $_POST['Service_Account'], $_POST['Service_Snap'], $_POST['Service_Fuel'], $_POST['Service_Campus'], $_POST['Service_Meal'], $_POST['Service_Shower'], $_POST['Service_Vehicles'], $_POST['Service_Meal_Amount'], $_POST['Service_Shower_Amount']);
  } else if($handler == "Update_User_Get") {
    $user->Update_User_Get($_POST['User_ID']);
  } else if($handler == "Update_User") {
    $user->Update_User($_POST['User_ID'], $_POST['User_Firstname_Update'], $_POST['User_Lastname_Update'], $_POST['User_Email_Update'], $_POST['User_Campus_Update'], $_POST['User_ANPR_Update'], $_POST['User_Rank_Update']);
  } else if ($handler == "User_Add") {
    $user->Register_User($_POST['User_Firstname_New'], $_POST['User_Lastname_New'], $_POST['User_Email_New'], $_POST['User_Password_New'], $_POST['User_ANPR_New'], $_POST['User_Rank_New'], $_POST['User_Campus_New']);
  } else if($handler == "User_Delete") {
    $user->User_Delete($_POST['User_ID']);
  } else if($handler == "Force_Logout") {
    $user->adminLogout($_POST['User_ID']);
  } else if($handler == "Vehicle_Service_Delete") {
    $pm->Vehicle_Service_Delete($_POST['id']);
  } else if($handler == "Vehicle_Service_Update_Get") {
    $pm->Vehicle_Service_Update_Get($_POST['type_id']);
  } else if($handler == "Vehicle_Service_Update_Data") {
    $pm->Vehicle_Service_Update($_POST['id'], $_POST['name'], $_POST['short'], $_POST['url'], $_POST['campus']);
  } else if($handler == "Payment_Service_Cash_Dropdown_Get") {
    $payment->Payment_ServiceSelect_Cash($_POST['vehicle_type']);
  } else if($handler == "Payment_Service_Card_Dropdown_Get") {
    $payment->Payment_ServiceSelect_Card($_POST['vehicle_type']);
  } else if($handler == "Payment_Service_Account_Dropdown_Get") {
    $payment->Payment_ServiceSelect_Account($_POST['vehicle_type']);
  } else if($handler == "Transaction_Proccess_Cash") {
    $payment->Transaction_Proccess_Cash($_POST['ANPRKey'], $_POST['Plate'], $_POST['Company'], $_POST['Trailer'], $_POST['Vehicle_Type'], $_POST['Service']);
  } else if($handler == "Transaction_Proccess_Card") {
    $payment->Transaction_Proccess_Card($_POST['ANPRKey'], $_POST['Plate'], $_POST['Company'], $_POST['Trailer'], $_POST['Vehicle_Type'], $_POST['Service']);
  } else if($handler == "Transaction_Proccess_Account") {
    $payment->Transaction_Proccess_Account($_POST['ANPRKey'], $_POST['Plate'], $_POST['Company'], $_POST['Trailer'], $_POST['Vehicle_Type'], $_POST['Service'], $_POST['Account']);
  } else if($handler == "Automation_Exit") {
    $background->Automation_Exit(); //Automate the exit reads
  }
?>
