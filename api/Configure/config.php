<?php
// Configuration file for ParkingManager 4 API
// ParkingManager - Author: Ryan Williams
// API - Author: Ryan Williams

	// Server configuration (MySQL Connection)
	$_CONFIG['mysql']['host'] = 'localhost'; //The IP for the datebase server
	$_CONFIG['mysql']['port'] = '3306'; //The username for the database server
	$_CONFIG['mysql']['user'] = 'root'; //The username for the database server
	$_CONFIG['mysql']['pass'] = ''; //The password for the datebase server
	$_CONFIG['mysql']['db'] = 'parking_manager4'; //Select the database you want to connect too
	// Server configuration (MSSQL Connection)
	$_CONFIG['mssql']['host'] = '192.168.3.201'; //The IP for the datebase server
	$_CONFIG['mssql']['user'] = 'pm'; //The username for the database server
	$_CONFIG['mssql']['pass'] = '1212'; //The password for the datebase server
	$_CONFIG['mssql']['db'] = 'ANPR'; //Select the database you want to connect too
	//ETP API Settings
	$_CONFIG['ETP']['API'] = array('api_uri' => 'https://api.etpcp.com/trx/',
											 'api_user' => 'sm394_34lll2345Ae',
											 'api_pass' => 'P2002laeif[3234JklmNo1A@344_12Qq');
	// Settings
  $_CONFIG['api']['user'] = 'kiosks'; //Site ID Number
  $_CONFIG['api']['pass'] = 'kiosks1923'; //Site ID Number
?>
