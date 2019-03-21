<?php
  require("..\global.php");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>KIOSK</title>
    <link rel="stylesheet" href="<?php echo URL?>/kiosk/style.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/jquery.ml-keyboard.css">
  </head>
  <body>
    <div class="TopBar">
      <div class="WhereAmI">
        <i class="fa fa-location-arrow"></i>
         You have parked at RoadKing: Parc Cybi
      </div>
      <div class="Time" id="Time">
        <i class="fa fa-clock"></i>
         <?php echo date("d/m/Y H:i") ?>
      </div>
    </div>
    <div class="Wrapper" id="Tiles">
      <div class="Tiles Blue" id="Parking_Tile">
        <img src="<?php echo URL?>/kiosk/parking_icon.png" alt="">
        <p>Pay for your HGV Parking here, with Cash, Card, SNAP & Fuel Cards + RK Accounts</p>
      </div>
      <div class="Tiles Green" id="Wash_Tile">
        <img src="<?php echo URL?>/kiosk/truckwash_icon.png" alt="">
        <p>Purchase your truckwash tokens from this machine, we accept, Cash, Card & Fuel Cards.</p>
      </div>
      <div class="Tiles Red" id="Exchange_Tile">
        <img src="<?php echo URL?>/kiosk/change_convert.png" alt="">
        <p>Convert your sterling *£* notes to coins for our Coin Op laundrette.</p>
      </div>
    </div>
    <div class="Wrapper" id="Parking_Page">
      <div id="Stage1" class="Hide">
        <input type="text" name="Kiosk_Plate_Search" id="Kiosk_Plate" class="Kiosk_Plate_Input" maxlength="15" placeholder="CY14CVC"/>
      </div>
    </div>
    <script src="<?php echo URL ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/jquery.ml-keyboard.min.js"></script>
    <?php require("..\core\ajax-js\kiosk.js.php");?>
  </body>
</html>
