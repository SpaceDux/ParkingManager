<?php
	require_once __DIR__.'/init.php'; //require this init file
	$col = $_GET['col'];
	$id = $_GET['id'];
	
	if(isset($col)) {
		$sql = "UPDATE parking SET h_light = :col WHERE id = :id";
		$stmt = $dbConn->prepare($sql);
		$stmt->BindParam(':col', $col);
		$stmt->BindParam(':id', $id);
		
	  if ($stmt->execute()) {
	    header('Location:'.$url.'/index.php');
	  } else {
	    die("IT DIDNT WORK"); //This shouldn't ever happen!
	  }
	}
		
?>