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
    <!-- Top Navbar -->
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo $url?>/index">
      <div class="brand">
        Parking<b>Manager</b>
      </div>
      </a>
      <ul>
        <a onClick="menuHide()"><li><i class="fas fa-align-justify"></i></li></a>
        <li data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></li>
        <li data-toggle="modal" data-target="#addVehicleModal"><i class="fa fa-plus"></i></li>
      </ul>
    </nav>
    <!-- Sidebar -->
    <nav id="sideBar" style="margin-left: -220px;">
      <div class="userBox">
        <div class="userInfo">
          <div class="userName">
            Ryan <b>W</b>.
          </div>
          <div class="userLocation">
            RK: Holyhead | Security
          </div>
          <div class="pmVer">
            <?php echo $ver?>
          </div>
        </div>
        <div class="buttons">
          <a href="#settings"><i class="fa fa-cog"></i></a>
          <a href="/logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="<?php echo $url ?>/index"><li class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="#"><li>Yard Check</li></a>
            <a href="#"><li>Fleets</li></a>
          </ul>
        </li>
        <li><i class="fa fa-book"></i> Account Tools
          <ul>
            <a href="<?php echo $url?>/reports"><li>Account Reports</li></a>
          </ul>
        </li>
        <li><i class="fa fa-cogs"></i> P<b>M</b> Tools
          <ul>
            <a href="#"><li>Notices</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo $url ?>/index">Dashboard</a> <small>\\\</small> Reports <small>\\\</small> <b><?php echo $repName?></b>
        </div>
      </div>
      <div class="updateContent" style="height: 100%">
        <table class="table table-striped">
          <div class="title" style="text-align: center;">0 - 4 hours</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 29 & 51 hours (2 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
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

              if($h >= 29 AND $h <= 51) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 51 & 78 hours (3 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
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

              if($h >= 51 AND $h <= 78) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 79 & 103 hours (4 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
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

              if($h >= 79 AND $h <= 103) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
        <table class="table table-striped">
          <div class="title" style="text-align: center;">Between 103 & 128 hours (5 Days)</div>
          <thead class="thead-light">
            <tr>
              <th scope="col">Registration</th>
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

              if($h >= 104 AND $h <= 128) {
              ?>
            <tr>
              <td><?php echo $row['reg']?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
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
              <td><?php echo $h.':'.$int->format('%i');?></td>
            </tr>
          <?php   }
                }
          ?>
          </tbody>
        </table>
      </div>
      <footer>
        ParkingManager (PM) &copy; 2018/2019 | Designed, developed & owned by <a href="https://ryanadamwilliams.co.uk"><b>Ryan. W</b></a>
      </footer>
    </div>
    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addVehicleModalTitle">Add Vehicle</h5>
            <button type="button" class="close" tabindex="-1"  data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addVehicleForm">
              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" name="addCompany" id="addCompany" placeholder="NOLAN..." style="text-transform: uppercase;" tabindex="" autofocus>
                <small class="form-text text-muted">Please ensure all company names are correct, especially account customers</small>
              </div>
              <div class="form-group">
                <label>Registration Number</label>
                <input type="text" class="form-control" name="addRegistration" id="addRegistration" placeholder="07WX8787..." style="text-transform: uppercase;">
              </div>
              <div class="form-group">
                <label>Trailer Number</label>
                <input type="text" class="form-control" name="addTrl" id="addTrl" placeholder="MDI112..." style="text-transform: uppercase;">
              </div>
              <div class="form-group">
                <label>Type of Vehicle</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="0">
                  <label class="form-check-label" for="addType">
                    N/A
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="1" checked>
                  <label class="form-check-label" for="addType">
                    Cab &amp; Trailer
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="2">
                  <label class="form-check-label" for="addType">
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="3">
                  <label class="form-check-label" for="addType">
                    Trailer
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="4">
                  <label class="form-check-label" for="addType">
                    Rigid
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="5">
                  <label class="form-check-label" for="addType">
                    Coach
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="6">
                  <label class="form-check-label" for="addType">
                    Car
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="7">
                  <label class="form-check-label" for="addType">
                    Motor Home
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Time IN</label>
                <input type="text" class="form-control" name="addTimein" id="addTimein" value="<?php echo date("Y-m-d H:i:s")?>">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" onClick="saveData()" class="btn btn-primary">Save Vehicle</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Search DB Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="searchModal">Search Database Enteries</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="" action="" method="post">
              <input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" placeholder="Query the database..." autofocus>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- javascript Files -->
    <script src="<?php echo $url?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo $url?>/assets/js/popper.min.js"></script>
    <script src="<?php echo $url?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url?>/assets/js/mousetrap.min.js"></script>
    <?php require(__DIR__.'/assets/jsreq.php')?>
  </body>
</html>
