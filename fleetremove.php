<?php
  require_once __DIR__.'/init.php'; //require init file

  $id = $_GET['id'];
  $sql = "DELETE FROM trucks WHERE id = $id";
  $stmt = $dbConn->prepare($sql);

  if ($stmt->execute() === true) {
    header('Location:'.$url.'/account_list.php');
  } else {
    die("IT DIDNT WORK"); //This shouldn't ever happen!
  }

?>
