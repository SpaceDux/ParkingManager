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
    function Direction($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $group, $exitKey) {
      if($group == 1) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey);
      } else if ($group == 2) {
        $this->Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type);
      } else if ($group == 3) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey);
      }
    }
    //Begin Tickets
    //Print parking ticket
    function Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey) {
      $this->user = new User;
      $this->pm = new PM;
      $campus = $this->user->userInfo("campus");
      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->PM_SiteInfo($campus, "site_vat");
      $img_dir = $_SERVER['DOCUMENT_ROOT']."/ParkingManager/assets/img/printer/".$campus;
      //Printer Connection
      if($campus == 1) {
        //Holyhead
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 2) {
        //Cannock
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 0) {
        //Developer
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      }
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);
      $address = EscposImage::load($img_dir."/address.png", false);
      $shower_img = EscposImage::load($img_dir."/shower.jpg", false);
      $meal_img = EscposImage::load($img_dir."/meal.jpg", false);
      $date = date("d/m/Y H:i", strtotime($date));
      $expiry = date("d/m/Y H:i", strtotime($expiry));

      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);

      //Sorting column data
      $line_one = $this->Printer_Columns("Company: ".$company, "Reg: ".$reg, 18, 24, 2);
      $line_two = $this->Printer_Columns("ID: ".$tid, "Date: ".$date, 18, 24, 2);
      $line_info = $this->Printer_Columns("Reg: ".$reg, "Exp: ".$expiry, 18, 24, 2);
      //Begin print
      //Ticket Code
      try {
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($logo);
        $printer -> feed();
        // Name of Ticket
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
        $printer -> selectPrintMode();
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
        $printer -> text(" Exit Code: #".$exitKey." ");
        $printer -> setReverseColors(FALSE);
        $printer -> selectPrintMode();
        $printer -> feed(1);
        $printer -> graphics($address);
        $printer -> feed(1);
        $printer -> text("VAT No: ".$vatnum);
        $printer -> feed(2);
        $printer -> text("Thank you for staying with us!\n");
        $printer -> text("www.rktruckstops.co.uk");
        // $printer -> feed();
        // if($charge != "Account") {
        //   $printer -> setBarcodeHeight(40);
        //   $printer -> setBarcodeWidth(3);
        //   $printer -> barcode("000000002170", Printer::BARCODE_JAN13);
        // }
        $printer -> feed(1);
        //End Parking ticket
        $printer -> cut();
        $i = 1;
        while ($i++ <= $shower_count) {
          //Shower Ticket
          //$i++;
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$line_info);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        }
        $i = 1;
        while ($i++ <= $meal_count) {
          //Meal Ticket
          //$i++;
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$line_info);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
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
          $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
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
        $printer -> text("MERCHANT COPY\n");
        $printer -> feed(2);
        //VAT info
        $printer -> text("VAT No: ".$vatnum);
        $printer -> feed(2);
        $printer -> text("Thank you for staying with us!\n");
        $printer -> text("www.rktruckstops.co.uk");
        $printer -> feed();
        $printer -> cut();

      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
    }
    //Print 9pm Figures
    //Under Construction
    // function Printer_9PM() {
    //   $this->mysql = new MySQL;
    //   $this->user = new User;
    //   $this->payment = new Payment;
    //   $campus = $this->user->userInfo("campus");
    //   $date1 = date("Y-m-d 21:00:00");
    //   $date2 = date("Y-m-d 21:00:00", strtotime("-1 day"));
    //   //Query
    //   $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ?");
    //   $stmt->bindParam(1, $campus);
    //   $stmt->bindParam(2, $date2);
    //   $stmt->bindParam(3, $date1);
    //   $stmt->execute();
    //
    //   $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
    //   //Printer Connection
    //   if($campus == 1) {
    //     //Holyhead
    //     $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
    //   } else if ($campus == 2) {
    //     //Cannock
    //     $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
    //   } else if ($campus == 3) {
    //     //Developer
    //     $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
    //   }
    //   $printer = new Printer($connector);
    //   $logo = EscposImage::load($img_dir."/logo.png", false);
    //   if($campus == 1) {
    //     //Ticket Code
    //     try {
    //       //Settlement
    //       $printer -> setJustification(Printer::JUSTIFY_CENTER);
    //       $printer -> graphics($logo);
    //       $printer -> feed();
    //       $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
    //       $printer -> setTextSize(1, 1);
    //       // Name of Ticket
    //       $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //       $printer -> setJustification(Printer::JUSTIFY_CENTER);
    //       $printer -> setTextSize(1, 2);
    //       $printer -> setFont(Printer::FONT_A);
    //       $printer -> text("END OF DAY PARKING SETTLEMENT\n");
    //       $printer -> setTextSize(1, 1);
    //       $printer -> setFont(Printer::FONT_A);
    //       $printer -> text(date("d/m/y H:i", strtotime($date2))." - ".date("d/m/y H:i", strtotime($date1)));
    //       $printer -> feed(2);
    //       $printer -> selectPrintMode();
    //       $£3Cash = 0;
    //       $£6Cash = 0;
    //       $£10Cash = 0;
    //       $£15Cash = 0;
    //       $£18Cash = 0;
    //       $£23Cash = 0;
    //       //Card
    //       $£3Card = 0;
    //       $£6Card = 0;
    //       $£10Card = 0;
    //       $£15Card = 0;
    //       $£18Card = 0;
    //       $£23Card = 0;
    //       //Account
    //       $£3Acc = 0;
    //       $£6Acc = 0;
    //       $£10Acc = 0;
    //       $£15Acc = 0;
    //       $£18Acc = 0;
    //       $£23Acc = 0;
    //       //SNAP
    //       $£3SNAP = 0;
    //       $£6SNAP = 0;
    //       $£10SNAP = 0;
    //       $£15SNAP = 0;
    //       $£18SNAP = 0;
    //       $£23SNAP = 0;
    //       //FUEL
    //       $£3Fuel = 0;
    //       $£6Fuel = 0;
    //       $£10Fuel = 0;
    //       $£15Fuel = 0;
    //       $£18Fuel = 0;
    //       $£23Fuel = 0;
    //
    //       //Wash
    //       //Cash
    //       $Wash10Cash = 0;
    //       $Wash20Cash = 0;
    //       //Card
    //       $Wash10Card = 0;
    //       $Wash20Card = 0;
    //       //Account
    //       $Wash10Acc = 0;
    //       $Wash20Acc = 0;
    //       //SNAP
    //       $Wash10SNAP = 0;
    //       $Wash20SNAP = 0;
    //       //FUEL
    //       $Wash10Fuel = 0;
    //       $Wash20Fuel = 0;
    //       foreach ($stmt->fetchAll() as $row) {
    //         //Cash
    //         if($row['payment_type'] == 1 AND $row['payment_service_group'] != 2) {
    //           //CT
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£3Cash++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£6Cash++;
    //           } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Cash++;
    //           } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Cash++;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Cash+=2;
    //           } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Cash+=2;
    //           } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Cash+=3;
    //           } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Cash+=3;
    //           }
    //           //Cab
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£3Cash++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£6Cash++;
    //           } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Cash++;
    //           } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Cash++;
    //           } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Cash+=2;
    //           } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Cash+=2;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Cash+=3;
    //           } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Cash+=3;
    //           }
    //         } else if($row['payment_type'] == 1 AND $row['payment_service_group'] == 2){
    //           if($row['payment_price_gross'] == '7.50') {
    //             $Wash10Cash++;
    //           } else if($row['payment_price_gross'] == '12.00') {
    //             $Wash20Cash++;
    //           } else if($row['payment_price_gross'] == '19.50') {
    //             $Wash10Cash+=1;
    //             $Wash20Cash+=1;
    //           } else if($row['payment_price_gross'] == '24.00') {
    //             $Wash20Cash+=2;
    //           }
    //         }
    //         //Card
    //         if($row['payment_type'] == 2 AND $row['payment_service_group'] != 2) {
    //           //CT
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£3Card++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£6Card++;
    //           } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Card++;
    //           } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Card++;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Card+=2;
    //           } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Card+=2;
    //           } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Card+=3;
    //           } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Card+=3;
    //           }
    //           //Cab
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£3Card++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£6Card++;
    //           } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Card++;
    //           } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Card++;
    //           } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Card+=2;
    //           } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Card+=2;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Card+=3;
    //           } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Card+=3;
    //           }
    //         } else if($row['payment_type'] == 2 AND $row['payment_service_group'] == 2){
    //           if($row['payment_price_gross'] == '7.50') {
    //             $Wash10Card++;
    //           } else if($row['payment_price_gross'] == '12.00') {
    //             $Wash20Card++;
    //           } else if($row['payment_price_gross'] == '19.50') {
    //             $Wash10Card+=1;
    //             $Wash20Card+=1;
    //           } else if($row['payment_price_gross'] == '24.00') {
    //             $Wash20Card+=2;
    //           }
    //         }
    //         //Account
    //         if($row['payment_type'] == 3 AND $row['payment_service_group'] != 2) {
    //           //CT
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£3Acc++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£6Acc++;
    //           } else if($row['payment_price_gross'] == '15.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Acc++;
    //           } else if($row['payment_price_gross'] == '23.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Acc++;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Acc+=2;
    //           } else if($row['payment_price_gross'] == '46.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Acc+=2;
    //           } else if($row['payment_price_gross'] == '45.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£15Acc+=3;
    //           } else if($row['payment_price_gross'] == '69.00' AND $row['payment_vehicle_type'] != 2) {
    //             $£23Acc+=3;
    //           }
    //           //Cab
    //           if($row['payment_price_gross'] == '3.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£3Acc++;
    //           } else if($row['payment_price_gross'] == '6.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£6Acc++;
    //           } else if($row['payment_price_gross'] == '10.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Acc++;
    //           } else if($row['payment_price_gross'] == '18.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Acc++;
    //           } else if($row['payment_price_gross'] == '20.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Acc+=2;
    //           } else if($row['payment_price_gross'] == '36.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Acc+=2;
    //           } else if($row['payment_price_gross'] == '30.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£10Acc+=3;
    //           } else if($row['payment_price_gross'] == '54.00' AND $row['payment_vehicle_type'] == 2) {
    //             $£18Acc+=3;
    //           }
    //         } else if($row['payment_type'] == 3 AND $row['payment_service_group'] == 2){
    //           if($row['payment_price_gross'] == '7.50') {
    //             $Wash10Acc++;
    //           } else if($row['payment_price_gross'] == '12.00') {
    //             $Wash20Acc++;
    //           } else if($row['payment_price_gross'] == '19.50') {
    //             $Wash10Acc+=1;
    //             $Wash20Acc+=1;
    //           } else if($row['payment_price_gross'] == '24.00') {
    //             $Wash20Acc+=2;
    //           }
    //         }
    //       }
    //       $line_one = $this->Printer_Columns("3hr - £3", $£3Cash." / ".$£3Card." / ".$£3Acc." / ".$£3SNAP + $£3Fuel, 21, 21, 2);
    //       $line_two = $this->Printer_Columns("4hr / C/O - £6", $£6Cash."/".$£6Card."/ ".$£6Acc."/".$£6SNAP + $£6Fuel, 21, 21, 2);
    //       $line_three = $this->Printer_Columns("Cab Parking - £10", $£10Cash."/ ".$£10Card." / ".$£10Acc." / ".$£10SNAP + $£10Fuel, 21, 21, 2);
    //       $line_four = $this->Printer_Columns("C/T Parking - £15", $£15Cash." / ".$£15Card." / ".$£15Acc." / ".$£15SNAP + $£15Fuel, 21, 21, 2);
    //       $line_five = $this->Printer_Columns("Cab + Meal - £18", $£18Cash." / ".$£18Card." / ".$£18Acc." / ".$£18SNAP + $£18Fuel, 21, 21, 2);
    //       $line_six = $this->Printer_Columns("C/T + Meal - £23", $£23Cash." / ".$£23Card." / ".$£23Acc." / ".$£23SNAP + $£23Fuel, 21, 21, 2);
    //       $line_seven = $this->Printer_Columns("10min Wash - £7.50", $Wash10Cash." / ".$Wash10Card." / ".$Wash10Acc." / ".$Wash10SNAP+$Wash10Fuel, 21, 21, 2);
    //       $line_eight = $this->Printer_Columns("20min Wash - £12", $Wash20Cash." / ".$Wash20Card."/".$Wash20Acc." / ".$Wash20SNAP+$Wash20Fuel, 21, 21, 2);
    //       $printer -> text("Total Sales\n");
    //       $printer -> text("Cash / Card / Acc / SNAP&Fuel Sales\n");
    //       $printer -> feed();
    //       $printer -> text($line_one);
    //       $printer -> text($line_two);
    //       $printer -> text($line_three);
    //       $printer -> text($line_four);
    //       $printer -> text($line_five);
    //       $printer -> text($line_six);
    //       $printer -> text($line_seven);
    //       $printer -> text($line_eight);
    //       $printer -> feed(2);
    //       $printer-> cut();
    //     } finally {
    //       $printer->close();
    //     }
    //   } else if ($campus == 2) {
    //     //Cannock EOD
    //   }
    //   $this->mysql = null;
    //   $this->user = null;
    //   $this->payment = null;
    // }
    //Working

    function Printer_9PM() {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
      $date1 = date("Y-m-d 21:00:00");
      $date2 = date("Y-m-d 21:00:00", strtotime("-1 day"));
      //Query
      $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ?");
      $stmt->bindParam(1, $campus);
      $stmt->bindParam(2, $date2);
      $stmt->bindParam(3, $date1);
      $stmt->execute();

      $img_dir = $_SERVER['DOCUMENT_ROOT']."/assets/img/printer/".$campus;
      //Printer Connection
      if($campus == 1) {
        //Holyhead
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 2) {
        //Cannock
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 3) {
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
          $printer -> text(date("d/m/y H:i", strtotime($date2))." - ".date("d/m/y H:i", strtotime($date1)));
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
          $Wash10Snap = 0;
          $Wash20Snap = 0;
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
            } else if($row['payment_type'] == 2 AND $row['payment_service_group'] == 2){
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
          $printer -> selectPrintMode();
          $printer-> cut();
        } finally {
          $printer->close();
        }
      } else if ($campus == 2) {
        //Cannock EOD
      }
      $this->mysql = null;
      $this->user = null;
      $this->payment = null;
    }
  }
?>
