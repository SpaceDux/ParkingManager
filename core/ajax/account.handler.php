<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Account.New_Account") {
    $account->Register_Account();
  }


?>
