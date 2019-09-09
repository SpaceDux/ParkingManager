<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Account.New_Account") {
    $account->Register_Account($_POST['Name'], $_POST['ShortName'], $_POST['Address'], $_POST['Contact_Email'], $_POST['Billing_Email'], $_POST['Site'], $_POST['Shared'], $_POST['Discount'], $_POST['Status']);
  } else if($handler == "Account.Update_Account_GET") {
    $account->Update_Account_GET($_POST['Ref']);
  } else if($handler == "Account.Update_Account") {
    $account->Update_Account($_POST['Ref'], $_POST['Name'], $_POST['ShortName'], $_POST['Address'], $_POST['Contact_Email'], $_POST['Billing_Email'], $_POST['Site'], $_POST['Shared'], $_POST['Discount'], $_POST['Status']);
  } else if($handler == "Account.Update_Fleet_GET") {
    $account->Update_Fleet_GET($_POST['Ref']);
  } else if($handler == "Account.Update_Fleet") {
    $account->Update_Fleet($_POST['Ref'], $_POST['Plate']);
  } else if($handler == "Account.Delete_Fleet_Record") {
    $account->Delete_Fleet_Record($_POST['Ref']);
  } else if($handler == "Account.Account_Report") {
    $account->Account_Report($_POST['Account'], $_POST['DateStart'], $_POST['DateEnd']);
  } else if($handler == "Account.DownloadReport") {
    $account->DownloadReport($_POST['Account'], $_POST['DateStart'], $_POST['DateEnd']);
  }


?>
