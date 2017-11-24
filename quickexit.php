<?php
  require_once __DIR__.'/init.php'; //require init file

  $id = $_GET['id'];
  $sql = "UPDATE parking SET timeout = :timeout, col = '3' WHERE id = $id";
  $stmt = $dbConn->prepare($sql);
  $stmt->bindParam(':timeout', date("Y-m-d H:i:00"));

  if ($stmt->execute()) {
    header('Location:'.$url.'/index.php');
  } else {
    die("IT DIDNT WORK"); //This shouldn't ever happen!
  }

?>
