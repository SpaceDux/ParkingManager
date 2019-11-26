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
    if(!isset($_POST['Note'])) {
      $_POST['Note'] = '';
    }
    if(isset($_POST['Method']) AND isset($_POST['Note'])) {
      if($_POST['Method'] < 3) {
        $transaction->Wifi_Transaction($_POST['Method'], $_POST['Note']);
      } else {
        echo json_encode(array("Status" => '103', "Message" => 'This service is available for Cash or Card only.'));
      }
    } else {
      echo json_encode(array("Status" => '102', "Message" => 'Please ensure all required data is present.'));
    }
  } else {
    echo json_encode(array("Status" => '103', "Message" => 'Access denied, Key does not exist.'));
  }
?>
