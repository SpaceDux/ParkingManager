<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Account.New_Account") {
    $account->Register_Account($_POST['Name'], $_POST['ShortName'], $_POST['Address'], $_POST['Contact_Email'], $_POST['Billing_Email'], $_POST['Site'], $_POST['Shared'], $_POST['Discount'], $_POST['Status']);
  }


?>
