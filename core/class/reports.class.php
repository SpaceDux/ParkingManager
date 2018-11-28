<?php
  namespace ParkingManager;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $count = $this->Payment_Count_Account($account, $campus, $key, $date1, $date2);
        $net = $this->payment->Payment_ServiceInfo($key, "service_price_net") * $count;
        $gross = $this->payment->Payment_ServiceInfo($key, "service_price_gross") * $count;

        $stat .= '<tr>';
        $stat .= '<td>'.$this->payment->Payment_ServiceInfo($key, "service_name").'</td>';
        $stat .= '<td>'.$this->Payment_Count_Account($account, $campus, $key, $date1, $date2).'</td>';
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
    //Produce Excel
    function WriteExcel($account, $dateStart, $dateEnd) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->vehicle = new Vehicles;
      $this->account = new Account;
      $this->payment = new Payment;
      $account_name = $this->account->Account_GetInfo($account, "account_name");
      $file_name = $account_name.' RC '.$dateStart.' - '.$dateEnd;
      $campus = $this->user->userInfo("campus");
      $totalParked = 0;
      $totalTransactions = 0;
      $total_gross = 0;
      $total_net = 0;
      $rows = 2;
      //Date construction
      $date1 = date("Y-m-d 00:00:00", strtotime($dateStart));
      $date2 = date("Y-m-d 23:59:59", strtotime($dateEnd));
      //object of the Spreadsheet class to create the excel data
      $spreadsheet = new Spreadsheet();
      //Spreadsheet information
      $spreadsheet->getProperties()
        ->setCreator("ParkingManager")
        ->setLastModifiedBy("ParkingManager")
        ->setTitle("ParkingManager Account Report")
        ->setSubject("Account - $date1 | $date2")
        ->setDescription("Account transaction and parking history")
        ->setKeywords("parking manager 3 2018 2019 account reports")
        ->setCategory("Accounting");
        //header information.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        //Start Content
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        //Stat content
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'c41f45',
                ],
                'endColor' => [
                    'argb' => '9b1837',
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':D'.$rows)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':D'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
        $sheet->setCellValue('A'.$rows, 'Service');
        $sheet->setCellValue('B'.$rows, 'No. Transactions');
        $sheet->setCellValue('C'.$rows, 'Gross Price');
        $sheet->setCellValue('D'.$rows, 'Net Price');
        $rows++;
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_service_id ORDER BY payment_price_gross ASC");
        $query->bindParam(1, $account);
        $query->bindParam(2, $campus);
        $query->bindParam(3, $date1);
        $query->bindParam(4, $date2);
        $query->execute();
        foreach($query->fetchAll() as $row) {
          $key = $row['payment_service_id'];
          $count = $this->Payment_Count_Account($account, $campus, $key, $date1, $date2);
          $net = $this->payment->Payment_ServiceInfo($key, "service_price_net") * $count;
          $gross = $this->payment->Payment_ServiceInfo($key, "service_price_gross") * $count;
          $sheet->setCellValue('A'.$rows, $this->payment->Payment_ServiceInfo($key, "service_name"));
          $sheet->setCellValue('B'.$rows, $count);
          $sheet->setCellValue('C'.$rows, '£'.number_format($gross, 2));
          $sheet->setCellValue('D'.$rows, '£'.number_format($net, 2));
          $rows++;
        }
        $rows = $rows + 3;
        //Main Content
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'c41f45',
                ],
                'endColor' => [
                    'argb' => '9b1837',
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
        // Spreadsheet main content (header)
        $sheet->setCellValue('A'.$rows, 'Vehicle Registration');
        $sheet->setCellValue('B'.$rows, 'Trailer No.');
        $sheet->setCellValue('C'.$rows, 'Vehicle Type');
        $sheet->setCellValue('D'.$rows, 'Time ENTRY');
        $sheet->setCellValue('E'.$rows, 'Time EXIT');
        $sheet->setCellValue('F'.$rows, 'Payment Ref');
        $sheet->setCellValue('G'.$rows, 'Duration Parked');
        $rows++;
        //Query Data + Grouping
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_type = 3 AND payment_account_id = ? AND payment_deleted = 0 AND payment_campus = ? AND payment_date BETWEEN ? AND ? GROUP BY payment_ref ORDER BY payment_date ASC");
        $query->bindParam(1, $account);
        $query->bindParam(2, $campus);
        $query->bindParam(3, $date1);
        $query->bindParam(4, $date2);
        $query->execute();
        //Filtering
        foreach($query->fetchAll() as $row) {
          $key = $row['payment_ref'];
          $query2 = $this->mysql->dbc->prepare("SELECT * FROM pm_parking_log WHERE payment_ref = ? ORDER BY parked_timein, parked_type ASC");
          $query2->bindParam(1, $key);
          $query2->execute();
          //Vehicle parking record
          foreach($query2->fetchAll() as $row) {
            $totalParked++;
            $key2 = $row['payment_ref'];
            $timeout = $row['parked_timeout'];
            if($timeout == "") {
              $timeout = '';
            } else {
              $timeout = date("d/m/Y H:i:s", strtotime($row['parked_timeout']));
            }
            //Time Calc
            $d1 = new \DateTime($row['parked_timein']);
            $d2 = new \DateTime($row['parked_timeout']);
            $int = $d2->diff($d1);
            $h = $int->h;
            $h = $h + ($int->days*24);
            //Excel format
            $styleArray = [
                  'font' => [
                      'bold' => true,
                  ],
                  'alignment' => [
                      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                  ],
                  'borders' => [
                      'top' => [
                          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                      ],
                  ],
                  'fill' => [
                      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                      'rotation' => 90,
                      'startColor' => [
                          'argb' => '558eed',
                      ],
                      'endColor' => [
                          'argb' => '558eed',
                      ],
                  ],
              ];
            $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
            $sheet->setCellValue('A'.$rows, $row['parked_plate']);
            $sheet->setCellValue('B'.$rows, $row['parked_trailer']);
            $sheet->setCellValue('C'.$rows, $this->vehicle->Vehicle_Type_Info($row['parked_type'], "type_shortName"));
            $sheet->setCellValue('D'.$rows, date("d/m/Y H:i:s", strtotime($row['parked_timein'])));
            $sheet->setCellValue('E'.$rows, $timeout);
            $sheet->setCellValue('F'.$rows, $row['payment_ref']);
            $sheet->setCellValue('G'.$rows, $h.' hours & '.$int->format('%i').' minutes');
            $rows++;
            //Each payment listed
            $query3 = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE payment_ref = ? AND payment_deleted = 0");
            $query3->bindParam(1, $key2);
            $query3->execute();
            foreach($query3->fetchAll() as $row) {
              $totalTransactions++;
              $total_net += $row['payment_price_net'];
              $total_gross += $row['payment_price_gross'];
              $sheet->setCellValue('A'.$rows, $row['id']);
              $sheet->setCellValue('B'.$rows, $row['payment_service_name']);
              $sheet->setCellValue('D'.$rows, date("d/m/Y H:i:s", strtotime($row['payment_date'])));
              $sheet->setCellValue('F'.$rows, '£'.$row['payment_price_gross']);
              $sheet->setCellValue('G'.$rows, '£'.$row['payment_price_net']);
              $rows++;
            }
          }
        }
        //Footer information
        $styleArray = [
                'font' => [
                  'bold' => true,
              ],
              'alignment' => [
                  'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              ],
              'borders' => [
                  'top' => [
                      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                  ],
              ],
              'fill' => [
                  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                  'rotation' => 90,
                  'startColor' => [
                      'argb' => 'c41f45',
                  ],
                  'endColor' => [
                      'argb' => '9b1837',
                  ],
              ],
          ];
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A'.$rows.':G'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
        $sheet->setCellValue('A'.$rows, 'Total Parked: '.$totalParked);
        $sheet->setCellValue('B'.$rows, 'Total Transactions: '.$totalTransactions);
        $sheet->setCellValue('F'.$rows, 'Total Gross: £'.number_format($total_gross, 2));
        $sheet->setCellValue('G'.$rows, 'Total Net: £'.number_format($total_net, 2));

        //End spreadsheets
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output') ;
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        die();
    }
  }
?>
