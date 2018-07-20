<?php
  //This is the file that pulls it
  //all together!

  require __DIR__.'/core/manage/config.php';
  require __DIR__.'/core/manage/dbcon.php';
  require __DIR__.'/core/parking.func.php';
  require __DIR__.'/core/account.func.php';
  require __DIR__.'/core/pm.func.php';

  $parking = new Parking;
  $account = new Account;
  $pm = new ParkingManager;

  $GetBreaks = $parking->fetchBreak();
  $GetPaid = $parking->fetchPaid();
  $GetRenewals = $parking->fetchRenewals();
  $GetExits = $parking->fetchExits();

  $ver = "2.1.1";

?>
