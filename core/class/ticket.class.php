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
    function Direction($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count, $group) {
      if($group == 1) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count);
      } else if ($group == 2) {
        $this->Printer_TruckWash($ticket_name, $gross, $net, $company, $reg, $tid, $date, $payment_type);
      } else if ($group == 3) {
        $this->Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count);
      }
    }
    //Begin Tickets
    //Print parking ticket
    function Printer_ParkingTicket($ticket_name, $gross, $net, $company, $reg, $tid, $date, $expiry, $payment_type, $meal_count, $shower_count) {
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
        $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
      } else if ($campus == 3) {
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
        $printer -> feed(2);
        //Address Details
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
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
    function Printer_9PM() {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
      $date1 = date("Y-m-d 21:00:00");
      $date2 = date("Y-m-d 21:00:00", strtotime("-1 day"));
      //Cash Query
      $stmt1 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_type = 1 AND payment_deleted = 0 AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id");
      $stmt1->bindParam(1, $campus);
      $stmt1->bindParam(2, $date2);
      $stmt1->bindParam(3, $date1);
      $stmt1->execute();
      $result1 = $stmt1->fetchAll();
      //Card Query
      $stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_type = 2 AND payment_deleted = 0 AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id");
      $stmt2->bindParam(1, $campus);
      $stmt2->bindParam(2, $date2);
      $stmt2->bindParam(3, $date1);
      $stmt2->execute();
      $result2 = $stmt2->fetchAll();
      //Account Query
      $stmt3 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_type = 3 AND payment_deleted = 0 AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id");
      $stmt3->bindParam(1, $campus);
      $stmt3->bindParam(2, $date2);
      $stmt3->bindParam(3, $date1);
      $stmt3->execute();
      $result3 = $stmt3->fetchAll();
      //SNAP Query
      $stmt4 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_type = 4 AND payment_deleted = 0 AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id");
      $stmt4->bindParam(1, $campus);
      $stmt4->bindParam(2, $date2);
      $stmt4->bindParam(3, $date1);
      $stmt4->execute();
      $result4 = $stmt4->fetchAll();
      //FUEL Query
      $stmt5 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_campus = ? AND payment_type = 5 AND payment_deleted = 0 AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id");
      $stmt5->bindParam(1, $campus);
      $stmt5->bindParam(2, $date2);
      $stmt5->bindParam(3, $date1);
      $stmt5->execute();
      $result5 = $stmt5->fetchAll();

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
        $printer -> text("Cash Sales");
        foreach ($result1 as $row) {
          $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
          $line = $this->Printer_Columns($row['payment_service_name'], $this->payment->Payment_Count($row['payment_service_id'], 1, $date2, $date1), 30, 10, 2);
          $printer -> feed();
          $printer -> text($line);
        }
        $printer -> selectPrintMode();
        $printer -> feed(2);
        $printer -> text("Card Sales");
        foreach ($result2 as $row) {
          $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
          $line = $this->Printer_Columns($row['payment_service_name'], $this->payment->Payment_Count($row['payment_service_id'], 2, $date2, $date1), 30, 10, 2);
          $printer -> feed();
          $printer -> text($line);
        }
        $printer -> selectPrintMode();
        $printer -> feed(2);
        $printer -> text("Account Sales");
        foreach ($result3 as $row) {
          $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
          $line = $this->Printer_Columns($row['payment_service_name'], $this->payment->Payment_Count($row['payment_service_id'], 3, $date2, $date1), 30, 10, 2);
          $printer -> feed();
          $printer -> text($line);
        }
        $printer -> selectPrintMode();
        $printer -> feed(2);
        $printer -> text("SNAP Sales");
        foreach ($result4 as $row) {
          $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
          $line = $this->Printer_Columns($row['payment_service_name'], $this->payment->Payment_Count($row['payment_service_id'], 4, $date2, $date1), 30, 10, 2);
          $printer -> feed();
          $printer -> text($line);
        }
        $printer -> selectPrintMode();
        $printer -> feed(2);
        $printer -> text("Fuel Card Sales");
        foreach ($result5 as $row) {
          $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
          $line = $this->Printer_Columns($row['payment_service_name'], $this->payment->Payment_Count($row['payment_service_id'], 5, $date2, $date1), 30, 10, 2);
          $printer -> feed();
          $printer -> text($line);
        }
        $printer -> feed(2);
        $printer -> selectPrintMode();
        $printer-> cut();
      } finally {
        $printer->close();
      }
      $this->mysql = null;
      $this->user = null;
      $this->payment = null;
    }
  }
?>
