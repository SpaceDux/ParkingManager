<?php
  require($_SERVER['DOCUMENT_ROOT']."/portal/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "User.User_Registration") {
    $user->User_Registration(htmlspecialchars($_POST['Join_FirstName']), htmlspecialchars($_POST['Join_LastName']), htmlspecialchars($_POST['Join_Email']), htmlspecialchars($_POST['Join_Password']), htmlspecialchars($_POST['Join_ConPassword']), htmlspecialchars($_POST['Join_Telephone']));
  } else if($handler == "User.User_Login") {
    $user->User_Login(htmlspecialchars($_POST['Email']), htmlspecialchars($_POST['Password']));
  } else if($handler == "User.User_Update") {
    $user->User_Info_Update(htmlspecialchars($_POST['First']), htmlspecialchars($_POST['Last']), htmlspecialchars($_POST['Email']), htmlspecialchars($_POST['Telephone']), htmlspecialchars($_POST['Password']));
  }
?>
