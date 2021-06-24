<?php
  require($_SERVER['DOCUMENT_ROOT']."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "User.User_Registration") {
    $user->User_Registration(htmlspecialchars($_POST['Join_FirstName']), htmlspecialchars($_POST['Join_LastName']), htmlspecialchars($_POST['Join_Email']), htmlspecialchars($_POST['Join_Password']), htmlspecialchars($_POST['Join_ConPassword']), htmlspecialchars($_POST['Join_Telephone']), htmlspecialchars($_POST['Join_Plate']));
  } else if($handler == "User.User_Login") {
    $user->User_Login(htmlspecialchars($_POST['Email']), htmlspecialchars($_POST['Password']));
  } else if($handler == "User.User_Update") {
    $user->User_Info_Update(htmlspecialchars($_POST['First']), htmlspecialchars($_POST['Last']), htmlspecialchars($_POST['Email']), htmlspecialchars($_POST['Telephone']), htmlspecialchars($_POST['Password']));
  } else if($handler == "User.User_ChangePassword") {
    $user->User_ChangePassword(htmlspecialchars($_POST['Current_Password']), htmlspecialchars($_POST['New_Password']), htmlspecialchars($_POST['Con_New_Password']));
  } else if($handler == "User.User_ForgottenPassword_Start") {
    $user->User_ForgottenPassword_Start(htmlspecialchars($_POST['Email']));
  } else if($handler == "User.User_ForgottenPassword_Code") {
    $user->User_ForgottenPassword_Code(htmlspecialchars($_POST['Code']));
  } else if($handler == "User.User_ForgottenPassword_Change") {
    $user->User_ForgottenPassword_Change(htmlspecialchars($_POST['Code']), htmlspecialchars($_POST['Pass1']), htmlspecialchars($_POST['Pass2']));
  }
?>
