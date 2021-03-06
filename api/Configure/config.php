<?php
// Configuration file for ParkingManager 4 API
// ParkingManager - Author: Ryan Williams
// API - Author: Ryan Williams

	// Server configuration (MySQL Connection)
	$_CONFIG['mysql']['host'] = 'localhost'; //The IP for the datebase server
	$_CONFIG['mysql']['port'] = '3306'; //The username for the database server
	$_CONFIG['mysql']['user'] = 'root'; //The username for the database server
	$_CONFIG['mysql']['pass'] = ''; //The password for the datebase server
	$_CONFIG['mysql']['db'] = 'pm4'; //Select the database you want to connect too
	// Server configuration (MSSQL Connection)
	$_CONFIG['mssql']['host'] = '192.168.3.201'; //The IP for the datebase server
	$_CONFIG['mssql']['user'] = 'pm'; //The username for the database server
	$_CONFIG['mssql']['pass'] = '1212'; //The password for the datebase server
	$_CONFIG['mssql']['db'] = 'ANPR'; //Select the database you want to connect too
	$_CONFIG['ANPR']['HTTP_HOST'] = 'http://192.168.0.24'; //Select the database you want to connect too
	$_CONFIG['ANPR']['HTTP_PORT'] = '6868'; //Select the database you want to connect too
	// ANPR Settings
	$_CONFIG['ANPR']['Type'] = "Rev";
	$_CONFIG['ANPR']['Host'] = '127.0.0.1'; //The IP for the datebase server
	$_CONFIG['ANPR']['Port'] = '3306'; //The username for the database server
	$_CONFIG['ANPR']['User'] = 'root'; //The username for the database server
	$_CONFIG['ANPR']['Pass'] = ''; //The password for the datebase server
	$_CONFIG['ANPR']['DB'] = 'rev_anpr'; //Select the database you want to connect too
	//ETP API Settings
	$_CONFIG['ETP']['API'] = array('api_uri' => 'https://api.etpcp.com/trx/',
											 'api_user' => 'sm394_34lll2345Ae',
											 'api_pass' => 'P2002laeif[3234JklmNo1A@344_12Qq',
									 		 'site_user' => 'holyhead',
									 		 'site_pass' => '2hst36sg');

	// Portal API
	$_CONFIG['Portal']['URL'] = 'https://portal.roadkingtruckstop.co.uk/api/';
	// PM API Settings
	$_CONFIG['api']['accesskey'] = 'el8565!kt'; //Site ID Number
	$_CONFIG['api']['ver'] = '1.0.6'; // API Version
	// Settings
	$_CONFIG['api']['site'] = '201908291533552768'; //Site Identity Number
	$_CONFIG['api']['wifi_tariff'] = '201909012036451675'; //Site ID Number
	$_CONFIG['api']['changeover_tariff'] = '201909012036457723'; //Site ID Number
?>
