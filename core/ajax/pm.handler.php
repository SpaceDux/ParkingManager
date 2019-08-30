<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "PM.GET_Notifications") {
    $pm->GET_Notifications();
  } else if($handler == "PM.New_Site") {
    $pm->New_Site(array('Name' => $_POST['Site_Name'],'BarrierIN' => $_POST['Site_Barrier_IN'],'BarrierOUT' => $_POST['Site_Barrier_OUT'],'Vatno' => $_POST['Site_VAT'],'ANPR_IP' => $_POST['Site_ANPR_IP'],'ANPR_DB' => $_POST['Site_ANPR_DB'],'ANPR_Imgsrv' => $_POST['Site_ANPR_Imgsrv'],'ANPR_User' => $_POST['Site_ANPR_User'],'ANPR_Pass' => $_POST['Site_ANPR_Pass'],'ANPR_Imgstr' => $_POST['Site_ANPR_Imgstr'],'Unifi_Status' => $_POST['Site_Unifi_Status'],'Unifi_User' => $_POST['Site_Unifi_User'],'Unifi_Pass' => $_POST['Site_Unifi_Pass'],'Unifi_IP' => $_POST['Site_Unifi_IP'],'Unifi_Ver' => $_POST['Site_Unifi_Ver'],'Unifi_Site' => $_POST['Site_Unifi_Site'],'ETP_User' => $_POST['Site_ETP_User'],'ETP_Pass' => $_POST['Site_ETP_Pass']));
  } else if($handler == "PM.Update_Site_GET") {
    $pm->Update_Site_GET($_POST['Ref']);
  } else if($handler == "PM.Update_Site") {
    $pm->Update_Site(array('Ref' => $_POST['Site_Ref_Update'],'Name' => $_POST['Site_Name_Update'],'BarrierIN' => $_POST['Site_Barrier_IN_Update'],'BarrierOUT' => $_POST['Site_Barrier_OUT_Update'],'Vatno' => $_POST['Site_VAT_Update'],'ANPR_IP' => $_POST['Site_ANPR_IP_Update'],'ANPR_DB' => $_POST['Site_ANPR_DB_Update'],'ANPR_Imgsrv' => $_POST['Site_ANPR_Imgsrv_Update'],'ANPR_User' => $_POST['Site_ANPR_User_Update'],'ANPR_Pass' => $_POST['Site_ANPR_Pass_Update'],'ANPR_Imgstr' => $_POST['Site_ANPR_Imgstr_Update'],'Unifi_Status' => $_POST['Site_Unifi_Status_Update'],'Unifi_User' => $_POST['Site_Unifi_User_Update'],'Unifi_Pass' => $_POST['Site_Unifi_Pass_Update'],'Unifi_IP' => $_POST['Site_Unifi_IP_Update'],'Unifi_Ver' => $_POST['Site_Unifi_Ver_Update'],'Unifi_Site' => $_POST['Site_Unifi_Site_Update'],'ETP_User' => $_POST['Site_ETP_User_Update'],'ETP_Pass' => $_POST['Site_ETP_Pass_Update']));
  } else if($handler == "PM.EOD_Settlement") {
    $ticket->EOD_Settlement($_POST['Date1'], $_POST['Date2']);
  } else if($handler == "PM.Barrier_Toggle") {
    $pm->Barrier_Control($_POST['Which']);
  }

?>
