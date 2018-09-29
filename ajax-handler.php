<?php
  require(__DIR__."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "exit") {
    $ajax->exitVehicle($_POST['veh_id']);
  } else if($handler == "markRenewal") {
    $ajax->markRenewal($_POST['veh_id']);
  } else if($handler == "setFlag") {
    $ajax->setFlag($_POST['veh_id']);
  } else if($handler == "searchDb_vehLogs") {
    $ajax->searchDb_veh_logs($_POST['query']);
  } else if($handler == "deleteVehicle") {
    $ajax->deleteVehicle($_POST['veh_id']);
  } else if($handler == "deleteNotice") {
    $ajax->deleteNotice($_POST['notice_id']);
  } else if($handler == "ANPR_Search") {
    $ajax->ANPR_Search($_POST['ANPRKey']);
  } else if($handler == "ANPR_Duplicate") {
    $ajax->ANPR_Duplicate($_POST['anpr_id']);
  } else if($handler == "ANPR_Update_Get") {
    $ajax->ANPR_Update_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Update") {
    $ajax->ANPR_Update($_POST['anpr_id'], $_POST['Plate'], $_POST['Capture_Date']);
  } else if($handler == "ANPR_Add") {
    $ajax->ANPR_Add($_POST['Plate'], $_POST['Date']);
  } else if($handler == "PM_Search") {
    $ajax->PM_Search($_POST['PMKey']);
  } else if($handler == "ANPR_Image_Get") {
    $ajax->ANPR_Image_Get($_POST['anpr_id']);
  } else if($handler == "ANPR_Barrier") {
    $ajax->ToggleBarrier($_POST['barrier']);
  } else if($handler == "Payment_Add_Service") {
    $payment->Add_Service($_POST['Service_Name'], $_POST['Service_Price_Gross'], $_POST['Service_Price_Net'], $_POST['Service_Expiry'], $_POST['Service_Cash'], $_POST['Service_Card'], $_POST['Service_Account'], $_POST['Service_Snap'], $_POST['Service_Fuel'], $_POST['Service_Campus'], $_POST['Service_Meal'], $_POST['Service_Shower']);
  } else if($handler == "Payment_Service_Delete") {
    $payment->DeleteService($_POST['Service']);
  } else if($handler == "Payment_Service_Update_Get") {
    $payment->Payment_Service_Update_Get($_POST['service_id']);
  } else if($handler == "Payment_Service_Update") {
    $payment->Payment_Service_Update($_POST['Service_ID'], $_POST['Service_Name'], $_POST['Service_Price_Gross'], $_POST['Service_Price_Net'], $_POST['Service_Expiry'], $_POST['Service_Cash'], $_POST['Service_Card'], $_POST['Service_Account'], $_POST['Service_Snap'], $_POST['Service_Fuel'], $_POST['Service_Campus'], $_POST['Service_Meal'], $_POST['Service_Shower']);
  } else if($handler == "Update_User_Get") {
    $ajax->Update_User_Get($_POST['User_ID']);
  } else if($handler == "Update_User") {
    $ajax->Update_User($_POST['User_ID'], $_POST['User_Firstname_Update'], $_POST['User_Lastname_Update'], $_POST['User_Email_Update'], $_POST['User_Campus_Update'], $_POST['User_ANPR_Update'], $_POST['User_Rank_Update']);
  } else if ($handler == "User_Add") {
    $ajax->Register_User($_POST['User_Firstname_New'], $_POST['User_Lastname_New'], $_POST['User_Email_New'], $_POST['User_Password_New'], $_POST['User_ANPR_New'], $_POST['User_Rank_New'], $_POST['User_Campus_New']);
  } else if($handler == "User_Delete") {
    $ajax->User_Delete($_POST['User_ID']);
  } else if($handler == "Force_Logout") {
    $ajax->adminLogout($_POST['User_ID']);
  }
?>
