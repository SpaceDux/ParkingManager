<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once($_SERVER['DOCUMENT_ROOT'].'/global.php');

$accesskey = $_CONFIG['API']['AccessKey'];

if(!isset($_POST['AccessKey'])) {
  $_POST['AccessKey'] = "";
}
if(!isset($_POST['Name'])) {
  $_POST['Name'] = '';
}
if(!isset($_POST['Temp'])) {
  $_POST['Temp'] = '';
}
if(!isset($_POST['Status'])) {
  $_POST['Status'] = '';
}

if($accesskey == $_POST['AccessKey'])
{
  if(isset($_POST['Username'], $_POST['Password'], $_POST['Bay'])) {
    $pm->PM_UpdateBay_API($_POST['Username'], $_POST['Password'], $_POST['Bay'], $_POST['Name'], $_POST['Temp'], $_POST['Status']);
  } else {
    echo json_encode(array("Status" => '0', "Message" => 'Missing data, please ensure all data is supplied.'));
  }
} else {
  echo json_encode(array("Status" => '0', "Message" => 'Access denied, Key does not exist.'));
}
?>
