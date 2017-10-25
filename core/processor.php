<?php
require_once __DIR__.'/manage/db.con.php';
$page = isset($_GET['p'])?$_GET['p']:'';
if ($page=='add') {
  $company = $_POST['company'];
  $reg = $_POST['reg'];
  $type = $_POST['type'];
  $timein = $_POST['timein'];
  $tid = $_POST['tid'];
  $paid = $_POST['paid'];
  $column = $_POST['column'];
  //sql time
  $stmt = $dbConn->prepare("INSERT into parking VALUES ('', ?, ?, ?, ?, ?, ?, ?, '')");
  $stmt->bindParam(1, $company);
  $stmt->bindParam(2, $reg);
  $stmt->bindParam(3, $type);
  $stmt->bindParam(4, $timein);
  $stmt->bindParam(5, $tid);
  $stmt->bindParam(6, $column);
  $stmt->bindParam(7, $paid);
  $stmt->execute();
} else if ($page == 'update') {
//coming soon
} else if ($page == 'del') {
//coming soon
}