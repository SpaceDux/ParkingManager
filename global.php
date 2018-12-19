<?php
  //Ryans Notes
  //SQLSRV or ODBC Driver needed.

  session_start();
  //Define the directories
  define('C', '/core');
  define('F', '/class');
  define('M', '/manage');
  define('V', '/vendor');

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
  require(__DIR__ . C . F . '/anpr.class.php');
  require(__DIR__ . C . F . '/account.class.php');
  require(__DIR__ . C . F . '/reports.class.php');
  require(__DIR__ . C . F . '/ticket.class.php');
    //Caution
  require(__DIR__ . C . F . '/background.class.php');
  require(__DIR__ . V . '/autoload.php');
  //Define CONFIG settings
  define('URL', $_CONFIG['pm']['url']);
  define('VER', "3.1.12");
  define('Footer', 'ParkingManager (PM) &copy; 2018 | Designed, developed & owned by <a href="mailto:ryan@roadkingcafe.uk"><b>Ryan. W</b></a> with Roadking Truckstops &copy;');


  //Set Timezone
  date_default_timezone_set($_CONFIG['pm']['timezone']);

  //Functions to start upon startup (DOES NOT CALL MSSQL/MYSQL)
  use ParkingManager as PM;

  $user = new PM\User;
  $pm = new PM\PM;
  if($user->isLogged() == true) {
    $vehicles = new PM\Vehicles;
    $payment = new PM\Payment;
    $anpr = new PM\ANPR;
    $background = new PM\Background;
    $account = new PM\Account;
    $reports = new PM\Reports;
    $ticket = new PM\Ticket;
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


  //error_reporting(0);
?>
