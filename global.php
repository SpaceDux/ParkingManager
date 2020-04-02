<?php

	//Required Files
	date_default_timezone_set('Europe/London');
	// Other Activations
	session_start();
	error_reporting(E_ALL);

	//Config
	require_once(__DIR__.'/core/manage/config.php');

	//Class Files
	require_once(__DIR__.'/core/class/template.class.php');
	require_once(__DIR__.'/core/class/mysql.class.php');
	require_once(__DIR__.'/core/class/user.class.php');
	require_once(__DIR__.'/core/class/mailer.class.php');
	require_once(__DIR__.'/core/class/vehicles.class.php');
	require_once(__DIR__.'/core/class/booking.class.php');
	require_once(__DIR__.'/core/class/pm.class.php');


	// Composer
	require_once(__DIR__.'/vendor/autoload.php');

	//Begin Activating the Engine
	use ParkingManager as PM;


	// Only activate Fenrir IF page = "index.php" in root
	if(basename($_SERVER['PHP_SELF']) == "index.php") {
		//Template System Information
		$tplDes = $_CONFIG['site']['template'];
		$tplPg = $_GET['page'];
		define ('TEMPLATE_PATH', 'template/'.$tplDes);
		define ('TEMPLATE_PAGE', '/'.$tplPg.'.php');
		$template = new PM\Template(TEMPLATE_PATH.TEMPLATE_PAGE);
	}

	$user = new PM\User;
	$vehicles = new PM\Vehicles;
	$booking = new PM\Booking;
	$mailer = new PM\Mailer;
	$pm = new PM\PM;
?>
