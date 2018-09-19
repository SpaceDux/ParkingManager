<?php
  //Ryans Notes
  //SQLSRV or ODBC Driver needed.

  session_start();
  //Define the directories
  define('C', '/core');
  define('F', '/class');
  define('M', '/manage');

  //Required Files
    //Manage
  require(__DIR__ . C . M . '/configure.php');
    //Functions
  require(__DIR__ . C . F . '/mysql.class.php');
  require(__DIR__ . C . F . '/user.class.php');
  require(__DIR__ . C . F . '/mssql.class.php');
  require(__DIR__ . C . F . '/pm.class.php');
  require(__DIR__ . C . F . '/vehicles.class.php');
  require(__DIR__ . C . F . '/payment.class.php');
  require(__DIR__ . C . F . '/ajax.class.php');

  //Define CONFIG settings
  define('URL', $_CONFIG['pm']['url']);
  define('VER', "3.0.5");
  define('Footer', 'ParkingManager (PM) &copy; 2018 | Designed, developed & owned by <a href="mailto:ryan@roadkingcafe.uk"><b>Ryan. W</b> Licensed by RoadKing Truckstops &copy;</a>');
  define('License', '<br><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">ParkingManager (PM)</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>');


  //Set Timezone
  date_default_timezone_set($_CONFIG['pm']['timezone']);

  //Functions to start upon startup
  use ParkingManager as PM;

  $user = new PM\User;
  $pm = new PM\PM;

  if($user->isLogged() == true) {
    $vehicles = new PM\Vehicles;
    $payment = new PM\Payment;
    $ajax = new PM\AJAX;
  }

  //Checks
  //Redirect for auth
  if(!isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) != "index.php") {
    header('Location: index');
  } else if (isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) == "index.php") {
      header('Location: main');
  }
  #Check a session hasn't remotely been cut
  $user->forceLogout();
?>
