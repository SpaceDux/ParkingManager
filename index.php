<?php

	if (!isset($_GET['page'])) {
		header("Location: index");
	}

	if($_GET['page'] != "index" AND !isset($_SESSION['ID'])) {
		header("Location: index");
	} else if ($_GET['page'] == "index" AND isset($_SESSION['ID'])) {
		header("Location: home");
	}
	require 'global.php';

	$template->Show($template->SetParams());
?>
