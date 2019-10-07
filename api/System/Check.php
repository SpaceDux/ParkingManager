<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  // Require Classes
  require '../global.php';

  $accesskey = $_CONFIG['api']['accesskey'];
  if(!isset($_POST['AccessKey'])) {
    $_POST['AccessKey'] == "";
  }


  if($accesskey == $_POST['AccessKey'])
  {
    $Check = $checks->Check_On_SNAP("TEST");
    if($Check !== 0) {
      echo json_encode(array("Status" => '101', "Message" => 'System Running Correctly'));
    } else {
      echo json_encode(array("Status" => '105', "Message" => 'System Error, ETP not available! (SNAP+FUEL CARDS)'));
    }
  } else {
    echo json_encode(array("Status" => '103', "Message" => 'Access denied, Key does not exist.'));
  }
?>
