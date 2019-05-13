<?php
require 'global.php';

	if (!isset($_GET['page'])) {
		header("Location: index");
	}

	if($_GET['page'] != "index" AND !isset($_SESSION['id'])) {
		header("Location: index");
	} else if ($_GET['page'] == "index" AND isset($_SESSION['id'])) {
		header("Location: main");
	}

	// $user->Logout();

	$template->Show($template->SetParams());
?>
