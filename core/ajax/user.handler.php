<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "User.Login") {
    $user->Login($_POST['Login_Email'], $_POST['Login_Password']);
  } else if($handler == "User.Register") {
    $user->Register(array('FirstName' => $_POST['FirstName'], 'LastName' => $_POST['LastName'], 'Email' => $_POST['EmailAddress'], 'Password' => $_POST['Password'], 'ConfPassword' => $_POST['ConfirmPassword'], 'Site' => $_POST['Site'], 'ANPR' => $_POST['ANPR'], 'Rank' => $_POST['Rank'],'Printer' => $_POST['Printer'], 'Status' => $_POST['Status']));
  } else if($handler == "User.Update_GET") {
    $user->Update_GET($_POST['Ref']);
  } else if($handler == "User.Update") {
    $user->Update(array('Ref' => $_POST['User_Ref'], 'FirstName' => $_POST['User_FirstName'], 'LastName' => $_POST['User_LastName'], 'Email' => $_POST['User_Email'], 'Site' => $_POST['User_Site'], 'ANPR' => $_POST['User_ANPR'], 'Rank' => $_POST['User_Rank'],'Printer' => $_POST['User_Printer'], 'Status' => $_POST['User_Status']));
  } else if($handler == "User.UpdatePW") {
    $user->UpdatePW($_POST['Ref'], $_POST['Password'], $_POST['ConfirmPassword']);
  } else if($handler == "User.Logout") {
    $user->Logout();
  }

?>
