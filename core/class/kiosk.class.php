<?php
  namespace ParkingManager;
  class Kiosk {
    //Return the Parking Page with relevant form
    function GetParkingPage() {
      $html = '';

      $html .= '<div class="content">';
        //Stage 1
        $html .= '<div class="page_content" id="Stage1">';
          $html .= '   <input type="text" name="Kiosk_Plate_Search" id="Kiosk_Plate_Search" class="licenseplate" maxlength="13" placeholder="AB 1234" autofocus/>';
        $html .= '</div>';
      $html .= '</div>';

      echo $html;
    }
  }
?>
