<?php
  require __DIR__.'/global.php';
  $vehicles = $parking->fetchYard();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Yard Check</title>
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
        <a href="<?php echo $url ?>/index"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li class="active"><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="<?php echo $url?>/yardcheck" target="_blank"><li>Yard Check</li></a>
          </ul>
        </li>
        <li><i class="fa fa-book"></i> Account Tools
          <ul>
            <a href="<?php echo $url?>/reports"><li>Account Reports</li></a>
          </ul>
        </li>
        <li><i class="fa fa-cogs"></i> P<b>M</b> Tools
          <ul>
            <a href="<?php echo $url?>/notices"><li>Notices</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo $url ?>/index">Dashboard</a> <small>\\\</small> Vehicle Tools <small>\\\</small> <b>Yard Check</b>
        </div>
      </div>
      <div class="updateContent">
        <table class="table table-dark table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Company</th>
              <th scope="col">Registration</th>
              <th scope="col">Type</th>
              <th scope="col">Time of Arrival</th>
              <th scope="col">Ticket I.D</th>
              <th scope="col">Stay Length</th>
              <th scope="col">Check</th>
              <th scope="col"><i class="fa fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($vehicles as $row) {
              $d1 = new DateTime($row['timein']);
              $d2 = new DateTime($row['timeout']);
              $int = $d2->diff($d1);
              $h = $int->h;
              $h = $h + ($int->days*24);
              ?>
            <tr>
              <td><?php echo $row['company']?></td>
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
              <td>
                <input type="checkbox" style="transform: scale(2.5) !important;">
              </td>
              <td><a class="btn btn-primary" href="<?php echo $url?>/update/<?php echo $row['id']?>" target="_blank"><i class="fa fa-cog"></i></a></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
      <footer>
        ParkingManager (PM) &copy; 2018/2019 | Designed, developed & maintained by <a href="https://ryanadamwilliams.co.uk"><b>Ryan. W</b></a>
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
            <div class="row">
              <div class="col">
                <label>Search Vehicle Details</label>
                <input type="text" id="searchData" class="form-control" placeholder="Search Registration, company, trailer number..." autofocus>
              </div>
              <div class="col">
                <label>Search Payment Details</label>
                <input type="text" id="searchPay" class="form-control" placeholder="Search Ticket ID">
              </div>
            </div>
            <div class="modal-body">
              <div id="return">

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
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
    <script>
      window.onbeforeunload = function () {
        return false;
      }
    </script>
  </body>
</html>
