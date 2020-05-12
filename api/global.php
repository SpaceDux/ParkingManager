<?php

//Required Files

	//Config
	require_once(__DIR__.'/Configure/config.php');

	//Class Files
	require_once(__DIR__.'/Configure/class/mysql.class.php');
	require_once(__DIR__.'/Configure/class/mssql.class.php');
	require_once(__DIR__.'/Configure/class/checks.class.php');
	require_once(__DIR__.'/Configure/class/vehicles.class.php');
	require_once(__DIR__.'/Configure/class/transaction.class.php');
	require_once(__DIR__.'/Configure/class/rev.class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');


	use ParkingManager_API as PM;

	$checks = new PM\Checks();
	// $mysql = new PM\MySQL();
	// $mssql = new PM\MSSQL();
	$vehicles = new PM\Vehicles();
	$transaction = new PM\Transaction();


	date_default_timezone_set('Europe/London');

	// error_reporting(1);

?>
