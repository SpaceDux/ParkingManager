<?php
// Configuration file for ParkingManager 4
//ParkingManager - Author: Ryan Williams
//Fenrir - Author: Ryan Williams

	//Server configuration (MySQL Connection)
	$_CONFIG['mysql']['host'] = 'localhost'; //The IP for the datebase server
	$_CONFIG['mysql']['port'] = '3306'; //The username for the database server
	$_CONFIG['mysql']['user'] = 'root'; //The username for the database server
	$_CONFIG['mysql']['pass'] = ''; //The password for the datebase server
	$_CONFIG['mysql']['db'] = 'pmcp'; //Select the database you want to connect too

	// Site Configuration
	$_CONFIG['site']['url'] = 'http://192.168.0.5'; //Server URL example.com (DOES NOT END WITH /)
	$_CONFIG['site']['name'] = 'ParkingManager Portal'; //Website name, {SITE_NAME}
	$_CONFIG['site']['template'] = 'RKPortal'; //Fenrir Template System, Select the Template Directory
	$_CONFIG['site']['doc_route'] = 'portal'; //Directory after $_SERVER['DOCUMENT_ROOT']

	// Misc
	$_CONFIG['misc']['copy'] = 'ParkingManager 4 | Copyright &copy; 2019 Roadking Truckstops'; //Fenrir Template System, Select the Template Directory
	$_CONFIG['misc']['version'] = '1.0.0';
?>
