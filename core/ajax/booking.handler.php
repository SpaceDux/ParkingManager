<?php
  require($_SERVER['DOCUMENT_ROOT']."/global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Booking.Booking_AllocateBayTemp") {
    $booking->Booking_AllocateBayTemp($_POST['Site']);
  } else if($handler == "Booking.Booking_Create_Booking") {
    $booking->Booking_Create_Booking($_POST['Vehicle'], $_POST['Type'], $_POST['ETA'], $_POST['Break'], $_POST['Company']);
  } else if($handler == "Booking.Booking_CancelBooking") {
    $booking->Booking_CancelBooking($_POST['Ref']);
  } else if($handler == "Booking.Booking_MidwayCancel") {
    $booking->Booking_MidwayCancel();
  } else if($handler == "Booking.ModifyBooking") {
    $booking->Booking_Modify($_POST['Ref'], $_POST['ETA'], $_POST['VehicleType']);
  }
?>
