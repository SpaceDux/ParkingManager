<?php
  require __DIR__.'/global.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Report</title>
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
            Road <b>K</b>.
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
          <a href="#logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="<?php echo $url ?>/index"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="<?php echo $url?>/yardcheck" target="_blank"><li>Yard Check</li></a>
          </ul>
        </li>
        <li class="active"><i class="fa fa-book"></i> Account Tools
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
          <a href="<?php echo $url ?>/index">Dashboard</a> <small>\\\</small> <b>Reports</b>
        </div>
      </div>
      <div class="updateContent" style="height: 100vh">
        <div class="row">
          <div class="col">
            <form method="post" action="report">
              <div class="form-group">
                <label for="acc_name">Account Name</label>
                <input type="text" class="form-control" name="acc_name" id="acc_name" placeholder="Account Name..." value="NOLAN" autofocus>
              </div>
              <div class="form-group">
                <label for="acc_sDate">Report Starting Date</label>
                <input type="text" class="form-control" name="acc_sDate" id="acc_sDate" placeholder="Date from..." value="<?php echo date("Y-m-01 00:00:00")?>">
              </div>
              <div class="form-group">
                <label for="acc_eDate">Report End Date</label>
                <input type="text" class="form-control" name="acc_eDate" id="acc_eDate" placeholder="Date ending..." value="<?php echo date("Y-m-31 23:59:59")?>">
              </div>
              <button type="submit" target="_blank" class="btn btn-primary float-right"> Generate Report</button>
            </div>
          <form>
          <div class="col">

          </div>
        </div>
      </div>
      <footer style="position: fixed">
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
  </body>
</html>
