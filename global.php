<?php
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
  define('VER', "3.0.3");
  define('Footer', 'ParkingManager (PM) &copy; 2018/2019 | Designed, developed by <a href="mailto:ryan@roadkingcafe.uk"><b>Ryan. W</b> with RoadKing Truckstops &copy;</a>');

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
