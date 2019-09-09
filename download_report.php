<?php
  require 'global.php';
  if($_POST['Report_Account'] != 'unselected' && $_POST['Report_DateFrom'] != '' && $_POST['Report_DateToo'] != '' && isset($_POST['Report_Account'])) {
    $account->DownloadReport($_POST['Report_Account'], $_POST['Report_DateFrom'], $_POST['Report_DateToo']);
  } else {

  }
?>
