<?php
  require_once __DIR__.'/init.php'; //require init file

  $id = $_GET['id'];
  $sql = "UPDATE parking SET col = '4' WHERE id = $id";
  $stmt = $dbConn->prepare($sql);

  if ($stmt->execute()) {
    header('Location:'.$url.'/index.php');
  } else {
    die("IT DIDNT WORK"); //This shouldn't ever happen!
  }

?>
