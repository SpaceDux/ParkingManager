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
    $System = $_POST['System'];
    $Ref = $_POST['Ref'];
    $Method = $_POST['Method'];
    $Tariff = $_CONFIG['api']['changeover_tariff'];

    if(isset($_POST['Name'])) {
      $Name = $_POST['Name'];
    } else {
      $Name = ' ';
    }
    if(isset($_POST['Trailer'])) {
      $Trailer = $_POST['Trailer'];
    } else {
      $Trailer = '';
    }
    if(isset($_POST['Note'])) {
      $Note = $_POST['Note'];
    } else {
      $Note = '';
    }
    if(isset($_POST['FuelStr'])) {
      $FuelStr = $_POST['FuelStr'];
    } else {
      $FuelStr = '';
    }

    if(isset($System) AND isset($Ref) AND isset($Method) AND isset($Tariff))
    {
      $transaction->AddTransaction($System, $Ref, $Method, $Tariff, $Trailer, $Name, "1", $FuelStr, $Note);
    }
    else
    {
      echo json_encode(array("Status" => '102', "Message" => 'Please ensure all required data is present.'));
    }
  } else {
    echo json_encode(array("Status" => '103', "Message" => 'Access denied, Key does not exist.'));
  }
?>
