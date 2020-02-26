<?php
  require(__DIR__."\..\../global.php");
  $handler = isset($_GET['handler'])?$_GET['handler']:'';

  if($handler == "Booking.Booking_AllocateBayTemp") {
    $booking->Booking_AllocateBayTemp($_POST['Site']);
  } else if($handler == "Booking.Booking_Create_Booking") {
    $booking->Booking_Create_Booking($_POST['Vehicle'], $_POST['Type'], $_POST['ETA'], $_POST['Break']);
  }
?>
