<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "User.User_Registration") {
    $user->User_Registration(htmlspecialchars($_POST['Join_FirstName']), htmlspecialchars($_POST['Join_LastName']), htmlspecialchars($_POST['Join_Email']), htmlspecialchars($_POST['Join_Password']), htmlspecialchars($_POST['Join_ConPassword']), htmlspecialchars($_POST['Join_Telephone']));
  }

?>
