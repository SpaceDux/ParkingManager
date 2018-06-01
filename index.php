<?php
  require __DIR__.'/global.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Dashboard</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $url?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo $url?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $url?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
    <nav class="topBar">
      <div class="brand">
        Parking<b>Manager</b>
      </div>
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
            <a href="#"><li>Account Reports</li></a>
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
      <!-- Dark Header -->
      <div class="darkHead">
        <div class="row">
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-truck"></i>
              </div>
              <div class="Stat">
              <b><?php echo count($GetBreaks) + count($GetPaid) + count($GetRenewals)?></b><small>/200</small>
              </div>
              <div class="statText">
                vehicles <b>parked</b>
              </div>
            </div>
            <div class="statBox">
              <div class="statIcon">
                <i class="far fa-clock"></i>
              </div>
              <div class="Stat">
              <b><?php echo count($GetRenewals)?></b>
              </div>
              <div class="statText">
                renewals
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-shopping-basket"></i>
              </div>
              <div class="Stat">
              <b><?php echo count($GetBreaks)?></b>
              </div>
              <div class="statText">
                awaiting <b>payment</b>
              </div>
            </div>
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-h-square"></i>
              </div>
              <div class="Stat">
              <b>2</b>
              </div>
              <div class="statText">
                rooms <b>checked-in</b>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="statBox-LG">
              <canvas id="lastChart" width="400" height="auto" style="width:auto;max-height:181px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- #tables is the JS selector for the refresh -->
      <div id="tables">
      <div class="row">
        <div class="col-md-7">
          <!-- Break Table -->
          <div class="content">
            <div class="title">
              Break / Awaiting Payment
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($GetBreaks as $row) {
                  $datetime1 = new DateTime($row['timein']);
                  $datetime2 = new DateTime($row['timeout']);
                  $interval = $datetime2->diff($datetime1);
                  $hours = $interval->h;
                  $hours = $hours + ($interval->days*24);
                ?>
                <tr
                    <?php
                    if ($hours >= 2 AND $hours < 4) {
                        echo 'class="table-warning"'; //2hour chargeable
                    } else if ($hours >= 4) {
                        echo 'class="table-danger"'; //24hr
                    } else {
                      //no class
                    }
                    ?>
                >
                  <td><?php if($row['flag'] > 0) {
                    echo '<i style="color:#6b1111; font-size:11px;" class="far fa-flag"></i>';
                  } else {
                    //nothing
                  }?>
                  <?php echo $row['company']?></td>
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
                       }?>
                  <td>
                    <?php
                      $date = $row['timein'];
                      $d = date('d', strtotime($date));
                      $hms = date('H:i', strtotime($date));
                      echo $d.'/'.$hms;
                    ?>
                  </td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Button Group">
                      <a href="<?php echo $url?>/update/<?php echo $row['id']?>" class="btn btn-danger btn-sm"><i class="fas fa-cog"></i></a>
                      <button type="button" class="btn btn-danger btn-sm payBtn" data-id="<?php echo $row['id']?>" data-toggle="modal" data-target="#addPaymentModal"><i class="fas fa-pound-sign"></i></i></button>

                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu">
                          <a style="cursor: pointer" class="dropdown-item" onClick="quickExit(<?php echo $row['id']?>)">Exit Vehicle</a>
                          <div class="dropdown-divider"></div>
                          <a style="cursor: pointer" class="dropdown-item" onClick="markRenewal(<?php echo $row['id']?>)">Mark Renewal</a>
                          <?php if($row['flag'] < 1) {?>
                            <a style="cursor: pointer" class="dropdown-item" onClick="setFlag(<?php echo $row['id']?>)">Flag Vehicle</a>
                          <?php } else {?>
                            <a style="cursor: pointer" class="dropdown-item" onClick="unsetFlag(<?php echo $row['id']?>)">Un-Flag Vehicle</a>
                          <?php }?>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- Paid Table -->
          <div class="content">
            <div class="title">
              Paid
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Ticket ID</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($GetPaid as $row) { ?>
                <tr>
                  <td><?php if($row['flag'] > 0) {
                    echo '<i style="color:#6b1111; font-size:11px;" class="far fa-flag"></i>';
                  } else {
                    //nothing
                  }?>
                  <?php echo $row['company']?></td>
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
                       }?>
                  <td>
                  <?php
                    $row_id = $row['id'];
                    $payments = $parking->fetchPayments($row_id);

                    echo $payments['ticket_id'];

                    if($payments['tot'] == 1) {
                      echo ' <span class="badge badge-dark">C/O</span>';
                    } else if ($payments['tot'] == 2) {
                      echo ' <span class="badge badge-dark">1 HR</span>';
                    } else if ($payments['tot'] == 3) {
                      echo ' <span class="badge badge-dark">2 HR</span>';
                    } else if ($payments['tot'] == 4) {
                      echo ' <span class="badge badge-primary">24 HR</span>';
                    } else if ($payments['tot'] == 5) {
                      echo ' <span class="badge badge-success">48 HR</span>';
                    } else if ($payments['tot'] == 6) {
                      echo ' <span class="badge badge-info">72 HR</span>';
                    }
                  ?>
                  </td>
                  <td>
                    <?php
                      $date = $row['timein'];
                      $d = date('d', strtotime($date));
                      $hms = date('H:i', strtotime($date));
                      echo $d.'/'.$hms;
                    ?>
                  </td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Button Group">
                      <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-cog"></i></button>

                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu">
                          <a style="cursor: pointer" class="dropdown-item" onClick="quickExit(<?php echo $row['id']?>)">Exit Vehicle</a>
                          <div class="dropdown-divider"></div>
                          <a style="cursor: pointer" class="dropdown-item" onClick="markRenewal(<?php echo $row['id']?>)">Mark Renewal</a>
                          <?php if($row['flag'] < 1) {?>
                            <a style="cursor: pointer" class="dropdown-item" onClick="setFlag(<?php echo $row['id']?>)">Flag Vehicle</a>
                          <?php } else {?>
                            <a style="cursor: pointer" class="dropdown-item" onClick="unsetFlag(<?php echo $row['id']?>)">Un-Flag Vehicle</a>
                          <?php }?>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-5">
          <!-- Renewals Table -->
          <div class="content">
            <div class="title">
              Renewals
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($GetRenewals as $row) { ?>
                <tr>
                  <td><?php if($row['flag'] > 0) {
                    echo '<i style="color:#6b1111; font-size:11px;" class="far fa-flag"></i>';
                  } else {
                    //nothing
                  }?>
                  <?php echo $row['company']?></td>
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
                         }?>
                    <td>
                      <?php
                        $date = $row['timein'];
                        $d = date('d', strtotime($date));
                        $hms = date('H:i', strtotime($date));
                        echo $d.'/'.$hms;
                      ?>
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-cog"></i></button>
                        <button type="button" class="btn btn-danger btn-sm payBtn2" data-id="<?php echo $row['id']?>" data-toggle="modal" data-target="#addPaymentModalRenew"><i class="far fa-clock"></i></i></button>

                        <div class="btn-group" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                          <div class="dropdown-menu">
                            <a style="cursor: pointer" class="dropdown-item" onClick="quickExit(<?php echo $row['id']?>)">Exit Vehicle</a>
                            <div class="dropdown-divider"></div>
                            <a style="cursor: pointer" class="dropdown-item" onClick="markRenewal(<?php echo $row['id']?>)">Mark Renewal</a>
                            <?php if($row['flag'] < 1) {?>
                              <a style="cursor: pointer" class="dropdown-item" onClick="setFlag(<?php echo $row['id']?>)">Flag Vehicle</a>
                            <?php } else {?>
                              <a style="cursor: pointer" class="dropdown-item" onClick="unsetFlag(<?php echo $row['id']?>)">Un-Flag Vehicle</a>
                            <?php }?>
                          </div>
                        </div>
                      </div>
                    </td>
                </tr>
              <?php }?>
              </tbody>
            </table>
          </div>
          <!-- Exit Table -->
          <div class="content">
            <div class="title">
              Most Recent Exit's
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($GetExits as $row) { ?>
                <tr>
                  <td><?php if($row['flag'] > 0) {
                    echo '<i style="color:#6b1111; font-size:11px;" class="far fa-flag"></i>';
                  } else {
                    //nothing
                  }?>
                  <?php echo $row['company']?></td>
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
                         }?>
                    <td>
                      <?php
                        $date = $row['timeout'];
                        $d = date('d', strtotime($date));
                        $hms = date('H:i', strtotime($date));
                        echo $d.'/'.$hms;
                      ?>
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-cog"></i></button>
                      </div>
                    </td>
                </tr>
              <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
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
    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPaymentModal">Add Payment</h5>
            <button type="button" tabindex="-1" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addPaymentForm">
              <div class="form-group">
                <label for="tid">Ticket ID</label>
                <input type="hidden" name="veh_id" id="veh_id" class="form-control" value="">
                <input type="text" name="tid" id="tid" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" placeholder="Ticket ID.. 198833" autofocus>
              </div>
              <div class="form-group">
                <label>Type of Ticket</label>
                <select class="form-control" name="tot" id="tot">
                  <option value="1">Change Over</option>
                  <option value="2">1 Hour</option>
                  <option value="3">2 Hours</option>
                  <option value="4">24 Hours</option>
                  <option value="5">48 Hours</option>
                  <option value="6">72 Hours</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" onClick="addPayments()" class="btn btn-primary">Save Payment</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Add Payment Modal Renew -->
    <div class="modal fade" id="addPaymentModalRenew" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalRenew" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPaymentModalRenew">Add Renewal Payment</h5>
            <button type="button" tabindex="-1" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addPaymentFormRenew">
              <div class="form-group">
                <label for="tid">Ticket ID</label>
                <input type="hidden" name="veh_id2" id="veh_id2" class="form-control" value="">
                <input type="text" name="tid2" id="tid2" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" placeholder="Ticket ID.. 198833" autofocus>
              </div>
              <div class="form-group">
                <label>Type of Ticket</label>
                <select class="form-control" name="tot2" id="tot2">
                  <option value="1">Change Over</option>
                  <option value="2">1 Hour</option>
                  <option value="3">2 Hours</option>
                  <option value="4">24 Hours</option>
                  <option value="5">48 Hours</option>
                  <option value="6">72 Hours</option>
                </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" onClick="addPaymentsRenew()" class="btn btn-primary">Save Payment</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- javascript Files -->
    <script src="<?php echo $url?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo $url?>/assets/js/popper.min.js"></script>
    <script src="<?php echo $url?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url?>/assets/js/Chart.bundle.min.js"></script>
    <script src="<?php echo $url?>/assets/js/mousetrap.min.js"></script>
    <script src="<?php echo $url?>/assets/js/Chart.bundle.min.js"></script>
    <script src="<?php echo $url?>/assets/js/Chart.bundle.min.js"></script>
    <?php require(__DIR__.'/assets/jsreq.php')?>
    <script type="text/javascript">
    Mousetrap.bind('tab', function() {
      $('#addVehicleModal').modal('show');
    });
    </script>
  </body>
</html>
