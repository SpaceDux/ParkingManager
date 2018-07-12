<?php
  // Configure Parking Manage
  // Server Details

  //MySQL...
  $dbHost = '127.0.0.1';
  $dbU = 'root';
  $dbPw = '';
  $dbSel = 'rkpm';

  //Website...
  $url = 'http://localhost/ParkingManager'; //Does not end with '/'!!

  //Gate Functions
  $entryBarrier = "http://192.168.3.37/setParam.cgi?DOPulseStart_05=1?";
  $exitBarrier = "http://192.168.3.37/setParam.cgi?DOPulseStart_04=1?";


?>
