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

  if($accesskey == $_POST['AccessKey']) {
    if(isset($_POST['Expiry']) AND isset($_POST['VehicleType']) AND isset($_POST['Method']))
    {
      $transaction->GetTariffs($_POST['VehicleType'], $_POST['Expiry'], $_POST['Method']);
    }
    else
    {
      echo json_encode(array("Status" => '102', "Message" => 'Please ensure all required data is present.'));
    }
  } else {
    echo json_encode(array("Status" => '103', "Message" => 'Access denied, Key does not exist.'));
  }
?>
