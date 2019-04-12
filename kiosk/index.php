<?php
  require("..\global.php");
  require("config.php");
  if(!isset($_SESSION['id'])) {
    $user->Login($user_config['User'], $user_config['Pass']);
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>KIOSK</title>
    <link rel="stylesheet" href="<?php echo URL ?>/kiosk/style.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/jqbtk.min.css">
  </head>
  <body>
    <div class="TopBar">
      <div class="WhereAmI">
        <i class="fa fa-location-arrow"></i>
         Welcome to RoadKing: Parc Cybi
      </div>
      <div class="Time" id="Time">
        <i class="fa fa-clock"></i>
         <?php echo date("d/m/Y H:i") ?>
      </div>
    </div>
    <!-- Begin Kiosk -->
    <div class="Wrapper" id="Language_Select">
      <div class="Title">
        Please choose your preferred language...
      </div>
      <div class="Small_Tiles" id="English">
        <div class="Box">
          <img src="<?php echo URL ?>/kiosk/english.png" alt="">
        </div>
      </div>
      <!-- <div class="Small_Tiles" id="Polish">
        <div class="Box">
          <img src="<?php echo URL ?>/kiosk/polish.png" alt="">
        </div>
      </div> -->
    </div>
    <!-- English -->
    <div class="Wrapper Hide" id="Tiles_EN">
      <div class="Tiles Blue" id="Parking_Tile_EN">
        <img src="<?php echo URL?>/kiosk/parking_icon.png" alt="">
        <p>Pay for your HGV Parking here, with Cash, Card, SNAP & Fuel Cards + RK Accounts</p>
      </div>
      <!-- <div class="Tiles Green" id="Wash_Tile_EN">
        <img src="<?php echo URL?>/kiosk/truckwash_icon.png" alt="">
        <p>Purchase your truckwash tokens from this machine, we accept, Cash, Card & Fuel Cards.</p>
      </div>
      <div class="Tiles Red" id="Exchange_Tile_EN">
        <img src="<?php echo URL?>/kiosk/change_convert.png" alt="">
        <p>Convert your sterling *£* notes to coins for our Coin Op laundrette.</p>
      </div> -->
    </div>
    <div id="Page_EN">
      <div class="Wrapper Hide" id="Parking_Page_EN">
        <!-- Form -->
        <form id="Parking_Form_EN">
          <!-- Stage 1 -->
          <!--
            Stage 1 will consist of 2 checks.
            One; Has this vehicle already been charged, and has he already had his ticket
            dispensed.

            Two; Is this vehicle due another payment (Renewal ETC)

            (Pos)Three; Is this vehicle still in the ANPR, if so begin new transaction.
          -->
          <div id="Stage1_EN" class="Hide">
            <div class="Box">
              <div class="Title">
              Please enter your vehicle registration...
              </div>
              <input type="text" name="Kiosk_Plate" id="Kiosk_Plate" class="keyboard Kiosk_Plate_Input" maxlength="16" placeholder="YOUR REG" autocomplete="off"/>
              <input type="hidden" name="Kiosk_System" id="Kiosk_System" autocomplete="off"/>
              <input type="hidden" name="Kiosk_ID" id="Kiosk_ID" autocomplete="off"/>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S1_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S1_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 2 -->
          <!--
            Stage 2 will consist of 1 checks
            One; The type of Vehicle.
          -->
          <div id="Stage2_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                Please choose the type of vehicle you're paying for...
              </div>
              <div class="Radios">
                <div class="Label">
                  Cab & Trailer
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="CT" value="1" checked>
                  <label for="CT"><img src="<?php echo URL ?>/kiosk/ct.png"></img></label>
                </div>
                <div class="Label">
                  Cab Only
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="Cab" value="2">
                  <label for="Cab"><img src="<?php echo URL ?>/kiosk/cab_only.png"></img></label>
                </div>
                <div class="Label">
                  Trailer Only
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="Trl" value="3">
                  <label for="Trl"><img src="<?php echo URL ?>/kiosk/trl.png"></img></label>
                </div>
                <div class="Label">
                  Rigid
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="Rigid" value="4">
                  <label for="Rigid"><img src="<?php echo URL ?>/kiosk/rigid.png"></img></label>
                </div>
                <div class="Label">
                  Coach
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="Coach" value="5">
                  <label for="Coach"><img src="<?php echo URL ?>/kiosk/coach.png"></img></label>
                </div>
                <div class="Label">
                  Car Transporter
                  <input type="radio" class="RadioButton" name="Kiosk_Type" id="CTR" value="8">
                  <label for="CTR"><img src="<?php echo URL ?>/kiosk/ctr.png"></img></label>
                </div>
              </div>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S2_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S2_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 3 -->
          <!--
            Stage 3 will consist of 1 check
            One; Determine how long the driver would like to stay.
          -->
          <div id="Stage3_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                How long would you like to park for?...
              </div>
              <div class="Services">
                <input type="radio" class="Kiosk_Expiry" name="Kiosk_Expiry" id="Kiosk_Expiry_1" value="24" checked>
                <label for="Kiosk_Expiry_1">24hr Parking</label>
              </div>
              <div class="Services">
                <input type="radio" class="Kiosk_Expiry" name="Kiosk_Expiry" id="Kiosk_Expiry_2" value="48">
                <label for="Kiosk_Expiry_2">48hr Parking</label>
              </div>
              <div class="Services">
                <input type="radio" class="Kiosk_Expiry" name="Kiosk_Expiry" id="Kiosk_Expiry_3" value="72">
                <label for="Kiosk_Expiry_3">72hr Parking</label>
              </div>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S3_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S3_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 4 -->
          <!--
            Stage 4 is the payment options.
            It also runs a check to see whether,
          -->
          <div id="Stage4_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                How would you like to pay?...
              </div>
              <div id="Payment_Types_EN">

              </div>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S4_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S4_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 5 -->
          <!--
            Stage 5 will contain the payment services
          -->
          <div id="Stage5_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                Please choose one of the following services...
              </div>
              <div id="Payment_Services_EN">
              <!-- <div class="Services">
                <input type="radio" name="Kiosk_Service" id="Kiosk_Service_1" value="1" checked>
                <label for="Kiosk_Service_1">24hr C/T Parking - £18</label>
              </div>
              <div class="Services">
                <input type="radio" name="Kiosk_Service" id="Kiosk_Service_2" value="2">
                <label for="Kiosk_Service_2">24hr C/T Parking with Meal - £24</label>
              </div> -->
              </div>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S5_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S5_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 6 -->
          <!--
            Stage 6 will be the function taking the payment.
          -->
          <div id="Stage6_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                Please confirm your vehicle information to begin payment.
              </div>

            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S6_EN">
                  CANCEL
                </div>
                <div class="Button Green" id="Next_Parking_S6_EN">
                  NEXT
                </div>
              </div>
            </div>
          </div>
          <!-- Stage 7 -->
          <!--
            Stage 6 will be the function taking the payment.
          -->
          <div id="Stage7_EN" class="Hide">
            <div class="Box">
              <div class="Title">
                You have already been charged, and are not due to renew for 6 hours and 12 minutes
              </div>
              <div class="Results">
                Please choose one of the following options.
              </div>
              <div class="Box">
                <div class="Button Green" id="sss">
                  PRINT TICKET
                </div>
                <div class="Button Green" id="zzzz">
                  NEW TRANSACTION
                </div>
              </div>
            </div>
            <!-- Buttons -->
            <div class="BottomWrapper">
              <div class="Box">
                <div class="Button Red" id="Cancel_Parking_S7_EN">
                  CANCEL
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script>
        $(document).ready(function() {
            $("label img").on("click", function() {
                $("#" + $(this).parents("label").attr("for")).click();
            });
        });
    </script>
    <script src="<?php echo URL ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/jqbtk.min.js"></script>
    <?php require("..\core\ajax-js\kiosk.js.php");?>
  </body>
</html>
