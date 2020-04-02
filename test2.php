<?php
require 'global.php';

$campus = '201908291533552768';
$CashValue = 0;
$CardValue = 0;
$date1 = $_POST['Date1'];
$date2 = $_POST['Date2'];
$srv = $mysql->dbc->prepare("SELECT * FROM transactions WHERE Site = ? AND Method < 3 AND Deleted < 1  AND Kiosk = 1 AND Processed_Time BETWEEN ? AND ?");
$srv->bindValue(1, $campus);
$srv->bindValue(2, $date1);
$srv->bindValue(3, $date2);
$srv->execute();
foreach($srv->fetchAll() as $row) {
  if($row['Method'] == 1) {
    $CashValue += $row['Gross'];
  }
  if($row['Method'] == 2) {
    $CardValue += $row['Gross'];
  }
}
echo 'Cash: £'.number_format($CashValue, 2).'<br>Card: £'.number_format($CardValue, 2);

 ?>
