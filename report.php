<?php
  require __DIR__.'/global.php';
  if(!isset($_POST['acc_name'])) {
    header('Location:'.$url.'/reports');
  }
  $repName = $_POST['acc_name'];
  $eDate = $_POST['acc_eDate'];
  $sDate = $_POST['acc_sDate'];

  $vehicles = $account->getVehicles($repName, $sDate, $eDate);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Report | <?php echo $repName?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
      <div class="updateContent" style="height: 100%">
        <table class="table table-striped">
          <div class="title" style="text-align: center;">0 - 4 hours</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h <= 3 AND $int->format('%i') <= 60) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 4 & 28 hours (1 Day)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 4 AND $h <= 28) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 29 & 52 hours (2 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 29 AND $h <= 52) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 53 & 79 hours (3 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 53 AND $h <= 79) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 80 & 104 hours (4 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 80 AND $h <= 104) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 105 & 129 hours (5 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 105 AND $h <= 129) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">5 Days +</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
              <th scope="col">Trailer Number</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Time of Exit</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);

              if($h >= 129) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
              <td><?php echo $row['trlno']?></td>
              <?php if ($row['type'] == 1) {
                     echo "<td>C/T</td>";
                   } else if ($row['type'] == 2) {
                     echo "<td>CAB</td>";
                   } else if ($row['type'] == 3) {
                     echo "<td>TRL</td>";
                   } else if ($row['type'] == 4) {
                     echo "<td>RIGID</td>";
                   } else if ($row['type'] == 5) {
                     echo "<td>COACH</td>";
                   } else if ($row['type'] == 6) {
                     echo "<td>CAR</td>";
                   } else if ($row['type'] == 7) {
                     echo "<td>M/H</td>";
                   } else if ($row['type'] == 0) {
                     echo "<td>N/A</td>";
                   }
              ?>
              <td><?php echo $row['timein']?></td>
              <td><?php echo $row['timeout']?></td>
              <td>
                <?php
                  $row_id = $row['id'];
                  $payments = $account->getTickets($row_id);
                  foreach($payments as $pay) {
                  echo $pay['ticket_id'];

                  if($pay['tot'] == 1) {
                    echo ' <span class="badge badge-dark">C/O</span>, ';
                  } else if ($pay['tot'] == 2) {
                    echo ' <span class="badge badge-dark">1 HR</span>, ';
                  } else if ($pay['tot'] == 3) {
                    echo ' <span class="badge badge-dark">2 HR</span>, ';
                  } else if ($pay['tot'] == 4) {
                    echo ' <span class="badge badge-primary">24 HR</span>, ';
                  } else if ($pay['tot'] == 5) {
                    echo ' <span class="badge badge-success">48 HR</span>, ';
                  } else if ($pay['tot'] == 6) {
                    echo ' <span class="badge badge-info">72 HR</span>, ';
                  }
                }
                ?>
              </td>
              <td><?php $account->reportTimeCalc($row['timein'], $row['timeout']); ?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>

    <!-- javascript Files -->
    <script src="<?php echo $url?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo $url?>/assets/js/popper.min.js"></script>
    <script src="<?php echo $url?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url?>/assets/js/mousetrap.min.js"></script>
  </body>
</html>
