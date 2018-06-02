<?php
  require_once __DIR__.'/manage/dbcon.php';
  $page = isset($_GET['p'])?$_GET['p']:'';

  if($page == 'add') {
    $company = $_POST['company'];
    $registration = $_POST['reg'];
    $trailer = $_POST['trlno'];
    $type = $_POST['type'];
    $timein = $_POST['timein'];

    $sql = "INSERT INTO parking VALUES ('', ?, ?, ?, ?, ?, '', '1', '', '', '0', '0', '', '')";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, strtoupper($company));
    $stmt->bindParam(2, strtoupper($registration));
    $stmt->bindParam(3, strtoupper($trailer));
    $stmt->bindParam(4, $type);
    $stmt->bindParam(5, $timein);

    $stmt->execute();

    //Table Structure for parking;
    // id,
    // company,
    // reg,
    // trlno,
    // type,
    // timein,
    // tid,
    // col,
    // paid,
    // timeout,
    // flag,
    // h_light,
    // comment,
    // tt
  } if ($page == 'addPayment') {
    $veh_id = $_POST['veh_id'];
    $tid = $_POST['tid'];
    $tot = $_POST['tot'];

    $sql = "INSERT INTO payments VALUES ('', ?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $veh_id);
    $stmt->bindParam(2, $tid);
    $stmt->bindParam(3, $tot);
    $stmt->bindParam(4, date("Y-m-d H:i:s"));
    $stmt->execute();

    $upd = $dbConn->prepare("UPDATE parking SET col = '2' WHERE id = ?");
    $upd->bindParam(1, $veh_id);
    $upd->execute();
  } if ($page == 'addPaymentRenew') {
    $veh_id = $_POST['veh_id'];
    $tid = $_POST['tid'];
    $tot = $_POST['tot'];

    if(isset($veh_id) && $veh_id > 1) {
    $sql = "INSERT INTO payments VALUES ('', ?, ?, ?, ?)";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(1, $veh_id);
    $stmt->bindParam(2, $tid);
    $stmt->bindParam(3, $tot);
    $stmt->bindParam(4, date("Y-m-d H:i:s"));
    $stmt->execute();
  } else {};

    $upd = $dbConn->prepare("UPDATE parking SET h_light = '0' WHERE id = ?");
    $upd->bindParam(1, $veh_id);
    $upd->execute();
  } if ($page == 'quickExit') {
    $veh_id = $_POST['veh_id'];

    $stmt = $dbConn->prepare("UPDATE parking SET col = '3', timeout = :timeout WHERE id = :id");
    $stmt->bindParam(':timeout', date("Y-m-d H:i:s"));
    $stmt->bindParam(':id', $veh_id);
    $stmt->execute();
  } if ($page == 'markRenewal') {
    $veh_id = $_POST['veh_id'];

    $stmt = $dbConn->prepare("UPDATE parking SET h_light = '1' WHERE id = :id");
    $stmt->bindParam(':id', $veh_id);
    $stmt->execute();
  } if ($page == 'unmarkRenewal') {
    $veh_id = $_POST['veh_id'];

    $stmt = $dbConn->prepare("UPDATE parking SET h_light = '0' WHERE id = :id");
    $stmt->bindParam(':id', $veh_id);
    $stmt->execute();
  } if ($page == 'setFlag') {
   $veh_id = $_POST['veh_id'];

   $stmt = $dbConn->prepare("UPDATE parking SET flag = '1' WHERE id = :id");
   $stmt->bindParam(':id', $veh_id);
   $stmt->execute();
 } if ($page == 'unsetFlag') {
  $veh_id = $_POST['veh_id'];

  $stmt = $dbConn->prepare("UPDATE parking SET flag = '0' WHERE id = :id");
  $stmt->bindParam(':id', $veh_id);
  $stmt->execute();
} if ($page == 'delVeh') {
  $veh_id = $_POST['veh_id'];

  $stmt = $dbConn->prepare("UPDATE parking SET col = '4' WHERE id = :id");
  $stmt->bindParam(':id', $veh_id);
  $stmt->execute();
}

?>
