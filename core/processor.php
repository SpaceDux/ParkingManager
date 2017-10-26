<?php
require_once __DIR__.'/manage/db.con.php';
$page = isset($_GET['p'])?$_GET['p']:'';
if ($page=='add') {
  $company = $_POST['company'];
  $reg = $_POST['reg'];
  $trlno = $_POST['trlno'];
  $type = $_POST['type'];
  $timein = $_POST['timein'];
  $tid = $_POST['tid'];
  $paid = $_POST['paid'];
  $column = $_POST['column'];
  //sql time
  $stmt = $dbConn->prepare("INSERT into parking VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, '', '0', '0')");
  $stmt->bindParam(1, strtoupper($company));
  $stmt->bindParam(2, strtoupper($reg));
  $stmt->bindParam(3, strtoupper($trlno));
  $stmt->bindParam(4, $type);
  $stmt->bindParam(5, $timein);
  $stmt->bindParam(6, $tid);
  $stmt->bindParam(7, $column);
  $stmt->bindParam(8, strtoupper($paid));
  $stmt->execute();
} else if ($page == 'update') {
//coming soon
} else if ($page == 'del') {
//coming soon
}