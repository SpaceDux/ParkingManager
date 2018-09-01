<?php
/* Left margin & page width demo. */
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/* Connector */
$connector = new WindowsPrintConnector("smb://PARKINGDESK/citizen");
$printer = new Printer($connector);
//Initialize Logo
$logo = EscposImage::load("interface/logo.png");
//Receipt Content
//Logo
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("_________________________________________ \n");//41 Chars
$printer -> graphics($logo);
$printer -> feed(2);
//Content
//Pricing
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
$printer -> setFont(Printer::FONT_A);
$printer -> setTextSize(2, 2);
$printer -> text("24HR Parking \n");
$printer -> feed(1);
$printer -> setFont(Printer::FONT_A);
$printer -> setTextSize(3, 2);
$printer -> text("£15 \n");
$printer -> feed(2);
//Details



/* Printer shutdown */
$printer -> cut();
$printer -> close();
