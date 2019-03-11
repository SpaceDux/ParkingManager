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
        <i style="padding-right: 10px;" class="fa fa-location-arrow"></i> You are parked at RoadKing: Holyhead
      </div>
    </div>
    <div class="Wrapper" id="Wrapper">
      <div class="BoxSelection blue" id="Parking_Tile">
        <img src="<?php echo URL ?>/kiosk/parking_icon.png" alt="">
        <div class="Title">
          Pay for Parking
        </div>
        <div class="Body">
          Pay for your Parking here... We accept Cash, Card, SNAP & Fuel Card + Accounts!
        </div>
      </div>
      <div class="BoxSelection green" id="Wash_Tile">
        <img src="<?php echo URL ?>/kiosk/truckwash_icon.png" alt="">
        <div class="Title">
          Truck Wash Tokens
        </div>
        <div class="Body">
          Purchase wash tokens for our truckwash from this kiosk!
        </div>
      </div>
      <div class="BoxSelection red" id="Exchange_Tile">
        <img src="<?php echo URL ?>/kiosk/change_convert.png" alt="">
        <div class="Title">
          Exchange
        </div>
        <div class="Body">
          Swap your *££* notes for coins to use in our laundrette.
        </div>
      </div>
    </div>
    <div id="Page">
      
    </div>
    <script src="<?php echo URL ?>/assets/js/jquery.min.js"></script>
    <script type="text/javascript">
    //Parking
    $(document).on('click', '#Parking_Tile', function() {
      $('#Wrapper').addClass("Hide");
      $.ajax({
        url: "<?php echo URL?>/core/ajax/kiosk.ajax.php?handler=Kiosk_ParkingPage",
        type: "POST",
        success:function(data) {
          $('#Page').html(data);
        }
      })
    });
    //Wash
    $(document).on('click', '#Wash_Tile', function() {
      alert("YOU CLICKED WASH");
    });
    //Exchange
    $(document).on('click', '#Exchange_Tile', function() {
      alert("YOU CLICKED EXCHANGE");
    });
    </script>

  </body>
</html>
