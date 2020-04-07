<?php
	require 'global.php';

	if($_CONFIG['site']['maintenance'] == false) {
		if (!isset($_GET['page'])) {
			header("Location: index");
		}

		if($_GET['page'] != "index" AND !isset($_SESSION['ID'])) {
			header("Location: index");
		} else if ($_GET['page'] == "index" AND isset($_SESSION['ID'])) {
			header("Location: home");
		} else if($_GET['page'] == "maintenance") {
			header("Location: home");
		}
	} else {
		if (!isset($_GET['page'])) {
			header("Location: index");
		}
		if($_GET['page'] != "maintenance") {
			header("Location: maintenance");
		}
	}

	$template->Show($template->SetParams());
?>
