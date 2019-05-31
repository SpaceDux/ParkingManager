<?php

//Required Files

	//Config
	require_once(__DIR__.'/core/manage/config.php');

	//Class Files
	require_once(__DIR__.'/core/class/template.class.php');
	require_once(__DIR__.'/core/class/mysql.class.php');
	require_once(__DIR__.'/core/class/user.class.php');
	require_once(__DIR__.'/core/class/pm.class.php');


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

	$user = new PM\User();
	$pm = new PM\PM();

	//Other Activating
	session_start();
?>
