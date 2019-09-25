<?php
  require 'global.php';

  if(!isset($_POST['TL_Cash'])) {
    $_POST['TL_Cash'] = '0';
  }
  if(!isset($_POST['TL_Card'])) {
    $_POST['TL_Card'] = '0';
  }
  if(!isset($_POST['TL_Account'])) {
    $_POST['TL_Account'] = '0';
  }
  if(!isset($_POST['TL_SNAP'])) {
    $_POST['TL_SNAP'] = '0';
  }
  if(!isset($_POST['TL_Fuel'])) {
    $_POST['TL_Fuel'] = '0';
  }

  $payment->Download_Sales($_POST['TL_DateStart'], $_POST['TL_DateEnd'], $_POST['TL_Cash'], $_POST['TL_Card'], $_POST['TL_Account'], $_POST['TL_SNAP'], $_POST['TL_Fuel'], $_POST['TL_Group']);
?>
