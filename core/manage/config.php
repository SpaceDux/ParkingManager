<?php
// Configuration file for ParkingManager 4
//ParkingManager - Author: Ryan Williams
//Fenrir - Author: Ryan Williams

	//Server configuration (MySQL Connection)
	$_CONFIG['mysql']['host'] = 'localhost'; //The IP for the datebase server
	$_CONFIG['mysql']['port'] = '3306'; //The username for the database server
	$_CONFIG['mysql']['user'] = 'root'; //The username for the database server
	$_CONFIG['mysql']['pass'] = ''; //The password for the datebase server
	$_CONFIG['mysql']['db'] = 'parking_manager'; //Select the database you want to connect too

	// Site Configuration
	$_CONFIG['site']['url'] = 'http://localhost/ParkingManager'; //Server URL example.com (DOES NOT END WITH /)
	$_CONFIG['site']['name'] = 'ParkingManager'; //Website name, {SITE_NAME}
	$_CONFIG['site']['template'] = 'Vision'; //Fenrir Template System, Select the Template Directory

	//ETP API Settings
	$_CONFIG['etp_api']['base_uri'] = "https://api.etpcp.com/trx/";
	//Holyhead
	$_CONFIG['etp_api']['user'] = "sm394_34lll2345Ae";
	$_CONFIG['etp_api']['pass'] = "P2002laeif[3234JklmNo1A@344_12Qq";

	$_CONFIG['etp_api']['location_user-holyhead'] = "holyhead";
	$_CONFIG['etp_api']['location_pass-holyhead'] = "2hst36sg";
	//Cannock
	$_CONFIG['etp_api']['location_user-cannock'] = "hollies";
	$_CONFIG['etp_api']['location_pass-cannock'] = "hollies";
	// Misc
	$_CONFIG['misc']['copy'] = 'ParkingManager 4 | Copyright &copy; 2019 Roadking Truckstops'; //Fenrir Template System, Select the Template Directory
?>
