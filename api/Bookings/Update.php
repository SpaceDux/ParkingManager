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
if(!isset($_POST['ETA'])) {
  $_POST['ETA'] = null;
}
if(!isset($_POST['Status'])) {
  $_POST['Status'] = null;
}
if(!isset($_POST['VehicleType'])) {
  $_POST['VehicleType'] = null;
}
if(!isset($_POST['Company'])) {
  $_POST['Company'] = '';
}
if(!isset($_POST['Note'])) {
  $_POST['Note'] = '';
}


if($accesskey == $_POST['AccessKey'])
{
  if(isset($_POST['Username']) AND isset($_POST['Password']) AND isset($_POST['Ref'])) {
    $booking->Booking_UpdateBooking_API($_POST['Username'], $_POST['Password'], $_POST['Ref'], $_POST['ETA'], $_POST['Status'], $_POST['VehicleType'], $_POST['Company'], $_POST['Note']);
  } else {
    echo json_encode(array("Status" => '0', "Message" => 'Missing data, please ensure all data is supplied.'));
  }
} else {
  echo json_encode(array("Status" => '0', "Message" => 'Access denied, Key does not exist.'));
}
?>
