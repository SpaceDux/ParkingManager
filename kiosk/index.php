<?php
  require("..\global.php");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ROADKING KIOSK</title>
    <link rel="stylesheet" href="<?php echo URL ?>/kiosk/style.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <div class="TopBar">
      <div class="Time">
        <i style="padding-right: 10px;" class="fa fa-clock"></i> 21/02/19 21:22
      </div>
      <div class="WhereAmI">
        <i style="padding-right: 10px;" class="fa fa-location-arrow"></i> You are parked at Roadking: Holyhead
      </div>
    </div>
    <div class="Logo">
      <img src="<?php echo URL ?>/kiosk/roadkinglogo.png" alt="">
    </div>
    <div class="Wrapper">
      <div class="WhereToBegin">
        Welcome to RoadKing... Please choose a service to begin
      </div>
      <div class="BoxSelection blue">
        <img src="<?php echo URL ?>/kiosk/parking_icon.png" alt="">
        <div class="Title">
          Pay for Parking
        </div>
        <div class="Body">
          Pay for your Parking here... We accept SNAP & Fuel Card!
        </div>
      </div>
      <div class="BoxSelection green">
        <img src="<?php echo URL ?>/kiosk/truckwash_icon.png" alt="">
        <div class="Title">
          Truck Wash
        </div>
        <div class="Body">
          Purchase wash tokens for our truckwash from this kiosk!
        </div>
      </div>
      <div class="BoxSelection red">
        <img src="<?php echo URL ?>/kiosk/change_convert.png" alt="">
        <div class="Title">
          Exchange
        </div>
        <div class="Body">
          Swap your *££* notes for coins for our laundrette.
        </div>
      </div>
    </div>
  </body>
</html>
