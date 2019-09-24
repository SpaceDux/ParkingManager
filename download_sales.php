<?php
  require 'global.php';
  $payment->Download_Sales($_POST['TL_DateStart'], $_POST['TL_DateEnd'], $_POST['TL_Cash'], $_POST['TL_Card'], $_POST['TL_Account'], $_POST['TL_SNAP'], $_POST['TL_Fuel'], $_POST['TL_Group']);
?>
