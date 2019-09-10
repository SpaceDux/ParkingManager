<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  // Require Classes
  require '../global.php';

  if(isset($_POST['Plate']) AND isset($_POST['Site']))
  {
    $vehicles->Initial_Search($_POST['Plate'], $_POST['Site']);
  }
  else
  {
    echo json_encode(array("Status" => '102', "Message" => 'Please ensure all required data is present.'));
  }
?>
