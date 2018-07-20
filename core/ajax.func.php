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
} if ($page == 'deletePayment') {
  $veh_id = $_POST['veh_id'];

  $stmt = $dbConn->prepare("DELETE FROM payments WHERE id = :id");
  $stmt->bindParam(':id', $veh_id);
  $stmt->execute();
} if ($page == 'updPaymentGet') {
  $pay_id = $_POST['pay_id'];

  $stmt = $dbConn->prepare("SELECT * FROM payments WHERE id = :id");
  $stmt->bindParam(':id', $pay_id);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo json_encode($row);
} if ($page == 'updPayment') {
  $pay_id = $_POST['id'];
  $tid = $_POST['tid'];
  $tot = $_POST['tot'];

  $stmt = $dbConn->prepare("UPDATE payments SET ticket_id = :tid, tot = :tot WHERE id = :id");
  $stmt->bindParam(':id', $pay_id);
  $stmt->bindParam(':tid', $tid);
  $stmt->bindParam(':tot', $tot);
  $stmt->execute();
} if ($page == 'delNotice') {
  $nid = $_POST['notice_id'];

  $stmt = $dbConn->prepare("UPDATE notices SET active = '0' WHERE id = :id");
  $stmt->bindParam(':id', $nid);
  $stmt->execute();
} if ($page == 'searchData') {
  $searchStr = '%'.$_POST['search'].'%';
  $return = '';

  $stmt = $dbConn->prepare("SELECT * FROM parking WHERE company LIKE ? OR reg LIKE ? OR trlno LIKE ? OR timein LIKE ? OR timeout LIKE ?  ORDER BY id DESC LIMIT 100");
  $stmt->bindParam(1, $searchStr);
  $stmt->bindParam(2, $searchStr);
  $stmt->bindParam(3, $searchStr);
  $stmt->bindParam(4, $searchStr);
  $stmt->bindParam(5, $searchStr);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if($stmt->rowCount() > 0) {
      $return .= '
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Company</th>
            <th scope="col">Reg</th>
            <th scope="col">Trailer</th>
            <th scope="col">Type</th>
            <th scope="col">Time IN</th>
            <th scope="col">Time OUT</th>
            <th scope="col"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
      ';
        $return .= '<tbody>';
            foreach($result as $row) {
              if ($row['type'] == 1) {
               $type = "C/T";
             } else if ($row['type'] == 2) {
               $type = "CAB";;
             } else if ($row['type'] == 3) {
               $type = "TRL";
             } else if ($row['type'] == 4) {
               $type = "RIGID";
             } else if ($row['type'] == 5) {
               $type = "COACH";
             } else if ($row['type'] == 6) {
               $type = "CAR";
             } else if ($row['type'] == 7) {
               $type = "M/H";
             } else if ($row['type'] == 0) {
               $type = "N/A";
             }
              $return .= '
            <tr>
              <td>'.$row['company'].'</td>
              <td>'.$row['reg'].'</td>
              <td>'.$row['trlno'].'</td>
              <td>'.$type.'</td>
              <td>'.$row['timein'].'</td>
              <td>'.$row['timeout'].'</td>
              <td><a class="btn btn-danger" href="'.$url.'/update/'.$row['id'].'"><i class="fa fa-cog"></i></a></td>
            </tr>
          ';
        }
        $return .= '</tbody></table>';
      echo $return;
  } else {
    echo "No data found";
  }
} if ($page == 'searchPay') {
  $searchStr = '%'.$_POST['search'].'%';
  $return = '';

  $stmt = $dbConn->prepare("SELECT * FROM payments WHERE ticket_id LIKE ? LIMIT 40");
  $stmt->bindParam(1, $searchStr);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if($stmt->rowCount() > 0) {
      $return .= '
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Ticket ID</th>
            <th scope="col">Service Date</th>
            <th scope="col"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
      ';
        $return .= '<tbody>';
            foreach($result as $row) {
              $return .= '
            <tr>
              <td>'.$row['ticket_id'].'</td>
              <td>'.$row['service_date'].'</td>
              <td><a class="btn btn-danger" href="'.$url.'/update/'.$row['veh_id'].'"><i class="fa fa-cog"></i></a></td>
            </tr>
          ';
        }
        $return .= '</tbody></table>';
      echo $return;
  } else {
    echo "No data found";
  }
}
?>
