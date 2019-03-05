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
        $this->Printer_Misc($shower_count, $wifi_count);
      }
    }
    //Begin Tickets
    //Print parking ticket
    function Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->PM_SiteInfo($campus, "site_vat");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Printer Connection
      if($campus == 1) {
        //Holyhead
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 2) {
        //Cannock
        $connector = new WindowsPrintConnector("smb://security:pd@192.168.1.68/pdhollies");
      } else if ($campus == 0) {
        //Developer
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      }
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
    		if($campus == 1) {
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
    		if($campus == 1) {
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
    			if($campus == 1) {
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
    			if($campus == 1) {
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
    			if($campus == 1) {
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
    			if($campus == 1) {
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
      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->PM_SiteInfo($campus, "site_vat");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);

      try {
        //Printer Connection
        if($campus == 1) {
          //Holyhead
          $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
        } else if ($campus == 2) {
          //Cannock
          $connector = new WindowsPrintConnector("smb://security:pd@192.168.1.68/pdhollies");
        } else if($campus == 3){
          //Developer
          $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
        }
        $printer = new Printer($connector);
        $ticket = EscposImage::load($img_dir."/wash.jpg", false);
        $date = date("d/m/Y H:i", strtotime($date));

        $line_one = $this->Printer_Columns("Company: ".$company, "Reg: ".$reg, 18, 24, 2);
        $line_two = $this->Printer_Columns("TID: ".$tid, "Date: ".$date, 18, 24, 2);

        // Name of Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($ticket);
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
        if($campus == 1) {
    			$printer -> graphics($logo);
    		} else {
    			$printer -> bitImage($logo);
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
    function Printer_Misc($shower_count, $wifi_count) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      try {
        //Printer Connection
        if($campus == 1) {
          //Holyhead
          $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
        } else if ($campus == 2) {
          //Cannock
          $connector = new WindowsPrintConnector("smb://security:pd@192.168.1.68/pdhollies");
        } else if($campus == 0){
          //Developer
          $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
        }
        $printer = new Printer($connector);
        $wifi = EscposImage::load($img_dir."/wifi.jpg", false);
        $shower  = EscposImage::load($img_dir."/shower.jpg", false);

        $i = 1;
        //Shower
        while ($i++ <= $wifi_count) {
          // Generate Voucher
          $code = $this->pm->Create_WiFi_Voucher($campus);
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($campus == 1) {
            $printer -> graphics($wifi);
          } else {
            $printer -> bitImage($wifi);
          }
          $printer -> setTextSize(2, 2);
          $printer -> text('WiFi Code: '.$code);
          $printer -> feed();
          $printer -> setTextSize(1, 1);
          $printer -> text("Please connect to; Parc-Cybi-Car-Park");
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
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
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
      if($campus == 1) {
        //Holyhead
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 2) {
        //Cannock
        $connector = new WindowsPrintConnector("smb://security:pd@192.168.1.68/pdhollies");
      } else if($campus == 0) {
        //Developer
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      }
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);

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
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
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
          $line_8 = $this->Printer_Columns("Hi-Sec / OS + Meal - £24", $£24CashHSO, 30, 10, 4);
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
          $line_8 = $this->Printer_Columns("Hi-Sec / OS + Meal - £24", $£24CardHSO, 30, 10, 4);
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
          $line_8 = $this->Printer_Columns("Hi-Sec / OS + Meal - £24", $£24AccHSO, 30, 10, 4);
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
          $line_8 = $this->Printer_Columns("Hi-Sec / OS + Meal - £24", $£24ETPHSO, 30, 10, 4);
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
      $this->payment = null;
    }
    function Printer_9PM_OLD($date1, $date2) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
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
      if($campus == 1) {
        //Holyhead
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 2) {
        //Cannock
        $connector = new WindowsPrintConnector("smb://security:pd@192.168.1.68/pdhollies");
      } else if($campus == 3) {
        //Developer
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      }
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);
      if($campus == 1) {
        //Ticket Code
        try {
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
          $£3Cash = 0;
          $£6Cash = 0;
          $£10Cash = 0;
          $£15Cash = 0;
          $£18Cash = 0;
          $£23Cash = 0;
          //Card
          $£3Card = 0;
          $£6Card = 0;
          $£10Card = 0;
          $£15Card = 0;
          $£18Card = 0;
          $£23Card = 0;
          //Account
          $£3Acc = 0;
          $£6Acc = 0;
          $£10Acc = 0;
          $£15Acc = 0;
          $£18Acc = 0;
          $£23Acc = 0;
          //SNAP
          $£3SNAP = 0;
          $£6SNAP = 0;
          $£10SNAP = 0;
          $£15SNAP = 0;
          $£18SNAP = 0;
          $£23SNAP = 0;
          //FUEL
          $£3Fuel = 0;
          $£6Fuel = 0;
          $£10Fuel = 0;
          $£15Fuel = 0;
          $£18Fuel = 0;
          $£23Fuel = 0;

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
          //SNAP
          $Wash10SNAP = 0;
          $Wash20SNAP = 0;
          //FUEL
          $Wash10Fuel = 0;
          $Wash20Fuel = 0;
          foreach ($stmt->fetchAll() as $row) {
            //Cash
            if($row['payment_type'] == 1 AND $row['payment_service_group'] != 2) {
              //CT
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
                $£3Cash++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
                $£6Cash++;
              } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Cash++;
              } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Cash++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Cash+=2;
              } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Cash+=2;
              } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Cash+=3;
              } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Cash+=3;
              }
              //Cab
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
                $£3Cash++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
                $£6Cash++;
              } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Cash++;
              } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Cash++;
              } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Cash+=2;
              } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Cash+=2;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Cash+=3;
              } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Cash+=3;
              }
            } else if($row['payment_type'] == 1 AND $row['payment_service_group'] == 2){
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
              //CT
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
                $£3Card++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
                $£6Card++;
              } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Card++;
              } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Card++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Card+=2;
              } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Card+=2;
              } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Card+=3;
              } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Card+=3;
              }
              //Cab
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
                $£3Card++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
                $£6Card++;
              } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Card++;
              } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Card++;
              } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Card+=2;
              } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Card+=2;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Card+=3;
              } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Card+=3;
              }
            } else if($row['payment_type'] == 2 AND $row['payment_service_group'] == 2) {
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
              //CT
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
                $£3Acc++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
                $£6Acc++;
              } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Acc++;
              } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Acc++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Acc+=2;
              } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Acc+=2;
              } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Acc+=3;
              } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Acc+=3;
              }
              //Cab
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
                $£3Acc++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
                $£6Acc++;
              } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Acc++;
              } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Acc++;
              } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Acc+=2;
              } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Acc+=2;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Acc+=3;
              } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Acc+=3;
              }
            } else if($row['payment_type'] == 3 AND $row['payment_service_group'] == 2){
              if($row['payment_price_gross'] == '7.50') {
                $Wash10Acc++;
              } else if($row['payment_price_gross'] == '12.00') {
                $Wash20Acc++;
              } else if($row['payment_price_gross'] == '19.50') {
                $Wash10Acc+=1;
                $Wash20Acc+=1;
              } else if($row['payment_price_gross'] == '24.00') {
                $Wash20Acc+=2;
              }
            }
            //SNAP
            if($row['payment_type'] == 4 AND $row['payment_service_group'] != 2) {
              //CT
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
                $£3SNAP++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
                $£6SNAP++;
              } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
                $£15SNAP++;
              } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
                $£23SNAP++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                $£15SNAP+=2;
              } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
                $£23SNAP+=2;
              } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
                $£15SNAP+=3;
              } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
                $£23SNAP+=3;
              }
              //Cab
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
                $£3SNAP++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
                $£6SNAP++;
              } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                $£10SNAP++;
              } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18SNAP++;
              } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
                $£10SNAP+=2;
              } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18SNAP+=2;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£10SNAP+=3;
              } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18SNAP+=3;
              }
            } else if($row['payment_type'] == 4 AND $row['payment_service_group'] == 2){
              if($row['payment_price_gross'] == '7.50') {
                $Wash10SNAP++;
              } else if($row['payment_price_gross'] == '12.00') {
                $Wash20SNAP++;
              } else if($row['payment_price_gross'] == '19.50') {
                $Wash10SNAP+=1;
                $Wash20SNAP+=1;
              } else if($row['payment_price_gross'] == '24.00') {
                $Wash20SNAP+=2;
              }
            }
            //Fuel
            if($row['payment_type'] == 5 AND $row['payment_service_group'] != 2) {
              //CT
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
                $£3Fuel++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
                $£6Fuel++;
              } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Fuel++;
              } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Fuel++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Fuel+=2;
              } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Fuel+=2;
              } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
                $£15Fuel+=3;
              } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
                $£23Fuel+=3;
              }
              //Cab
              if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
                $£3Fuel++;
              } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
                $£6Fuel++;
              } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Fuel++;
              } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Fuel++;
              } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Fuel+=2;
              } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Fuel+=2;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                $£10Fuel+=3;
              } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
                $£18Fuel+=3;
              }
            } else if($row['payment_type'] == 5 AND $row['payment_service_group'] == 2){
              if($row['payment_price_gross'] == '7.50') {
                $Wash10Fuel++;
              } else if($row['payment_price_gross'] == '12.00') {
                $Wash20Fuel++;
              } else if($row['payment_price_gross'] == '19.50') {
                $Wash10Fuel+=1;
                $Wash20Fuel+=1;
              } else if($row['payment_price_gross'] == '24.00') {
                $Wash20Fuel+=2;
              }
            }
          }
          $line_one = $this->Printer_Columns("3hr / DRIVER CAR - £3", $£3Cash, 30, 10, 4);
          $line_two = $this->Printer_Columns("4hr / C/O / Car - £6", $£6Cash, 30, 10, 4);
          $line_three = $this->Printer_Columns("Cab Parking - £10", $£10Cash, 30, 10, 4);
          $line_four = $this->Printer_Columns("C/T Parking - £15", $£15Cash, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab + Meal - £18", $£18Cash, 30, 10, 4);
          $line_six = $this->Printer_Columns("C/T + Meal - £23", $£23Cash, 30, 10, 4);
          $line_seven = $this->Printer_Columns("10min Wash", $Wash10Cash, 30, 10, 4);
          $line_eight = $this->Printer_Columns("20min Wash", $Wash20Cash, 30, 10, 4);
          $printer -> text("Cash Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_six);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> feed(2);
          $line_one = $this->Printer_Columns("3hr / DRIVER CAR - £3", $£3Card, 30, 10, 4);
          $line_two = $this->Printer_Columns("4hr / C/O / Car - £6", $£6Card, 30, 10, 4);
          $line_three = $this->Printer_Columns("Cab Parking - £10", $£10Card, 30, 10, 4);
          $line_four = $this->Printer_Columns("C/T Parking - £15", $£15Card, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab + Meal - £18", $£18Card, 30, 10, 4);
          $line_six = $this->Printer_Columns("C/T + Meal - £23", $£23Card, 30, 10, 4);
          $line_seven = $this->Printer_Columns("10min Wash", $Wash10Card, 30, 10, 4);
          $line_eight = $this->Printer_Columns("20min Wash", $Wash20Card, 30, 10, 4);
          $printer -> text("Card Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_six);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> feed(2);
          $line_one = $this->Printer_Columns("3hr / DRIVER CAR - £3", $£3Acc, 30, 10, 4);
          $line_two = $this->Printer_Columns("4hr / C/O / Car - £6", $£6Acc, 30, 10, 4);
          $line_three = $this->Printer_Columns("Cab Parking - £10", $£10Acc, 30, 10, 4);
          $line_four = $this->Printer_Columns("C/T Parking - £15", $£15Acc, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab + Meal - £18", $£18Acc, 30, 10, 4);
          $line_six = $this->Printer_Columns("C/T + Meal - £23", $£23Acc, 30, 10, 4);
          $line_seven = $this->Printer_Columns("10min Wash", $Wash10Acc, 30, 10, 4);
          $line_eight = $this->Printer_Columns("20min Wash", $Wash20Acc, 30, 10, 4);
          $printer -> text("Account Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_six);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> feed(2);
          $line_one = $this->Printer_Columns("3hr / DRIVER CAR - £3", $£3SNAP+$£3Fuel, 30, 10, 4);
          $line_two = $this->Printer_Columns("4hr / C/O / Car - £6", $£6SNAP+$£6Fuel, 30, 10, 4);
          $line_three = $this->Printer_Columns("Cab Parking - £10", $£10SNAP+$£10Fuel, 30, 10, 4);
          $line_four = $this->Printer_Columns("C/T Parking - £15", $£15SNAP+$£15Fuel, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab + Meal - £18", $£18SNAP+$£18Fuel, 30, 10, 4);
          $line_six = $this->Printer_Columns("C/T + Meal - £23", $£23SNAP+$£23Fuel, 30, 10, 4);
          $line_seven = $this->Printer_Columns("10min Wash", $Wash10SNAP+$Wash10Fuel, 30, 10, 4);
          $line_eight = $this->Printer_Columns("20min Wash", $Wash20SNAP+$Wash20Fuel, 30, 10, 4);
          $printer -> text("SNAP & Fuel Card Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_six);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> feed(2);
          $printer -> selectPrintMode();
          $printer-> cut();
        } finally {
          $printer->close();
        }
      } else if ($campus == 2) {
          //Ticket Code
        try {
          //Settlement
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> bitImage($logo);
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
          //Cash
          $£1Cash = 0;
          $£2Cash = 0;
          $£3Cash = 0;
          $£6Cash = 0;
          $£10Cash = 0;
          $£16Cash = 0;
          $£18Cash = 0;
          $£20Cash = 0;
          $£22Cash = 0;
          $£24Cash = 0;
          $£28Cash = 0;
          $£30Cash = 0;
          $£10CashCAB = 0;
          $£18CashCAB = 0;
          $£22CashCAB = 0;
          $£30CashCAB = 0;
          //Card
          $£1Card = 0;
          $£2Card = 0;
          $£3Card = 0;
          $£6Card = 0;
          $£10Card = 0;
          $£16Card = 0;
          $£18Card = 0;
          $£20Card = 0;
          $£22Card = 0;
          $£24Card = 0;
          $£28Card = 0;
          $£30Card = 0;
          $£10CardCAB = 0;
          $£18CardCAB = 0;
          $£22CardCAB = 0;
          $£30CardCAB = 0;
          //Account
          $£1Acc = 0;
          $£2Acc = 0;
          $£3Acc = 0;
          $£6Acc = 0;
          $£10Acc = 0;
          $£16Acc = 0;
          $£18Acc = 0;
          $£20Acc = 0;
          $£22Acc = 0;
          $£24Acc = 0;
          $£28Acc = 0;
          $£30Acc = 0;
          $£10AccCAB = 0;
          $£18AccCAB = 0;
          $£22AccCAB = 0;
          $£30AccCAB = 0;
          //SNAP
          $£1SNAP = 0;
          $£2SNAP = 0;
          $£3SNAP = 0;
          $£6SNAP = 0;
          $£10SNAP = 0;
          $£16SNAP = 0;
          $£18SNAP = 0;
          $£20SNAP = 0;
          $£22SNAP = 0;
          $£24SNAP = 0;
          $£28SNAP = 0;
          $£30SNAP = 0;
          $£10SNAPCAB = 0;
          $£18SNAPCAB = 0;
          $£22SNAPCAB = 0;
          $£30SNAPCAB = 0;
          //Fuel
          $£1Fuel = 0;
          $£2Fuel = 0;
          $£3Fuel = 0;
          $£6Fuel = 0;
          $£10Fuel = 0;
          $£16Fuel = 0;
          $£18Fuel = 0;
          $£20Fuel = 0;
          $£22Fuel = 0;
          $£24Fuel = 0;
          $£28Fuel = 0;
          $£30Fuel = 0;
          $£10FuelCAB = 0;
          $£18FuelCAB = 0;
          $£22FuelCAB = 0;
          $£30FuelCAB = 0;
          foreach ($stmt->fetchAll() as $row) {
            //Cash
            if($row['payment_type'] == 1 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '1.00') {
                //Loyalty
                $£1Cash++;
              } else if ($row['payment_price_gross'] == '2.00') {
                //Wifi
                $£2Cash++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //Shower
                $£3Cash++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //Shower
                $£6Cash++;
              } else if ($row['payment_price_gross'] == '16.00' AND $row['payment_vehicle_type'] != 2) {
                //CT 24hr
                $£16Cash++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //CT + WiFi 24hr
                $£18Cash++;
              } else if ($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR
                $£20Cash++;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] != 2) {
                //CT OVERSIZED HISEC
                $£22Cash++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
                //CT WITH MEAL
                $£24Cash++;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR Meal
                $£28Cash++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                //24hr HISEC
                $£30Cash++;
              } else if ($row['payment_price_gross'] == '32.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT
                $£16Cash+=2;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] != 2) {
                //
                $£22Cash+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                //72hr CT
                $£16Cash+=3;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT Meal
                $£24Cash+=2;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Cash+=2;
                //// CABS
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Cash+=3;
                //// CABS
              } else if ($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit only
                $£10CashCAB++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit + Meal
                $£18CashCAB++;
              } else if($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR
                $£22CashCAB++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR + Food
                $£30CashCAB++;
              }
            }
            //Card
            if($row['payment_type'] == 2 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '1.00') {
                //Loyalty
                $£1Card++;
              } else if ($row['payment_price_gross'] == '2.00') {
                //Wifi
                $£2Card++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //Shower
                $£3Card++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //Shower
                $£6Card++;
              } else if ($row['payment_price_gross'] == '16.00' AND $row['payment_vehicle_type'] != 2) {
                //CT 24hr
                $£16Card++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //CT + WiFi 24hr
                $£18Card++;
              } else if ($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR
                $£20Card++;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] != 2) {
                //CT OVERSIZED HISEC
                $£22Card++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
                //CT WITH MEAL
                $£24Card++;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR Meal
                $£28Card++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                //24hr HISEC
                $£30Card++;
              } else if ($row['payment_price_gross'] == '32.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT
                $£16Card+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                //72hr CT
                $£16Card+=3;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] != 2) {
                //
                $£22Card+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT Meal
                $£24Card+=2;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Card+=2;
                //// CABS
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Card+=3;
                //// CABS
              } else if ($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit only
                $£10CardCAB++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit + Meal
                $£18CardCAB++;
              } else if($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR
                $£22CardCAB++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR + Food
                $£30CardCAB++;
              }
            }
            //Acc
            if($row['payment_type'] == 3 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '1.00') {
                //Loyalty
                $£1Acc++;
              } else if ($row['payment_price_gross'] == '2.00') {
                //Wifi
                $£2Acc++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //Shower
                $£3Acc++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //Shower
                $£6Acc++;
              } else if ($row['payment_price_gross'] == '16.00' AND $row['payment_vehicle_type'] != 2) {
                //CT 24hr
                $£16Acc++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //CT + WiFi 24hr
                $£18Acc++;
              } else if ($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR
                $£20Acc++;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] != 2) {
                //CT OVERSIZED HISEC
                $£22Acc++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
                //CT WITH MEAL
                $£24Acc++;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR Meal
                $£28Acc++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                //24hr HISEC
                $£30Acc++;
              } else if ($row['payment_price_gross'] == '32.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT
                $£16Acc+=2;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] != 2) {
                //
                $£22Acc+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT Meal
                $£24Acc+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                //72hr CT
                $£16Acc+=3;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Acc+=2;
                //// CABS
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 6) {
                //72hr CAR
                $£6Acc+=3;
                //// CABS
              } else if ($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit only
                $£10AccCAB++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit + Meal
                $£18AccCAB++;
              } else if($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR
                $£22AccCAB++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR + Food
                $£30AccCAB++;
              }
            }
            //SNAP
            if($row['payment_type'] == 4 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '1.00') {
                //Loyalty
                $£1SNAP++;
              } else if ($row['payment_price_gross'] == '2.00') {
                //Wifi
                $£2SNAP++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //Shower
                $£3SNAP++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //Shower
                $£6SNAP++;
              } else if ($row['payment_price_gross'] == '16.00' AND $row['payment_vehicle_type'] != 2) {
                //CT 24hr
                $£16SNAP++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //CT + WiFi 24hr
                $£18SNAP++;
              } else if ($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR
                $£20SNAP++;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] != 2) {
                //CT OVERSIZED HISEC
                $£22SNAP++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
                //CT WITH MEAL
                $£24SNAP++;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR Meal
                $£28SNAP++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                //24hr HISEC
                $£30SNAP++;
              } else if ($row['payment_price_gross'] == '32.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT
                $£16SNAP+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                //72hr CT
                $£16SNAP+=3;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] != 2) {
                //
                $£22SNAP+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT Meal
                $£24SNAP+=2;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6SNAP+=2;
                //// CABS
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 6) {
                //72hr CAR
                $£6SNAP+=3;
                //// CABS
              } else if ($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit only
                $£10SNAPCAB++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit + Meal
                $£18SNAPCAB++;
              } else if($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR
                $£22SNAPCAB++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR + Food
                $£30SNAPCAB++;
              }
            }
            //Fuel Card
            if($row['payment_type'] == 5 AND $row['payment_service_group'] != 2) {
              if($row['payment_price_gross'] == '1.00') {
                //Loyalty
                $£1Fuel++;
              } else if ($row['payment_price_gross'] == '2.00') {
                //Wifi
                $£2Fuel++;
              } else if ($row['payment_price_gross'] == '3.00') {
                //Shower
                $£3Fuel++;
              } else if ($row['payment_price_gross'] == '6.00') {
                //Shower
                $£6Fuel++;
              } else if ($row['payment_price_gross'] == '16.00' AND $row['payment_vehicle_type'] != 2) {
                //CT 24hr
                $£16Fuel++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] != 2) {
                //CT + WiFi 24hr
                $£18Fuel++;
              } else if ($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR
                $£20Fuel++;
              } else if ($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] != 2) {
                //CT OVERSIZED HISEC
                $£22Fuel++;
              } else if ($row['payment_price_gross'] == '24.00' AND $row['payment_vehicle_type'] != 2) {
                //CT WITH MEAL
                $£24Fuel++;
              } else if ($row['payment_price_gross'] == '28.00' AND $row['payment_vehicle_type'] != 2) {
                //CTR Meal
                $£28Fuel++;
              } else if ($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
                //24hr HISEC
                $£30Fuel++;
              } else if ($row['payment_price_gross'] == '32.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT
                $£16Fuel+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2 AND $row['payment_service_group'] == 1) {
                //72hr CT
                $£16Fuel+=3;
              } else if ($row['payment_price_gross'] == '44.00' AND $row['payment_vehicle_type'] != 2) {
                //
                $£22Fuel+=2;
              } else if ($row['payment_price_gross'] == '48.00' AND $row['payment_vehicle_type'] != 2) {
                //48hr CT Meal
                $£24Fuel+=2;
              } else if ($row['payment_price_gross'] == '12.00' AND $row['payment_vehicle_type'] == 6) {
                //48hr CT Meal
                $£6Fuel+=2;
                //// CABS
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 6) {
                //72hr CAR
                $£6Fuel+=3;
                //// CABS
              } else if ($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit only
                $£10FuelCAB++;
              } else if ($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
                //Unit + Meal
                $£18FuelCAB++;
              } else if($row['payment_price_gross'] == '22.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR
                $£22FuelCAB++;
              } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
                //HGV SEPAR + Food
                $£30FuelCAB++;
              }
            }
          }
          //Cash
          $line_one = $this->Printer_Columns("Loyalty - £1", $£1Cash, 30, 10, 4);
          $line_two = $this->Printer_Columns("WiFi - £2", $£2Cash, 30, 10, 4);
          $line_three = $this->Printer_Columns("Shower - £3", $£3Cash, 30, 10, 4);
          $line_four = $this->Printer_Columns("Car / C/O - £6", $£6Cash, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab Only - £10", $£10CashCAB, 30, 10, 4);
          $line_cabmeal = $this->Printer_Columns("Cab Only + Meal - £18", $£18CashCAB, 30, 10, 4);
          $line_ctr20 = $this->Printer_Columns("CTR - £20", $£20Cash, 30, 10, 4);
          $line_six = $this->Printer_Columns("Cab Only + Sep - £22", $£22CashCAB, 30, 10, 4);
          $line_ctr28 = $this->Printer_Columns("CTR w/ Meal - £28", $£28Cash, 30, 10, 4);
          $line_seven = $this->Printer_Columns("Cab Only + Sep/Meal - £30", $£30CashCAB, 30, 10, 4);
          $line_eight = $this->Printer_Columns("C/T - £16", $£16Cash, 30, 10, 4);
          $line_nine = $this->Printer_Columns("C/T w/ WiFi - £18", $£18Cash, 30, 10, 4);
          $line_ten = $this->Printer_Columns("C/T HS/OS - £22", $£22Cash, 30, 10, 4);
          $line_eleven = $this->Printer_Columns("C/T w/ Meal - £24", $£24Cash, 30, 10, 4);
          $line_twelve = $this->Printer_Columns("C/T HS w/ Meal - £30", $£30Cash, 30, 10, 4);
          $printer -> text("Cash Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_cabmeal);
          $printer -> text($line_ctr20);
          $printer -> text($line_six);
          $printer -> text($line_ctr28);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> text($line_nine);
          $printer -> text($line_ten);
          $printer -> text($line_eleven);
          $printer -> text($line_twelve);
          $printer -> feed(2);
          //Card
          $line_one = $this->Printer_Columns("Loyalty - £1", $£1Card, 30, 10, 4);
          $line_two = $this->Printer_Columns("WiFi - £2", $£2Card, 30, 10, 4);
          $line_three = $this->Printer_Columns("Shower - £3", $£3Card, 30, 10, 4);
          $line_four = $this->Printer_Columns("Car / C/O - £6", $£6Card, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab Only - £10", $£10CardCAB, 30, 10, 4);
          $line_cabmeal = $this->Printer_Columns("Cab Only + Meal - £18", $£18CardCAB, 30, 10, 4);
          $line_ctr20 = $this->Printer_Columns("CTR - £20", $£20Card, 30, 10, 4);
          $line_six = $this->Printer_Columns("Cab Only + Sep - £22", $£22CardCAB, 30, 10, 4);
          $line_ctr28 = $this->Printer_Columns("CTR w/ Meal - £28", $£28Card, 30, 10, 4);
          $line_seven = $this->Printer_Columns("Cab Only + Sep/Meal - £30", $£30CardCAB, 30, 10, 4);
          $line_eight = $this->Printer_Columns("C/T - £16", $£16Card, 30, 10, 4);
          $line_nine = $this->Printer_Columns("C/T w/ WiFi - £18", $£18Card, 30, 10, 4);
          $line_ten = $this->Printer_Columns("C/T HS/OS - £22", $£22Card, 30, 10, 4);
          $line_eleven = $this->Printer_Columns("C/T w/ Meal - £24", $£24Card, 30, 10, 4);
          $line_twelve = $this->Printer_Columns("C/T HS w/ Meal - £30", $£30Card, 30, 10, 4);
          $printer -> text("Card Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_cabmeal);
          $printer -> text($line_ctr20);
          $printer -> text($line_six);
          $printer -> text($line_ctr28);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> text($line_nine);
          $printer -> text($line_ten);
          $printer -> text($line_eleven);
          $printer -> text($line_twelve);
          $printer -> feed(2);
          //Acc
          $line_one = $this->Printer_Columns("Loyalty - £1", $£1Acc, 30, 10, 4);
          $line_two = $this->Printer_Columns("WiFi - £2", $£2Acc, 30, 10, 4);
          $line_three = $this->Printer_Columns("Shower - £3", $£3Acc, 30, 10, 4);
          $line_four = $this->Printer_Columns("Car / C/O - £6", $£6Acc, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab Only - £10", $£10AccCAB, 30, 10, 4);
          $line_cabmeal = $this->Printer_Columns("Cab Only + Meal - £18", $£18AccCAB, 30, 10, 4);
          $line_ctr20 = $this->Printer_Columns("CTR - £20", $£20Acc, 30, 10, 4);
          $line_six = $this->Printer_Columns("Cab Only + Sep - £22", $£22AccCAB, 30, 10, 4);
          $line_ctr28 = $this->Printer_Columns("CTR w/ Meal - £28", $£28Acc, 30, 10, 4);
          $line_seven = $this->Printer_Columns("Cab Only + Sep/Meal - £30", $£30AccCAB, 30, 10, 4);
          $line_eight = $this->Printer_Columns("C/T - £16", $£16Acc, 30, 10, 4);
          $line_nine = $this->Printer_Columns("C/T w/ WiFi - £18", $£18Acc, 30, 10, 4);
          $line_ten = $this->Printer_Columns("C/T HS/OS - £22", $£22Acc, 30, 10, 4);
          $line_eleven = $this->Printer_Columns("C/T w/ Meal - £24", $£24Acc, 30, 10, 4);
          $line_twelve = $this->Printer_Columns("C/T HS w/ Meal - £30", $£30Acc, 30, 10, 4);
          $printer -> text("Account Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_cabmeal);
          $printer -> text($line_ctr20);
          $printer -> text($line_six);
          $printer -> text($line_ctr28);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> text($line_nine);
          $printer -> text($line_ten);
          $printer -> text($line_eleven);
          $printer -> text($line_twelve);
          $printer -> feed(2);
          //SNAP&Fuel
          $line_one = $this->Printer_Columns("Loyalty - £1", $£1SNAP + $£1Fuel, 30, 10, 4);
          $line_two = $this->Printer_Columns("WiFi - £2", $£2SNAP + $£2Fuel, 30, 10, 4);
          $line_three = $this->Printer_Columns("Shower - £3", $£3SNAP + $£3Fuel, 30, 10, 4);
          $line_four = $this->Printer_Columns("Car / C/O - £6", $£6SNAP + $£6Fuel, 30, 10, 4);
          $line_five = $this->Printer_Columns("Cab Only - £10", $£10SNAPCAB + $£10FuelCAB, 30, 10, 4);
          $line_cabmeal = $this->Printer_Columns("Cab Only + Meal - £18", $£18SNAPCAB + $£18FuelCAB, 30, 10, 4);
          $line_ctr20 = $this->Printer_Columns("CTR - £20", $£20SNAP + $£20Fuel, 30, 10, 4);
          $line_six = $this->Printer_Columns("Cab Only + Sep - £22", $£22SNAPCAB + $£22FuelCAB, 30, 10, 4);
          $line_ctr28 = $this->Printer_Columns("CTR w/ Meal - £28", $£28SNAP + $£28Fuel, 30, 10, 4);
          $line_seven = $this->Printer_Columns("Cab Only + Sep/Meal - £30", $£30SNAPCAB + $£30FuelCAB, 30, 10, 4);
          $line_eight = $this->Printer_Columns("C/T - £16", $£16SNAP + $£16Fuel, 30, 10, 4);
          $line_nine = $this->Printer_Columns("C/T w/ WiFi - £18", $£18SNAP + $£18Fuel, 30, 10, 4);
          $line_ten = $this->Printer_Columns("C/T HS/OS - £22", $£22SNAP + $£22Fuel, 30, 10, 4);
          $line_eleven = $this->Printer_Columns("C/T w/ Meal - £24", $£24SNAP + $£24Fuel, 30, 10, 4);
          $line_twelve = $this->Printer_Columns("C/T HS w/ Meal - £30", $£30SNAP + $£30Fuel, 30, 10, 4);
          $printer -> text("SNAP & Fuel Sales");
          $printer -> feed();
          $printer -> text($line_one);
          $printer -> text($line_two);
          $printer -> text($line_three);
          $printer -> text($line_four);
          $printer -> text($line_five);
          $printer -> text($line_cabmeal);
          $printer -> text($line_ctr20);
          $printer -> text($line_six);
          $printer -> text($line_ctr28);
          $printer -> text($line_seven);
          $printer -> text($line_eight);
          $printer -> text($line_nine);
          $printer -> text($line_ten);
          $printer -> text($line_eleven);
          $printer -> text($line_twelve);
          $printer -> feed(2);
          $printer -> selectPrintMode();
          $printer-> cut();
        } finally {
          $printer->close();
        }
      }
      $this->mysql = null;
      $this->user = null;
      $this->payment = null;
    }
  }
?>
