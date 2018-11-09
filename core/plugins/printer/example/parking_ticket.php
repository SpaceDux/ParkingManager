<?php
/* Left margin & page width demo. */
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

if($_POST['site'] < 2) {
  /* Connector */
  $connector = new WindowsPrintConnector("smb://parking desk:pd@192.168.3.19/pdholyhead");
  $printer = new Printer($connector);

  $logo = EscposImage::load("resources/".$_POST['site']."/logo.png", false);
  $address = EscposImage::load("resources/".$_POST['site']."/address.png", false);
  $shower_img = EscposImage::load("resources/".$_POST['site']."/shower.jpg", false);
  $meal_img = EscposImage::load("resources/".$_POST['site']."/meal.jpg", false);
  $ticket_name = $_POST['ticket_name'];
  $gross = $_POST['gross'];
  $net = $_POST['net'];
  $company = $_POST['company'];
  $reg = $_POST['reg'];
  $date = $_POST['date'];
  $tid = $_POST['tid'];
  $charge = $_POST['payment_type'];
  $vat_no = $_POST['vat'];
  $expiry = $_POST['expiry'];
  $shower = $_POST['shower'];
  $meal = $_POST['meal'];
  $shower_count = $_POST['shower_count'];
  $meal_count = $_POST['meal_count'];

  $vat_rate = "20";

  $vat_pay = ($gross - $net);

  //Dates
  $date = date("d/m/Y H:i", strtotime($date));
  $expiry = date("d/m/Y H:i", strtotime($expiry));
  //Detail Columns
  $company_reg = new detail_col("Company: ".$company, 'Reg: '.$reg);
  $tid_date = new detail_col('T.ID: '.$tid, 'Date:  '.$date);
  $shower_details = new detail_col("Reg: ".$reg, "Exp: ".$expiry);
  $meal_details = new detail_col("Reg: ".$reg, "Exp: ".$expiry);

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
    $printer -> text($company_reg);
    $printer -> text($tid_date);
    //Ticket Dets
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer -> setTextSize(1, 1);
    $printer -> text("Expiry Date: ".$expiry."\n");
    $printer -> text("Payment Type: ".$charge."\n");
    $printer -> feed(2);
    //Address Details
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> graphics($address);
    $printer -> feed(1);
    $printer -> text("VAT No: ".$vat_no);
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
    //End ticket
    $printer -> cut();
    //Shower Ticket
    if($shower = 1) {
      if($shower_count == 1) {
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($shower_count == 2) {
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($shower_count == 3) {
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($shower_count == 4) {
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Shower Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($shower_img);
        $printer -> text("\n".$shower_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      }
    } else {
      //nothing
    }
    if($meal == 1) {
      if($meal_count == 1) {
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($meal_count == 2) {
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($meal_count == 3) {
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      } else if ($meal_count == 4) {
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
        //Meal Ticket
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($meal_img);
        $printer -> text("\n".$meal_details);
        $printer -> feed();
        //End Ticket
        $printer -> cut();
      }
    } else {
      //nothing
    }
  } finally {
    $printer -> close();
  }
} else if ($_POST['site'] == 2) {
    /* Connector */
    $connector = new WindowsPrintConnector("smb://parking desk:pd@parkingdesk/pdholyhead");
    $printer = new Printer($connector);

    $logo = EscposImage::load("resources/".$_POST['site']."/logo.png", false);
    $address = EscposImage::load("resources/".$_POST['site']."/address.png", false);
    $shower_img = EscposImage::load("resources/".$_POST['site']."/shower.jpg", false);
    $meal_img = EscposImage::load("resources/".$_POST['site']."/meal.jpg", false);
    $ticket_name = $_POST['ticket_name'];
    $gross = $_POST['gross'];
    $net = $_POST['net'];
    $company = $_POST['company'];
    $reg = $_POST['reg'];
    $date = $_POST['date'];
    $tid = $_POST['tid'];
    $charge = $_POST['payment_type'];
    $vat_no = $_POST['vat'];
    $expiry = $_POST['expiry'];
    $shower = $_POST['shower'];
    $meal = $_POST['meal'];
    $shower_count = $_POST['shower_count'];
    $meal_count = $_POST['meal_count'];

    $vat_rate = "20";

    $vat_pay = ($gross - $net);

    //Dates
    $date = date("d/m/Y H:i", strtotime($date));
    $expiry = date("d/m/Y H:i", strtotime($expiry));
    //Detail Columns
    $company_reg = new detail_col("Company: ".$company, 'Reg: '.$reg);
    $tid_date = new detail_col('T.ID: '.$tid, 'Date:  '.$date);
    $shower_details = new detail_col("Reg: ".$reg, "Exp: ".$expiry);
    $meal_details = new detail_col("Reg: ".$reg, "Exp: ".$expiry);

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
      $printer -> text("VAT @ 20%: Net £".$net." - £".number_format($vat_pay, 2));
      $printer -> feed(2);
      $printer -> selectPrintMode();
      //Vehicle Details
      $printer -> setJustification(Printer::JUSTIFY_LEFT);
      $printer -> setTextSize(1, 1);
      $printer -> text($company_reg);
      $printer -> text($tid_date);
      //Ticket Dets
      $printer -> setJustification(Printer::JUSTIFY_CENTER);
      $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
      $printer -> setTextSize(1, 1);
      $printer -> text("Expiry Date: ".$expiry."\n");
      $printer -> text("Payment Type: ".$charge."\n");
      $printer -> feed(2);
      //Address Details
      $printer -> setJustification(Printer::JUSTIFY_CENTER);
      $printer -> graphics($address);
      $printer -> feed(1);
      $printer -> text("VAT No: ".$vat_no);
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
      //End ticket
      $printer -> cut();
      //Shower Ticket
      if($shower = 1) {
        if($shower_count == 1) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($shower_count == 2) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($shower_count == 3) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($shower_count == 4) {
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Shower Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($shower_img);
          $printer -> text("\n".$shower_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        }
      } else {
        //nothing
      }
      if($meal == 1) {
        if($meal_count == 1) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($meal_count == 2) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($meal_count == 3) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        } else if ($meal_count == 4) {
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
          //Meal Ticket
          $printer -> setJustification(Printer::JUSTIFY_CENTER);
          $printer -> graphics($meal_img);
          $printer -> text("\n".$meal_details);
          $printer -> feed();
          //End Ticket
          $printer -> cut();
        }
      } else {
        //nothing
      }
    } finally {
      $printer -> close();
    }
  }

  class detail_col
  {
      private $leftSide;
      private $rightSide;

      public function __construct($leftSide = '', $rightSide = '')
      {
          $this -> leftSide = $leftSide;
          $this -> rightSide = $rightSide;
      }
      public function __toString()
      {
          $rightCols = 29;
          $leftCols = 19;

          $left = str_pad($this -> leftSide, $leftCols) ;
          $right = str_pad($this -> rightSide, $rightCols, ' ', STR_PAD_RIGHT);
          return "$left$right\n";
      }
  }
