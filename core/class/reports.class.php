<?php
  namespace ParkingManager;

  class Reports
  {
    //Account payment reports
    function Account_Report($account, $dateStart, $dateEnd) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->vehicle = new Vehicles;
      $this->payment = new Payment;
      $campus = $this->user->userInfo("campus");
      $date1 = date("Y-m-d 00:00:00", strtotime($dateStart));
      $date2 = date("Y-m-d 23:59:59", strtotime($dateEnd));
      $priceGross = 0;
      $priceNet = 0;
      $totalTransactions = 0;

      $stat ='<div class="col-md-6"><table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">Service</th>
                    <th scope="col">No. Transactions</th>
                    <th scope="col">Price Gross</th>
                    <th scope="col">Price Net</th>
                  </tr>
                </thead>
              <tbody>';

      $html = '<table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Plate</th>
                      <th scope="col">Trailer</th>
                      <th scope="col">Vehicle Type</th>
                      <th scope="col">Time ARRIVAL</th>
                      <th scope="col">Time DEPARTURE</th>
                      <th scope="col">Payment Ref</th>
                      <th scope="col">Time Stayed</th>
                    </tr>
                  </thead>
                <tbody>';

      //Stats
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id ORDER BY payment_price_gross ASC");
      $query->bindParam(1, $account);
      $query->bindParam(2, $campus);
      $query->bindParam(3, $date1);
      $query->bindParam(4, $date2);
      $query->execute();
      foreach($query->fetchAll() as $row) {
        $key = $row['payment_service_id'];
        $count = $this->payment->Payment_Count_Account($account, $campus, $key, $date1, $date2);
        $net = $this->payment->Payment_ServiceInfo($key, "service_price_net") * $count;
        $gross = $this->payment->Payment_ServiceInfo($key, "service_price_gross") * $count;

        $stat .= '<tr>';
        $stat .= '<td>'.$this->payment->Payment_ServiceInfo($key, "service_name").'</td>';
        $stat .= '<td>'.$this->payment->Payment_Count_Account($account, $campus, $key, $date1, $date2).'</td>';
        $stat .= '<td>'.number_format($gross, 2).'</td>';
        $stat .= '<td colspan="2">'.number_format($net, 2).'</td>';
        $stat .= '</tr>';
      }
      $stat .= '</tbody></table></div>';
      //Report
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_ref ORDER BY payment_date ASC");
      $query->bindParam(1, $account);
      $query->bindParam(2, $campus);
      $query->bindParam(3, $date1);
      $query->bindParam(4, $date2);
      $query->execute();
      foreach ($query->fetchAll() as $row) {
        $key = $row['payment_ref'];
        $query2 = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE payment_ref = ? ORDER BY parked_timein ASC");
        $query2->bindParam(1, $key);
        $query2->execute();
        foreach ($query2->fetchAll() as $row) {
          if(isset($row['parked_timeout']) AND $row['parked_timeout'] == "") {
            $timeout = "";
          } else {
            $timeout = date("d/m/y H:i", strtotime($row['parked_timeout']));
          }
          $d1 = new \DateTime($row['parked_timein']);
          $d2 = new \DateTime($row['parked_timeout']);
          $int = $d2->diff($d1);
          $h = $int->h;
          $h = $h + ($int->days*24);

          $key2 = $row['payment_ref'];
          $html .= '<tr class="table-primary" style="color: #000;">';
          $html .= '<td>'.$row['parked_plate'].'</td>';
          $html .= '<td>'.$row['parked_trailer'].'</td>';
          $html .= '<td>'.$this->vehicle->Vehicle_Type_Info($row['parked_type'], "type_shortName").'</td>';
          $html .= '<td>'.date("d/m/y H:i:s", strtotime($row['parked_timein'])).'</td>';
          $html .= '<td>'.$timeout.'</td>';
          $html .= '<td>'.$row['payment_ref'].'</td>';
          $html .= '<td>'.$h.' hours & '.$int->format('%i').' minutes</td>';
          $html .= '</tr>';
          $query3 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_ref = ? AND payment_deleted = 0");
          $query3->bindParam(1, $key2);
          $query3->execute();
          foreach($query3->fetchAll() as $row) {
            $priceGross += $row['payment_price_gross'];
            $priceNet += $row['payment_price_net'];
            $totalTransactions++;
            $html .= '<tr>';
            $html .= '<td>T.ID: '.$row['id'].'</td>';
            $html .= '<td colspan="2">'.$row['payment_service_name'].'</td>';
            $html .= '<td>'.date("d/m/y H:i:s", strtotime($row['payment_date'])).'</td>';
            $html .= '<td> £'.$row['payment_price_gross'].'</td>';
            $html .= '<td> £'.$row['payment_price_net'].'</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
          }
        }
      }
      $html .= '<tr class="table-danger" style="text-align: center;">';
      $html .= '<td colspan="2">Total Transactions: '.$totalTransactions.'</td>';
      $html .= '<td colspan="2">Gross Price: £'.number_format($priceGross, 2).'</td>';
      $html .= '<td colspan="2">Net Price: £'.number_format($priceNet, 2).'</td>';
      $html .= '<td colspan="2"></td>';
      $html .= '</tr>';
      $html .= "</tbody></table>";

      echo $stat;
      echo $html;



      $this->mysql = null;
      $this->user = null;
      $this->vehicle = null;
      $this->payment = null;
    }
    //Count the payments
    function Payment_Count_Account($account, $campus, $service, $dateStart, $dateEnd) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_service_id = ? AND payment_campus = ? AND payment_date BETWEEN ? AND ? ORDER BY id ASC");
      $query->bindParam(1, $account);
      $query->bindParam(2, $service);
      $query->bindParam(3, $campus);
      $query->bindParam(4, $dateStart);
      $query->bindParam(5, $dateEnd);
      $query->execute();
      return count($query->fetchAll());
      //$result = $query->fetchAll();

      $this->mysql = null;
    }
  }
?>
