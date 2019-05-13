<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "User.Login") {
    $user->Login($_POST['Login_Email'], $_POST['Login_Password']);
  }

?>
