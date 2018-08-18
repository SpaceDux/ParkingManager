<?php
  //Define the directories
  define('C', '/core');
  define('F', '/functions');
  define('M', '/manage');
  define('I', '/interfaces');

  //Required Files
    //Manage
  require(__DIR__ . C . M . '/configure.php');
    //Interfaces
  require(__DIR__ . C . I . '/user.interface.php');
    //Functions
  require(__DIR__ . C . F . '/mysql.func.php');
  require(__DIR__ . C . F . '/user.func.php');
  require(__DIR__ . C . F . '/pm.func.php');

  //Define CONFIG settings
  define('URL', $_CONFIG['pm']['url']);
  define('VER', "3.0.1");

  //Set Timezone
  date_default_timezone_set($_CONFIG['pm']['timezone']);

  //Functions to start upon startup
  use ParkingManager as PM;

  $user = new PM\User;

  $pm = new PM\PM;

  session_start();

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
