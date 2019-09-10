<?php

//Required Files

	//Config
	require_once(__DIR__.'/Configure/config.php');

	//Class Files
	require_once(__DIR__.'/Configure/class/mysql.class.php');
	require_once(__DIR__.'/Configure/class/mssql.class.php');
	require_once(__DIR__.'/Configure/class/checks.class.php');
	require_once(__DIR__.'/Configure/class/vehicles.class.php');
	require_once('../../vendor/autoload.php');


	use ParkingManager_API as PM;

	$checks = new PM\Checks();
	$mysql = new PM\MySQL();
	$mssql = new PM\MSSQL();
	$vehicles = new PM\Vehicles();


?>
