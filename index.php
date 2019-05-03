<?php
require 'global.php';

	$template->Show($template->SetParams());

	if (!isset($_GET['page'])) {
		header("Location: /index");
	}

	// $user->Logout();
?>
