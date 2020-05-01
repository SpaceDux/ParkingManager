<?php
// Configuration file for ParkingManager 4
//ParkingManager - Author: Ryan Williams
//Fenrir - Author: Ryan Williams

	//Server configuration (MySQL Connection)
	$_CONFIG['mysql']['host'] = '127.0.0.1'; //The IP for the datebase server
	$_CONFIG['mysql']['port'] = '3306'; //The username for the database server
	$_CONFIG['mysql']['user'] = 'root'; //The username for the database server
	$_CONFIG['mysql']['pass'] = ''; //The password for the datebase server
	$_CONFIG['mysql']['db'] = 'pm4'; //Select the database you want to connect too

	// Site Configuration
	$_CONFIG['site']['url'] = 'http://192.168.0.24'; //Server URL example.com (DOES NOT END WITH /)
	$_CONFIG['site']['name'] = 'ParkingManager'; //Website name, {SITE_NAME}
	$_CONFIG['site']['template'] = 'Vision'; //Fenrir Template System, Select the Template Directory

	//ETP API Settings
	$_CONFIG['ETP']['API'] = array('api_uri' => 'https://api.etpcp.com/trx/',
											 'api_user' => 'sm394_34lll2345Ae',
											 'api_pass' => 'P2002laeif[3234JklmNo1A@344_12Qq');

	// Portal
	$_CONFIG['Portal']['URL'] = 'https://portal.roadkingtruckstop.co.uk/api/';
	
	// Misc
	$_CONFIG['misc']['copy'] = 'ParkingManager 4 | Copyright &copy; 2019 Roadking Truckstops'; //Fenrir Template System, Select the Template Directory
	$_CONFIG['misc']['version'] = '4.2.0';
?>
