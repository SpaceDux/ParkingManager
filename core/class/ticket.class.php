<?php
  namespace ParkingManager;
  use Mike42\Escpos\Printer;
  use Mike42\Escpos\EscposImage;
  use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

  class Ticket {
    public $ImgDir;
    function __construct() {
      $this->ImgDir = $_SERVER['DOCUMENT_ROOT'].'/printerImg/';
    }
    //Print Columns on ticket.
    function Printer_Columns($leftCol, $rightCol, $leftWidth, $rightWidth, $space = 0)
    {
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
    function Direction($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $group, $exitKey, $discount_count, $wifi_count, $acc_id, $printed, $Processed)
    {
      if($group == 2) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count, $acc_id, $printed, $Processed);
      } else if ($group == 4) {
        $this->Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type, $exitKey);
      } else if ($group == 3) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count, $acc_id, $printed, $Processed);
      } else if ($group == 1) {
        $this->Printer_Misc($shower_count, $wifi_count, $tid, $payment_type, $gross, $net, $Processed);
      } else if($group == 5) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count, $acc_id, $printed, $Processed);
      } else if($group == 6) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count, $acc_id, $printed, $Processed);
      }
    }
    //Begin Tickets
    //Print parking ticket
    function Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $exitKey, $discount_count, $acc_id, $printed, $Processed)
    {
      $this->user = new User;
      $this->pm = new PM;
      $this->account = new Account;

      $campus = $this->user->Info("Site");
      $printer_id = $this->user->Info("Printer");
      //VAT Information
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->Site_Info($campus, "Vatno");
      $img_dir = $this->ImgDir.$campus;
      //Printer connection
      if($printer_id == 2) {
        // Short term fix
        $connector = new WindowsPrintConnector('pdhollies');
      } else {
        $connector = new WindowsPrintConnector('smb://'.$this->pm->PrinterInfo($printer_id, "User").':'.$this->pm->PrinterInfo($printer_id, "Pass").'@'.$this->pm->PrinterInfo($printer_id, "IP").'/'.$this->pm->PrinterInfo($printer_id, "SharedName").'');
      }
      $printer = new Printer($connector);
      $logo = EscposImage::load($img_dir."/logo.png", false);
      $address = EscposImage::load($img_dir."/address.png", false);
      $shower_img = EscposImage::load($img_dir."/shower.jpg", false);
      $meal_img = EscposImage::load($img_dir."/meal4.jpg", false);
      $discount_img = EscposImage::load($img_dir."/discount.jpg", false);
      $date = date("d/m/Y H:i", strtotime($date));
      $expiry = date("d/m/Y H:i", strtotime($expiry));
      $Processed = date("d/m/Y H:i", strtotime($Processed));

      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);

      //Sorting column data
      $line_one = $this->Printer_Columns("Company: ".strtoupper($company), "Reg: ".strtoupper($reg), 18, 24, 2);
      $line_two = $this->Printer_Columns("Valid From: ".$date, "", 30, 12, 2);
      $line_info = $this->Printer_Columns("Reg: ".strtoupper($reg), "Exp: ".$expiry, 18, 24, 2);
      $line_merch = $this->Printer_Columns("Method: ".strtoupper($payment_type), "Time: ".$Processed, 18, 24, 2);
      $priceGN = $this->Printer_Columns("Gross: £".$gross, "Nett: £".$net, 20, 20, 2);
      //Begin print
      //Ticket Code
      try {
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
    		if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
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
          $printer -> text("VAT @ 20%: Nett £".$net." - £".number_format($vat_pay, 2));
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
    		if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
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
        if($printed < 100) {
          $i = 1;
          //Shower
          while ($i++ <= $shower_count) {
            //Shower Ticket
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
      			if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
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
      			if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
      				$printer -> graphics($meal_img);
      			} else {
      				$printer -> bitImage($meal_img);
      			}
            $printer -> text("\n".$line_info);
            //End Ticket
            $printer -> cut(Printer::CUT_PARTIAL);
      			if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
      				$printer -> graphics($meal_img);
      			} else {
      				$printer -> bitImage($meal_img);
      			}
            $printer -> text("\n".$line_info);
            $printer->selectPrintMode();
            //End Ticket
            $printer -> cut(Printer::CUT_PARTIAL);
          }
          $i = 1;
          //Discount
          while ($i++ <= $discount_count) {
            if($payment_type == "Account" AND $this->account->Account_GetInfo($acc_id, "Discount_Vouchers") == 0) {
              //Do nothing
            } else {
              $printer -> setJustification(Printer::JUSTIFY_CENTER);
              if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
                $printer -> graphics($discount_img);
              } else {
                $printer -> bitImage($discount_img);
              }
              $printer -> text("\n".$line_info);
			        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
              $printer -> text("\n MINIMUM SPEND £3");
			        $printer -> feed();
              $printer -> text("1 Voucher Per Transaction!");
              $printer -> feed();
              $printer->selectPrintMode();
              //End Ticket
              $printer -> cut(Printer::CUT_PARTIAL);
            }
          }
        }
        //Merchant Ticket
        if($payment_type == "Cash" || $payment_type == "Card") {
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
            $printer -> graphics($logo);
          } else {
            $printer -> bitImage($logo);
          }
          $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
          $printer -> feed(1);
          $printer -> text($tid."\n");
          $printer -> feed(1);
          $printer -> text($priceGN."\n");
          $printer -> feed(1);
          $printer -> text($line_merch);
          $printer -> selectPrintMode();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        }

      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
      $this->account = null;
    }
    //Print Truckwash Ticket
    function Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type, $exitKey)
    {
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");
      $printer_id = $this->user->Info("Printer");

      //VAT Information
      $vat_rate = "20";
      $vat_pay = ($gross - $net);
      $vatnum = $this->pm->Site_Info($campus, "Vatno");
      $img_dir = $this->ImgDir.$campus;
      //Limit amount of chars in company name.
      $company = substr($company, 0, 9);
      //Printer Connections
      if($printer_id == 2) {
        // Short term fix
        $connector = new WindowsPrintConnector('pdhollies');
      } else {
        $connector = new WindowsPrintConnector('smb://'.$this->pm->PrinterInfo($printer_id, "User").':'.$this->pm->PrinterInfo($printer_id, "Pass").'@'.$this->pm->PrinterInfo($printer_id, "IP").'/'.$this->pm->PrinterInfo($printer_id, "SharedName").'');
      }
      try {
        $printer = new Printer($connector);
        $ticket = EscposImage::load($img_dir."/wash.jpg", false);
        $date = date("d/m/Y H:i", strtotime($date));

        $line_one = $this->Printer_Columns("Company: ".$company, "Reg: ".$reg, 18, 24, 2);
        $line_two = $this->Printer_Columns("TID: ".$tid, "Date: ".$date, 18, 24, 2);

        // Name of Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
          $printer -> graphics($ticket);
        } else {
          $printer -> bitImage($ticket);
		  if($payment_type == "Cash" || $payment_type == "Card") {
			$printer -> pulse(0, 120, 240);
		  }
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
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setReverseColors(TRUE);
        $printer -> setTextSize(2, 2);
        $printer -> text(" Exit Code: *".$exitKey."# ");
        $printer -> setReverseColors(FALSE);#
        $printer -> setTextSize(1, 1);
        //VAT info
        $printer -> feed(2);
        if($campus == "201908291533552768") {
          $printer -> text("THIS TRUCKWASH IS OPERATED BY:\n");
          $printer -> text("M&L Truck Wash Services Ltd.\n");
        } else {
          $printer -> text("Thank you for staying with us!\n");
          $printer -> text("www.rktruckstops.co.uk");
        }
        $printer -> feed();
        $printer -> cut();
        //Merchant Copy
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
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
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setReverseColors(TRUE);
        $printer -> setTextSize(2, 2);
        $printer -> text(" Exit Code: *".$exitKey."# ");
        $printer -> setReverseColors(FALSE);
        $printer -> setTextSize(1, 1);
        //VAT info
        $printer -> feed(2);
        if($campus == "2") {
          $printer -> text("THIS TRUCKWASH IS OPERATED BY:\n");
          $printer -> text("M&L Truck Wash Services Ltd.\n");
        } else {
          $printer -> text("Thank you for staying with us!\n");
          $printer -> text("www.rktruckstops.co.uk");
        }
        $printer -> feed();
        $printer -> cut(Printer::CUT_PARTIAL);

      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
      $this->account = null;
    }
    // Wifi & Shower
    function Printer_Misc($shower_count, $wifi_count, $tid, $payment_type, $gross, $net, $Processed)
    {
      $this->user = new User;
      $this->pm = new PM;

      $campus = $this->user->Info("Site");
      $printer_id = $this->user->Info("Printer");

      $img_dir = $this->ImgDir.$campus;

      try {

        //Printer Connection
        if($printer_id == 2) {
          // Short term fix
          $connector = new WindowsPrintConnector('pdhollies');
        } else {
          $connector = new WindowsPrintConnector('smb://'.$this->pm->PrinterInfo($printer_id, "User").':'.$this->pm->PrinterInfo($printer_id, "Pass").'@'.$this->pm->PrinterInfo($printer_id, "IP").'/'.$this->pm->PrinterInfo($printer_id, "SharedName").'');
        }
        $printer = new Printer($connector);
        $wifi = EscposImage::load($img_dir."/wifi.jpg", false);
        $shower  = EscposImage::load($img_dir."/shower.jpg", false);
        $logo = EscposImage::load($img_dir."/logo.png", false);
        if($payment_type == "Cash" || $payment_type == "Card") {
          $printer -> pulse(0, 120, 240);
        }
        $i = 1;
        $line_merch = $this->Printer_Columns("Method: ".strtoupper($payment_type), "Time: ".date("d/m/y H:i", strtotime($Processed)), 18, 24, 2);
        $priceGN = $this->Printer_Columns("Gross: £".$gross, "Nett: £".$net, 20, 20, 2);
        //WIFI
        while ($i++ <= $wifi_count) {
          // Generate Voucher
          $code = $this->pm->Create_WiFi_Voucher($campus);
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
            $printer -> graphics($wifi);
          } else {
            $printer -> bitImage($wifi);
          }
          $printer -> feed();
          $printer -> setTextSize(2, 2);
          $printer -> text('WiFi Code: '.$code);
          $printer -> feed();
          $printer -> setTextSize(1, 1);
          if($campus != 1) {
            $printer -> text("Please connect to; Customer Lorry Park");
          } else {
            $printer -> text("Please connect to; Parc-Cybi-Car-Park");
          }
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
        //Merchant Ticket
        if($payment_type == "Cash" || $payment_type == "Card") {
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
            $printer -> graphics($logo);
          } else {
            $printer -> bitImage($logo);
          }
          $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
          $printer -> feed(1);
          $printer -> text($tid."\n");
          $printer -> feed(1);
          $printer -> text($priceGN."\n");
          $printer -> feed(1);
          $printer -> text($line_merch);
          $printer -> selectPrintMode();
          //End Ticket
          $printer -> cut(Printer::CUT_PARTIAL);
        } else {

        }
      } finally {
        $printer -> close();
      }
      $this->user = null;
      $this->pm = null;
    }
    // End of Day settlement
    function EOD_Settlement($date1, $date2)
    {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->pm = new PM;
      $this->payment = new Payment;
      $campus = $this->user->Info("Site");
      $printer_id = $this->user->Info("Printer");
      if($campus == '201908291533552768') {
        $date1 = date("Y-m-d 21:30:00", strtotime($date1));
        $date2 = date("Y-m-d 21:30:00", strtotime($date2));
      } else {
        $date1 = date("Y-m-d 21:00:00", strtotime($date1));
        $date2 = date("Y-m-d 21:00:00", strtotime($date2));
      }

      $img_dir = $this->ImgDir.$campus;

      try {
        //Printer Connection
        if($printer_id == 2) {
          // Short term fix
          $connector = new WindowsPrintConnector('pdhollies');
        } else {
          $connector = new WindowsPrintConnector('smb://'.$this->pm->PrinterInfo($printer_id, "User").':'.$this->pm->PrinterInfo($printer_id, "Pass").'@'.$this->pm->PrinterInfo($printer_id, "IP").'/'.$this->pm->PrinterInfo($printer_id, "SharedName").'');
        }
        $printer = new Printer($connector);
        $logo = EscposImage::load($img_dir."/logo.png", false);
        //Settlement
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        if($this->pm->PrinterInfo($printer_id, "BitImage") == 0) {
          $printer -> graphics($logo);
        } else {
          $printer -> bitImage($logo);
        }
        $printer -> feed();
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> setTextSize(1, 1);
        // Name of Ticket
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(1, 2);
        $printer -> setFont(Printer::FONT_A);
        $printer -> text("END OF DAY PARKING SETTLEMENT\n");
        $printer -> feed();
        $printer -> text("Time of Settlement - ".date("H:i:s")."\n");
        $printer -> feed();
        $printer -> setTextSize(1, 1);
        $printer -> setFont(Printer::FONT_A);
        $printer -> text(date("d/m/y H:i", strtotime($date1))." - ".date("d/m/y H:i", strtotime($date2)));
        $printer -> feed(2);
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Cash Figures");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> feed();
        // Group Cash
        $group = $this->mysql->dbc->prepare("SELECT * FROM settlement_groups WHERE Site = ? AND Deleted < 1 ORDER BY Set_Order ASC");
        $group->bindParam(1, $campus);
        $group->execute();
        $group_results = $group->fetchAll();
        foreach($group_results as $row) {
          $value=0;
          $srv = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Site = ? AND Method = 1 AND Settlement_Group = ? AND Deleted < 1 AND Processed_Time BETWEEN ? AND ?");
          $srv->bindValue(1, $campus);
          $srv->bindValue(2, $row['Uniqueref']);
          $srv->bindValue(3, $date1);
          $srv->bindValue(4, $date2);
          $srv->execute();
          foreach($srv->fetchAll() as $service) {
            $multi = $service['Settlement_Multi'];
            $value += $multi;
          }
          $line = $this->Printer_Columns($row['Name']." - ", $value, 30, 10, 4);
          $printer -> text($line);
        }
        $printer -> feed();
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Card Figures");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> feed();
        foreach($group_results as $row) {
          $value=0;
          $srv = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Site = ? AND Method = 2 AND Settlement_Group = ? AND Deleted < 1 AND Processed_Time BETWEEN ? AND ?");
          $srv->bindValue(1, $campus);
          $srv->bindValue(2, $row['Uniqueref']);
          $srv->bindValue(3, $date1);
          $srv->bindValue(4, $date2);
          $srv->execute();
          foreach($srv->fetchAll() as $service) {
            $multi = $service['Settlement_Multi'];
            $value += $multi;
          }
          $line = $this->Printer_Columns($row['Name']." - ", $value, 30, 10, 4);
          $printer -> text($line);
        }
        $printer -> feed();
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Account Figures");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> feed();
        foreach($group_results as $row) {
          $value=0;
          $srv = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Site = ? AND Method = 3 AND Settlement_Group = ? AND Deleted < 1 AND Processed_Time BETWEEN ? AND ?");
          $srv->bindValue(1, $campus);
          $srv->bindValue(2, $row['Uniqueref']);
          $srv->bindValue(3, $date1);
          $srv->bindValue(4, $date2);
          $srv->execute();
          foreach($srv->fetchAll() as $service) {
            $multi = $service['Settlement_Multi'];
            $value += $multi;
          }
          $line = $this->Printer_Columns($row['Name']." - ", $value, 30, 10, 4);
          $printer -> text($line);
        }
        $printer -> feed();
        $printer -> selectPrintMode();
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("ETP Figures");
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> feed();
        foreach($group_results as $row) {
          $value=0;
          $srv = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Site = ? AND Method >= 4 AND Settlement_Group = ? AND Deleted < 1 AND Processed_Time BETWEEN ? AND ?");
          $srv->bindValue(1, $campus);
          $srv->bindValue(2, $row['Uniqueref']);
          $srv->bindValue(3, $date1);
          $srv->bindValue(4, $date2);
          $srv->execute();
          foreach($srv->fetchAll() as $service) {
            $multi = $service['Settlement_Multi'];
            $value += $multi;
          }
          $line = $this->Printer_Columns($row['Name']." - ", $value, 30, 10, 4);
          $printer -> text($line);
        }
        $printer -> feed(2);
        $printer -> cut(Printer::CUT_PARTIAL);
      } finally {
        $printer -> close();
      }
      $this->mysql = null;
    }
  }
?>
