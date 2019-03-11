<?php
  namespace ParkingManager;
  use Mike42\Escpos\Printer;
  use Mike42\Escpos\EscposImage;
  use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

  class Ticket {
    //Print Columns on ticket.
    function Printer_Columns($leftCol, $rightCol, $leftWidth, $rightWidth, $space = 0){
      $leftWrapped = wordwrap($leftCol, $leftWidth, "\n", true);
      $rightWrapped = wordwrap($rightCol, $rightWidth, "\n", true);

      $leftLines = explode("\n", $leftWrapped);
      $rightLines = explode("\n", $rightWrapped);
      $allLines = array();
      for ($i = 0; $i < max(count($leftLines), count($rightLines)); $i ++) {
        $leftPart = str_pad(isset($leftLines[$i]) ? $leftLines[$i] : "", $leftWidth, " ");
        $rightPart = str_pad(isset($rightLines[$i]) ? $rightLines[$i] : "", $rightWidth, " ");
        $allLines[] = $leftPart . str_repeat(" ", $space) . $rightPart;
      }
      return implode($allLines, "\n") . "\n";
    }
    //Determine Ticket
    function Direction($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $group, $exitKey, $discount_count, $wifi_count) {
      if($group == 1) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count);
      } else if ($group == 2) {
        $this->Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type);
      } else if ($group == 3) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count);
      } else if ($group == 4) {
        $this->Printer_Misc($shower_count, $wifi_count, $tid);
      }
    }
    //Begin Tickets
    //Print parking ticket
    function Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      $printer_id = $this->user->userInfo("printer");
      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->PM_SiteInfo($campus, "site_vat");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Printer connection
      $connector = new WindowsPrintConnector('smb://'.$this->pm->PM_PrinterInfo($printer_id, "printer_user").':'.$this->pm->PM_PrinterInfo($printer_id, "printer_pass").'@'.$this->pm->PM_PrinterInfo($printer_id, "printer_ip").'/'.$this->pm->PM_PrinterInfo($printer_id, "printer_sharedname").'');
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);
      $address = EscposImage::load($img_dir."/address.png", false);
      $shower_img = EscposImage::load($img_dir."/shower.jpg", false);
      $meal_img = EscposImage::load($img_dir."/meal4.jpg", false);
      $discount_img = EscposImage::load($img_dir."/discount.jpg", false);
      $date = date("d/m/Y H:i", strtotime($date));
      $expiry = date("d/m/Y H:i", strtotime($expiry));

      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);

      //Sorting column data
      $line_one = $this->Printer_Columns("Company: ".strtoupper($company), "Reg: ".strtoupper($reg), 18, 24, 2);
      $line_two = $this->Printer_Columns("ID: ".$tid, "Date: ".$date, 18, 24, 2);
      $line_info = $this->Printer_Columns("Reg: ".strtoupper($reg), "Exp: ".$expiry, 18, 24, 2);
      //Begin print
      //Ticket Code
      try {
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
    		if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    			$printer -> graphics($logo);
    		} else {
    			$printer -> bitImage($logo);
          if($payment_type == "Cash" || $payment_type == "Card") {
            $printer -> pulse(0, 120, 240);
          }
    		}
        $printer -> feed();
        // Name of Ticket
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> setTextSize(2, 2);
        $printer -> setFont(Printer::FONT_A);
        $printer -> text(strtoupper($ticket_name));
        $printer -> feed(2);
        $printer -> selectPrintMode();
        //Gross Price Value
        if($payment_type != "Account") {
          $printer -> setTextSize(2, 2);
          $printer -> text("£".$gross."\n");
          $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
          $printer -> setTextSize(1, 1);
          $printer -> feed();
          $printer -> text("VAT @ 20%: Net £".$net." - £".number_format($vat_pay, 2));
          $printer -> feed(2);
          $printer -> selectPrintMode();
        } else {
          //Ignore price

        }
        //Vehicle Details
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setTextSize(1, 1);
        $printer -> text($line_one);
        $printer -> text($line_two);
        //Ticket Dets
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        $printer -> text("Expiry Date: ".$expiry."\n");
        $printer -> text("Payment Type: ".$payment_type."\n");
        $printer -> feed(1);
        //Address Details
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setReverseColors(TRUE);
        $printer -> setTextSize(2, 2);
        $printer -> text(" Exit Code: *".$exitKey."# ");
        $printer -> setReverseColors(FALSE);
        $printer -> selectPrintMode();
        $printer -> feed(1);
    		if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    			$printer -> graphics($address);
    		} else {
    			$printer -> bitImage($address);
    		}
		    $printer -> feed(1);
        $printer -> text("VAT No: ".$vatnum);
        $printer -> feed(2);
        $printer -> text("Thank you for staying with us!\n");
        $printer -> text("www.rktruckstops.co.uk");
        $printer -> feed();
        $printer -> feed(1);
        //End Parking ticket
        $printer -> cut(Printer::CUT_PARTIAL);
        $i = 1;
        //Shower
        while ($i++ <= $shower_count) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
    			if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    				$printer -> graphics($shower_img);
    			} else {
    				$printer -> bitImage($shower_img);
    			}
          $printer -> text("\n".$line_info);
          $printer -> feed();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }
        $i = 1;
        //Meal
        while ($i++ <= $meal_count) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
    			if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    				$printer -> graphics($meal_img);
    			} else {
    				$printer -> bitImage($meal_img);
    			}
          $printer -> text("\n".$line_info);
          $printer -> setBarcodeHeight(42);
          $printer -> setBarcodeWidth(2);
          //£4 barcode
          $printer -> setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
          $printer -> barcode("635957959341", Printer::BARCODE_JAN13);
          $printer->selectPrintMode();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
    			if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    				$printer -> graphics($meal_img);
    			} else {
    				$printer -> bitImage($meal_img);
    			}
          $printer -> text("\n".$line_info);
          // $printer -> setBarcodeHeight(42);
          // $printer -> setBarcodeWidth(2);
          // //£4 barcode
          // $printer -> setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
          // $printer -> barcode("635957959341", Printer::BARCODE_JAN13);
          $printer->selectPrintMode();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }
        $i = 1;
        //Discount
        while ($i++ <= $discount_count) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
    			if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
    				$printer -> graphics($discount_img);
    			} else {
    				$printer -> bitImage($discount_img);
    			}
          $printer -> text("\n".$line_info);
          $printer -> text("\n MINIMUM SPEND £3");
          $printer -> feed();
          // $printer -> setBarcodeHeight(42);
          // $printer -> setBarcodeWidth(2);
          // //£2 barcode
          // $printer -> setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
          // $printer -> barcode("635957959321", Printer::BARCODE_JAN13);
          $printer->selectPrintMode();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }
      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
    }
    //Print Truckwash Ticket
    function Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      $printer_id = $this->user->userInfo("printer");

      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->PM_SiteInfo($campus, "site_vat");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);
      //Printer Connections
      $connector = new WindowsPrintConnector('smb://'.$this->pm->PM_PrinterInfo($printer_id, "printer_user").':'.$this->pm->PM_PrinterInfo($printer_id, "printer_pass").'@'.$this->pm->PM_PrinterInfo($printer_id, "printer_ip").'/'.$this->pm->PM_PrinterInfo($printer_id, "printer_sharedname").'');

      try {
        $printer = new Printer($connector);
        $ticket = EscposImage::load($img_dir."/wash.jpg", false);
        $date = date("d/m/Y H:i", strtotime($date));

        $line_one = $this->Printer_Columns("Company: ".$company, "Reg: ".$reg, 18, 24, 2);
        $line_two = $this->Printer_Columns("TID: ".$tid, "Date: ".$date, 18, 24, 2);

        // Name of Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
          $printer -> graphics($ticket);
        } else {
          $printer -> bitImage($ticket);
        }
        $printer -> feed();
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> setTextSize(2, 2);
        $printer -> setFont(Printer::FONT_A);
        $printer -> text(strtoupper($ticket_name));
        $printer -> feed(2);
        $printer -> selectPrintMode();
        //Gross Price Value
        $printer -> setTextSize(2, 2);
        $printer -> text("£".$gross."\n");
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        $printer -> feed();
        $printer -> text("VAT @ 20%: Net £".$net." - £".number_format($vat_pay, 2));
        $printer -> feed(2);
        //Vehicle Details
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setTextSize(1, 1);
        $printer -> text($line_one);
        $printer -> text($line_two);
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Payment Type: ".$payment_type."\n");
        $printer -> text("CUSTOMER COPY\n");
        $printer -> feed(2);
        //VAT info
        $printer -> text("VAT No: ".$vatnum);
        $printer -> feed(2);
        $printer -> text("Thank you for staying with us!\n");
        $printer -> text("www.rktruckstops.co.uk");
        $printer -> feed();
        $printer -> cut();
        //Merchant Copy
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if($this->pm->PM_PrinterInfo($printer_id, "printer_bitImage") == 0) {
          $printer -> graphics($ticket);
        } else {
          $printer -> bitImage($ticket);
        }
        $printer -> feed();
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> setTextSize(2, 2);
        $printer -> setFont(Printer::FONT_A);
        $printer -> text(strtoupper($ticket_name));
        $printer -> feed(2);
        $printer -> selectPrintMode();
        //Gross Price Value
        $printer -> setTextSize(2, 2);
        $printer -> text("£".$gross."\n");
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        $printer -> feed();
        $printer -> text("VAT @ 20%: Net £".$net." - £".number_format($vat_pay, 2));
        $printer -> feed(2);
        //Vehicle Details
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setTextSize(1, 1);
        $printer -> text($line_one);
        $printer -> text($line_two);
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Payment Type: ".$payment_type."\n");
        $printer -> text("MERCHANT COPY\n");
        $printer -> feed(2);
        //VAT info
        $printer -> text("VAT No: ".$vatnum);
        $printer -> feed(2);
        $printer -> text("Thank you for staying with us!\n");
        $printer -> text("www.rktruckstops.co.uk");
        $printer -> feed();
        $printer -> cut(Printer::CUT_PARTIAL);

      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
    }
    // Wifi & Shower
    function Printer_Misc($shower_count, $wifi_count, $tid) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      $printer_id = $this->user->userInfo("printer");

      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;

      try {
        //Printer Connection
        $connector = new WindowsPrintConnector('smb://'.$this->pm->PM_PrinterInfo($printer_id, "printer_user").':'.$this->pm->PM_PrinterInfo($printer_id, "printer_pass").'@'.$this->pm->PM_PrinterInfo($printer_id, "printer_ip").'/'.$this->pm->PM_PrinterInfo($printer_id, "printer_sharedname").'');

        $printer = new Printer($connector);
        $wifi = EscposImage::load($img_dir."/wifi.jpg", false);
        $shower  = EscposImage::load($img_dir."/shower.jpg", false);

        $i = 1;
        //WIFI
        while ($i++ <= $wifi_count) {
          // Generate Voucher
          $code = $this->pm->Create_WiFi_Voucher($campus);
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($this->pm->PM_PrinterInfo($printer_id, "printer_user") == 0) {
            $printer -> graphics($wifi);
          } else {
            $printer -> bitImage($wifi);
            if($payment_type == "Cash" || $payment_type == "Card") {
              $printer -> pulse(0, 120, 240);
            }
          }
          $printer -> setTextSize(2, 2);
          $printer -> text('WiFi Code: '.$code);
          $printer -> feed();
          $printer -> setTextSize(1, 1);
          $printer -> text("Please connect to; Parc-Cybi-Car-Park");
          $printer -> feed(1);
          $printer -> text("TID: ".$tid);
          $printer -> feed();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }

        $i = 1;
        //Shower
        while ($i++ <= $shower_count) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($campus == 1) {
            $printer -> graphics($shower);
          } else {
            $printer -> bitImage($shower);
          }
          $printer -> text("\n".$line_info);
          $printer -> feed();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }
      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
    }
    //End of day settlement
    function Printer_9PM($date1, $date2) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
      $printer_id = $this->user->userInfo("printer");
      if($campus == 2) {
        $date1 = date("Y-m-d 21:30:00", strtotime($date1));
        $date2 = date("Y-m-d 21:30:00", strtotime($date2));
      } else {
        $date1 = date("Y-m-d 21:00:00", strtotime($date1));
        $date2 = date("Y-m-d 21:00:00", strtotime($date2));
      }
      //Query
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ?");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $date1);
      $stmt->bindParam(3, $date2);
      $stmt->execute();

      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Printer Connection
      $connector = new WindowsPrintConnector('smb://'.$this->pm->PM_PrinterInfo($printer_id, "printer_user").':'.$this->pm->PM_PrinterInfo($printer_id, "printer_pass").'@'.$this->pm->PM_PrinterInfo($printer_id, "printer_ip").'/'.$this->pm->PM_PrinterInfo($printer_id, "printer_sharedname").'');
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);
      //Settlement
      $printer -> setJustification(Printer::JUSTIFY_CENTER);
      $printer -> graphics($logo);
      $printer -> feed();
      $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
      $printer -> setTextSize(1, 1);
      // Name of Ticket
      $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
      $printer -> setJustification(Printer::JUSTIFY_CENTER);
      $printer -> setTextSize(1, 2);
      $printer -> setFont(Printer::FONT_A);
      $printer -> text("END OF DAY PARKING SETTLEMENT\n");
      $printer -> setTextSize(1, 1);
      $printer -> setFont(Printer::FONT_A);
      $printer -> text(date("d/m/y H:i", strtotime($date1))." - ".date("d/m/y H:i", strtotime($date2)));
      $printer -> feed(2);
      $printer -> selectPrintMode();

      if($campus == 1) {
        //Cash
        $£2Cash = 0;
        $£3Cash = 0;
        $£6Cash = 0;
        $£12CashCAB = 0;
        $£18CashCAB = 0;
        $£18Cash = 0;
        $£24Cash = 0;
        //Card
        $£2Card = 0;
        $£3Card = 0;
        $£6Card = 0;
        $£12CardCAB = 0;
        $£18CardCAB = 0;
        $£18Card = 0;
        $£24Card = 0;
        //Account
        $£3Acc = 0;
        $£6Acc = 0;
        $£12AccCAB = 0;
        $£18AccCAB = 0;
        $£18Acc = 0;
        $£24Acc = 0;
        // ETP
        $£3ETP = 0;
        $£6ETP = 0;
        $£12ETPCAB = 0;
        $£18ETPCAB = 0;
        $£18ETP = 0;
        $£24ETP = 0;
        //Wash
        //Cash
        $Wash10Cash = 0;
        $Wash20Cash = 0;
        //Card
        $Wash10Card = 0;
        $Wash20Card = 0;
        //Account
        $Wash10Acc = 0;
        $Wash20Acc = 0;
        // ETP
        $Wash10ETP = 0;
        $Wash20ETP = 0;

        //Counting Code
        foreach($stmt->fetchAll() as $row) {
          //Cash
          if($row['payment_type'] == 1 AND $row['payment_service_group'] != 2) {
            if($row['payment_price_gross'] == '2.00') {
              //Wifi
              $£2Cash++;
            } else if ($row['payment_price_gross'] == '3.00') {
              //2hr + Car Parking & C/O
              $£3Cash++;
            } else if ($row['payment_price_gross'] == '6.00') {
              //2hr + Car Parking & C/O
              $£6Cash++;
            } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
              // Cab Parking
              $£12CashCAB++;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
              $£12CashCAB+=2;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£12CashCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CashCAB++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CashCAB+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CashCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
              //Parking (ALL EXCEPT CAB)
              $£18Cash++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Cash+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Cash+=3;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Cash++;
            } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Cash+=2;
            } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Cash+=3;
            }
            //Wash
          } else if ($row['payment_type'] == 1 AND $row['payment_service_group'] == 2) {
            if($row['payment_price_gross'] == '7.50') {
              $Wash10Cash++;
            } else if($row['payment_price_gross'] == '12.00') {
              $Wash20Cash++;
            } else if($row['payment_price_gross'] == '19.50') {
              $Wash10Cash+=1;
              $Wash20Cash+=1;
            } else if($row['payment_price_gross'] == '24.00') {
              $Wash20Cash+=2;
            }
          }
          //Card
          if($row['payment_type'] == 2 AND $row['payment_service_group'] != 2) {
            if($row['payment_price_gross'] == '2.00') {
              //1Hr + Car Parking (Driver)
              $£2Card++;
            } else if ($row['payment_price_gross'] == '3.00') {
              //2hr + Car Parking & C/O
              $£3Card++;
            } else if ($row['payment_price_gross'] == '6.00') {
              //2hr + Car Parking & C/O
              $£6Card++;
            } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
              // Cab Parking
              $£12CardCAB++;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
              $£12CardCAB+=2;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£12CardCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CardCAB++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CardCAB+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
              $£18CardCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
              //Parking (ALL EXCEPT CAB)
              $£18Card++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Card+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Card+=3;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Card++;
            } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Card+=2;
            } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Card+=3;
            }
            //Wash
          } else if ($row['payment_type'] == 2 AND $row['payment_service_group'] == 2) {
            if($row['payment_price_gross'] == '7.50') {
              $Wash10Card++;
            } else if($row['payment_price_gross'] == '12.00') {
              $Wash20Card++;
            } else if($row['payment_price_gross'] == '19.50') {
              $Wash10Card+=1;
              $Wash20Card+=1;
            } else if($row['payment_price_gross'] == '24.00') {
              $Wash20Card+=2;
            }
          }
          //Account
          if($row['payment_type'] == 3 AND $row['payment_service_group'] != 2) {
            if($row['payment_price_gross'] == '3.00') {
              //1Hr + Car Parking (Driver)
              $£3Acc++;
            } else if ($row['payment_price_gross'] == '6.00') {
              //2hr + Car Parking & C/O
              $£6Acc++;
            } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
              // Cab Parking
              $£12AccCAB++;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
              $£12AccCAB+=2;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£12AccCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
              $£18AccCAB++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£18AccCAB+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
              $£18AccCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
              //Parking (ALL EXCEPT CAB)
              $£18Acc++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Acc+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
              $£18Acc+=3;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Acc++;
            } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Acc+=2;
            } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2) {
              $£24Acc+=3;
            }
            //Wash
          } else if ($row['payment_type'] == 3 AND $row['payment_service_group'] == 2) {
            if($row['payment_price_gross'] == '7.50') {
              $Wash10Card++;
            } else if($row['payment_price_gross'] == '12.00') {
              $Wash20Card++;
            } else if($row['payment_price_gross'] == '19.50') {
              $Wash10Card+=1;
              $Wash20Card+=1;
            } else if($row['payment_price_gross'] == '24.00') {
              $Wash20Card+=2;
            }
          }
          //SNAP & FUEL
          if($row['payment_type'] > 3 AND $row['payment_service_group'] != 2) {
            if($row['payment_price_gross'] == '3.00') {
              //1Hr + Car Parking (Driver)
              $£3ETP++;
            } else if ($row['payment_price_gross'] == '6.00') {
              //2hr + Car Parking & C/O
              $£6ETP++;
            } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
              // Cab Parking
              $£12ETPCAB++;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
              $£12ETPCAB+=2;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£12ETPCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
              $£18ETPCAB++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
              $£18ETPCAB+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
              $£18ETPCAB+=3;
            } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
              //Parking (ALL EXCEPT CAB)
              $£18ETP++;
            } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
              $£18ETP+=2;
            } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
              $£18ETP+=3;
            } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
              $£24ETP++;
            } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
              $£24ETP+=2;
            } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2) {
              $£24ETP+=3;
            }
            //Wash
          } else if ($row['payment_type'] > 3 AND $row['payment_service_group'] == 2) {
            if($row['payment_price_gross'] == '7.50') {
              $Wash10ETP++;
            } else if($row['payment_price_gross'] == '12.00') {
              $Wash20ETP++;
            } else if($row['payment_price_gross'] == '19.50') {
              $Wash10ETP+=1;
              $Wash20ETP+=1;
            } else if($row['payment_price_gross'] == '24.00') {
              $Wash20ETP+=2;
            }
          }
        }
        try {
          //Cash
          $line_0 = $this->Printer_Columns("WiFi - £2", $£2Cash, 30, 10, 4);
          $line_1 = $this->Printer_Columns("3hr + Car* - £3", $£3Cash, 30, 10, 4);
          $line_2 = $this->Printer_Columns("4hr + C/O + Car - £6", $£6Cash, 30, 10, 4);
          $line_3 = $this->Printer_Columns("Cab Parking - £12", $£12CashCAB, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18CashCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("C/T Parking - £18", $£18Cash, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Cash, 30, 10, 4);
          $line_7 = $this->Printer_Columns("10min Wash - £7.50", $Wash10Cash, 30, 10, 4);
          $line_8 = $this->Printer_Columns("20min Wash - £12", $Wash20Cash, 30, 10, 4);
          $printer -> text("Cash Sales");
          $printer -> feed();
          $printer -> text($line_0);
          $printer -> text($line_1);
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_8);
          $printer -> feed(2);
          //Card
          $line_0 = $this->Printer_Columns("WiFi - £2", $£2Card, 30, 10, 4);
          $line_1 = $this->Printer_Columns("3hr + Car* - £3", $£3Card, 30, 10, 4);
          $line_2 = $this->Printer_Columns("4hr + C/O + Car - £6", $£6Card, 30, 10, 4);
          $line_3 = $this->Printer_Columns("Cab Parking - £12", $£12CardCAB, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18CardCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("C/T Parking - £18", $£18Card, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Card, 30, 10, 4);
          $line_7 = $this->Printer_Columns("10min Wash - £7.50", $Wash10Card, 30, 10, 4);
          $line_8 = $this->Printer_Columns("20min Wash - £12", $Wash20Card, 30, 10, 4);
          $printer -> text("Card Sales");
          $printer -> feed();
          $printer -> text($line_0);
          $printer -> text($line_1);
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_8);
          $printer -> feed(2);
          //Acc
          $line_1 = $this->Printer_Columns("3hr + Car* - £3", $£3Acc, 30, 10, 4);
          $line_2 = $this->Printer_Columns("4hr + C/O + Car - £6", $£6Acc, 30, 10, 4);
          $line_3 = $this->Printer_Columns("Cab Parking - £12", $£12AccCAB, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18AccCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("C/T Parking - £18", $£18Acc, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Acc, 30, 10, 4);
          $line_7 = $this->Printer_Columns("10min Wash - £7.50", $Wash10Acc, 30, 10, 4);
          $line_8 = $this->Printer_Columns("20min Wash - £12", $Wash20Acc, 30, 10, 4);
          $printer -> text("Account Sales");
          $printer -> feed();
          $printer -> text($line_1);
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_8);
          $printer -> feed(2);
          //ETP
          $line_1 = $this->Printer_Columns("3hr + Car* - £3", $£3ETP, 30, 10, 4);
          $line_2 = $this->Printer_Columns("4hr + C/O + Car - £6", $£6ETP, 30, 10, 4);
          $line_3 = $this->Printer_Columns("Cab Parking - £12", $£12ETPCAB, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18ETPCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("C/T Parking - £18", $£18ETP, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24ETP, 30, 10, 4);
          $line_7 = $this->Printer_Columns("10min Wash - £7.50", $Wash10ETP, 30, 10, 4);
          $line_8 = $this->Printer_Columns("20min Wash - £12", $Wash20ETP, 30, 10, 4);
          $printer -> text("ETP Sales");
          $printer -> feed();
          $printer -> text($line_1);
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_8);
          $printer -> feed(2);
          $printer -> cut(Printer::CUT_PARTIAL);
        } finally {
          $printer -> close();
        }
      } else if ($campus == 2) {
        try {
          //Cash
          $£2Cash = 0;
          $£3Cash = 0;
          $£6Cash = 0;
          $£12CashCAB = 0;
          $£18CashCAB = 0;
          $£18Cash = 0;
          $£24Cash = 0;
          $£24CashHSO = 0;
          $£30CashHSO = 0;
          $£22CashCTR = 0;
          $£28CashCTR = 0;
          $£24CashSEP = 0;
          $£30CashSEP = 0;
          //Card
          $£2Card = 0;
          $£3Card = 0;
          $£6Card = 0;
          $£12CardCAB = 0;
          $£18CardCAB = 0;
          $£18Card = 0;
          $£24Card = 0;
          $£24CardHSO = 0;
          $£30CardHSO = 0;
          $£22CardCTR = 0;
          $£28CardCTR = 0;
          $£24CardSEP = 0;
          $£30CardSEP = 0;
          //Account
          $£2Acc = 0;
          $£3Acc = 0;
          $£6Acc = 0;
          $£12AccCAB = 0;
          $£18AccCAB = 0;
          $£18Acc = 0;
          $£24Acc = 0;
          $£24AccHSO = 0;
          $£30AccHSO = 0;
          $£22AccCTR = 0;
          $£28AccCTR = 0;
          $£24AccSEP = 0;
          $£30AccSEP = 0;
          // ETP
          $£2ETP = 0;
          $£3ETP = 0;
          $£6ETP = 0;
          $£12ETPCAB = 0;
          $£18ETPCAB = 0;
          $£18ETP = 0;
          $£24ETP = 0;
          $£24ETPHSO = 0;
          $£30ETPHSO = 0;
          $£22ETPCTR = 0;
          $£28ETPCTR = 0;
          $£24ETPSEP = 0;
          $£30ETPSEP = 0;
          //Counting Code
          foreach($stmt->fetchAll() as $row) {
            //Cash
            if($row['payment_type'] == 1 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '2.00') {
                $£2Cash++;
              } else if($row['payment_price_gross'] == '3.00') {
                //1Hr + Car Parking (Driver)
                $£3Cash++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //2hr + Car Parking & C/O
                $£6Cash++;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
                // Cab Parking
                $£12CashCAB++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2 AND $row['payment_service_id'] != '119') {
                $£12CashCAB+=2;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£12CashCAB+=3;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CashCAB++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CashCAB+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CashCAB+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2 AND $row['payment_service_id'] == '119') {
                $£24CashSEP++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£30CashSEP++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //Parking (ALL EXCEPT CAB)
                $£18Cash++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Cash+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Cash+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Cash++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Cash+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Cash+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CashHSO++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CashHSO+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CashHSO+=3;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CashHSO++;
              } else if ($row['payment_price_gross'] == '60.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CashHSO+=2;
              } else if ($row['payment_price_gross'] == '90.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CashHSO+=3;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CashCTR++;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CashCTR+=2;
              } else if ($row['payment_price_gross'] == '66.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CashCTR+=3;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CashCTR++;
              } else if ($row['payment_price_gross'] == '56.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CashCTR+=2;
              } else if ($row['payment_price_gross'] == '84.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CashCTR+=3;
              }
            }
            //Card
            if($row['payment_type'] == 2 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '2.00') {
                $£2Card++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //1Hr + Car Parking (Driver)
                $£3Card++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //2hr + Car Parking & C/O
                $£6Card++;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
                // Cab Parking
                $£12CardCAB++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
                $£12CardCAB+=2;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£12CardCAB+=3;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CardCAB++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CardCAB+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18CardCAB+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2 AND $row['payment_service_id'] == '119') {
                $£24CardSEP++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£30CardSEP++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //Parking (ALL EXCEPT CAB)
                $£18Card++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Card+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Card+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Card++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Card+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Card+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CardHSO++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CardHSO+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24CardHSO+=3;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CardHSO++;
              } else if ($row['payment_price_gross'] == '60.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CardHSO+=2;
              } else if ($row['payment_price_gross'] == '90.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30CardHSO+=3;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CardCTR++;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CardCTR+=2;
              } else if ($row['payment_price_gross'] == '66.00' AND $row['payment_vehicle_type'] == 8) {
                $£22CardCTR+=3;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CardCTR++;
              } else if ($row['payment_price_gross'] == '56.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CardCTR+=2;
              } else if ($row['payment_price_gross'] == '84.00' AND $row['payment_vehicle_type'] == 8) {
                $£28CardCTR+=3;
              }
            }
            //Account
            if($row['payment_type'] == 3 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '2.00') {
                $£2Acc++;
              } else if($row['payment_price_gross'] == '3.00') {
                //1Hr + Car Parking (Driver)
                $£3Acc++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //2hr + Car Parking & C/O
                $£6Acc++;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
                // Cab Parking
                $£12AccCAB++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
                $£12AccCAB+=2;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£12AccCAB+=3;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18AccCAB++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18AccCAB+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18AccCAB+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2 AND $row['payment_service_id'] == '119') {
                $£24AccSEP++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£30AccSEP++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //Parking (ALL EXCEPT CAB)
                $£18Acc++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Acc+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
                $£18Acc+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Acc++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Acc+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24Acc+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24AccHSO++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24AccHSO+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24AccHSO+=3;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30AccHSO++;
              } else if ($row['payment_price_gross'] == '60.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30AccHSO+=2;
              } else if ($row['payment_price_gross'] == '90.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30AccHSO+=3;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 8) {
                $£22AccCTR++;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] == 8) {
                $£22AccCTR+=2;
              } else if ($row['payment_price_gross'] == '66.00' AND $row['payment_vehicle_type'] == 8) {
                $£22AccCTR+=3;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] == 8) {
                $£28AccCTR++;
              } else if ($row['payment_price_gross'] == '56.00' AND $row['payment_vehicle_type'] == 8) {
                $£28AccCTR+=2;
              } else if ($row['payment_price_gross'] == '84.00' AND $row['payment_vehicle_type'] == 8) {
                $£28AccCTR+=3;
              }
            }
            //SNAP & FUEL
            if($row['payment_type'] > 3 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '2.00') {
                $£2ETP++;
              } else if($row['payment_price_gross'] == '3.00') {
                //1Hr + Car Parking (Driver)
                $£3ETP++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //2hr + Car Parking & C/O
                $£6ETP++;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 2) {
                // Cab Parking
                $£12ETPCAB++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2) {
                $£12ETPCAB+=2;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£12ETPCAB+=3;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18ETPCAB++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18ETPCAB+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18ETPCAB+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] == 2 AND $row['payment_service_id'] == '119') {
                $£24CashSEP++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£30CashSEP++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //All other vehicles
                $£18ETP++;
              } else if ($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] != 2) {
                $£18ETP+=2;
              } else if ($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] != 2) {
                $£18ETP+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24ETP++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24ETP+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£24ETP+=3;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24ETPHSO++;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24ETPHSO+=2;
              } else if ($row['payment_price_gross'] == '72.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                $£24ETPHSO+=3;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30ETPHSO++;
              } else if ($row['payment_price_gross'] == '60.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30ETPHSO+=2;
              } else if ($row['payment_price_gross'] == '90.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 3) {
                $£30ETPHSO+=3;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 8) {
                $£22ETPCTR++;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] == 8) {
                $£22ETPCTR+=2;
              } else if ($row['payment_price_gross'] == '66.00' AND $row['payment_vehicle_type'] == 8) {
                $£22ETPCTR+=3;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] == 8) {
                $£28ETPCTR++;
              } else if ($row['payment_price_gross'] == '56.00' AND $row['payment_vehicle_type'] == 8) {
                $£28ETPCTR+=2;
              } else if ($row['payment_price_gross'] == '84.00' AND $row['payment_vehicle_type'] == 8) {
                $£28ETPCTR+=3;
              }
            }
          }
          //Cash
          $line_2 = $this->Printer_Columns("WiFi - £2", $£2Cash, 30, 10, 4);
          $line_3 = $this->Printer_Columns("C/O + Car - £6", $£6Cash, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking - £12", $£12CashCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18CashCAB, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking - £18", $£18Cash, 30, 10, 4);
          $line_7 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Cash, 30, 10, 4);
          $line_SEP = $this->Printer_Columns("C/T SEP - £24", $£24CardSEP, 30, 10, 4);
          $line_SEP2 = $this->Printer_Columns("C/T SEP + MEAL - £30", $£30CardSEP, 30, 10, 4);
          $line_8 = $this->Printer_Columns("Hi-Sec / OS - £24", $£24CashHSO, 30, 10, 4);
          $line_9 = $this->Printer_Columns("Hi-Sec / OS + Meal - £30", $£30CashHSO, 30, 10, 4);
          $line_10 = $this->Printer_Columns("CTR - £22", $£22CashCTR, 30, 10, 4);
          $line_11 = $this->Printer_Columns("CTR + Meal - £28", $£28CashCTR, 30, 10, 4);
          $printer -> text("Cash Sales");
          $printer -> feed();
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_SEP);
          $printer -> text($line_SEP2);
          $printer -> text($line_8);
          $printer -> text($line_9);
          $printer -> text($line_10);
          $printer -> text($line_11);
          $printer -> feed(2);
          //Card
          $line_2 = $this->Printer_Columns("WiFi - £2", $£2Card, 30, 10, 4);
          $line_3 = $this->Printer_Columns("C/O + Car - £6", $£6Card, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking - £12", $£12CardCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18CardCAB, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking - £18", $£18Card, 30, 10, 4);
          $line_7 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Card, 30, 10, 4);
          $line_SEP = $this->Printer_Columns("C/T SEP - £24", $£24CardSEP, 30, 10, 4);
          $line_SEP2 = $this->Printer_Columns("C/T SEP + MEAL - £30", $£30CardSEP, 30, 10, 4);
          $line_8 = $this->Printer_Columns("Hi-Sec / OS - £24", $£24CardHSO, 30, 10, 4);
          $line_9 = $this->Printer_Columns("Hi-Sec / OS + Meal - £30", $£30CardHSO, 30, 10, 4);
          $line_10 = $this->Printer_Columns("CTR - £22", $£22CardCTR, 30, 10, 4);
          $line_11 = $this->Printer_Columns("CTR + Meal - £28", $£28CardCTR, 30, 10, 4);
          $printer -> text("Card Sales");
          $printer -> feed();
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_SEP);
          $printer -> text($line_SEP2);
          $printer -> text($line_8);
          $printer -> text($line_9);
          $printer -> text($line_10);
          $printer -> text($line_11);
          $printer -> feed(2);
          //Account
          $line_2 = $this->Printer_Columns("WiFi - £2", $£2Acc, 30, 10, 4);
          $line_3 = $this->Printer_Columns("C/O + Car - £6", $£6Acc, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking - £12", $£12AccCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18AccCAB, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking - £18", $£18Acc, 30, 10, 4);
          $line_7 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24Acc, 30, 10, 4);
          $line_SEP = $this->Printer_Columns("C/T SEP - £24", $£24AccSEP, 30, 10, 4);
          $line_SEP2 = $this->Printer_Columns("C/T SEP + MEAL - £30", $£30AccSEP, 30, 10, 4);
          $line_8 = $this->Printer_Columns("Hi-Sec / OS - £24", $£24AccHSO, 30, 10, 4);
          $line_9 = $this->Printer_Columns("Hi-Sec / OS + Meal - £30", $£30AccHSO, 30, 10, 4);
          $line_10 = $this->Printer_Columns("CTR - £22", $£22AccCTR, 30, 10, 4);
          $line_11 = $this->Printer_Columns("CTR + Meal - £28", $£28AccCTR, 30, 10, 4);
          $printer -> text("Account Sales");
          $printer -> feed();
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_SEP);
          $printer -> text($line_SEP2);
          $printer -> text($line_8);
          $printer -> text($line_9);
          $printer -> text($line_10);
          $printer -> text($line_11);
          $printer -> feed(2);
          //ETP
          $line_2 = $this->Printer_Columns("WiFi - £2", $£2ETP, 30, 10, 4);
          $line_3 = $this->Printer_Columns("C/O + Car - £6", $£6ETP, 30, 10, 4);
          $line_4 = $this->Printer_Columns("Cab Parking - £12", $£12ETPCAB, 30, 10, 4);
          $line_5 = $this->Printer_Columns("Cab Parking + Meal - £18", $£18ETPCAB, 30, 10, 4);
          $line_6 = $this->Printer_Columns("C/T Parking - £18", $£18ETP, 30, 10, 4);
          $line_7 = $this->Printer_Columns("C/T Parking + Meal - £24", $£24ETP, 30, 10, 4);
          $line_SEP = $this->Printer_Columns("C/T SEP - £24", $£24ETPSEP, 30, 10, 4);
          $line_SEP2 = $this->Printer_Columns("C/T SEP + MEAL - £30", $£30ETPSEP, 30, 10, 4);
          $line_8 = $this->Printer_Columns("Hi-Sec / OS - £24", $£24ETPHSO, 30, 10, 4);
          $line_9 = $this->Printer_Columns("Hi-Sec / OS + Meal - £30", $£30ETPHSO, 30, 10, 4);
          $line_10 = $this->Printer_Columns("CTR Parking - £22", $£22ETPCTR, 30, 10, 4);
          $line_11 = $this->Printer_Columns("CTR Parking + Meal - £28", $£28ETPCTR, 30, 10, 4);
          $printer -> text("ETP Sales");
          $printer -> feed();
          $printer -> text($line_2);
          $printer -> text($line_3);
          $printer -> text($line_4);
          $printer -> text($line_5);
          $printer -> text($line_6);
          $printer -> text($line_7);
          $printer -> text($line_SEP);
          $printer -> text($line_SEP2);
          $printer -> text($line_8);
          $printer -> text($line_9);
          $printer -> text($line_10);
          $printer -> text($line_11);
          $printer -> feed(2);
          $printer -> cut(Printer::CUT_PARTIAL);
        } finally {
          $printer -> close();
        }
      }

      $this->mysql = null;
      $this->user = null;
      $this->pm = null;
      $this->payment = null;
    }
  }
?>
