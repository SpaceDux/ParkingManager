<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Main Hub</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo URL?>/index">
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
            <?php echo $user->userInfo('first_name')?> <b><?php echo substr($user->userInfo('last_name'), 0, 1);?>.</b>
          </div>
          <div class="userLocation">
            RK: Holyhead | Security
          </div>
          <div class="pmVer">
            <?php echo VER ?>
          </div>
        </div>
        <div class="buttons">
          <a href="#settings"><i class="fa fa-cog"></i></a>
          <a href="<?php echo URL?>/logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="<?php echo URL ?>/main"><li class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="<?php echo URL?>/yardcheck" target="_blank"><li>Yard Check</li></a>
          </ul>
        </li>
        <li><i class="fa fa-pound-sign"></i> Payment Tools
          <ul>
            <a href="<?php echo URL?>/reports"><li>Transactions History</li></a>
          </ul>
        </li>
        <li><i class="fa fa-book"></i> Account Tools
          <ul>
            <a href="<?php echo URL?>/reports"><li>Account Reports</li></a>
            <a href="<?php echo URL?>/reports"><li>Account Fleets</li></a>
          </ul>
        </li>
        <li><i class="fa fa-cogs"></i> P<b>M</b> Tools
          <ul>
            <a href="<?php echo URL?>/notices"><li>Notices</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
        <li><i class="fa fa-chart-line"></i> Admin Tools
          <ul>
            <a href="#"><li>Something</li></a>
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
              <b><?php echo $vehicles->vehicle_count_paid();?></b><small>/200</small>
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
              <b><?php echo $vehicles->vehicle_count_renewals();?></b>
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
              <b>22</b>
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
      <div class="row" id="tables">
        <div class="col-md-7">
          <!-- ANPR Feed Table -->
          <div class="content">
            <div class="title">
              Live ANPR Feed
            </div>
            <table class="table table-dark table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Registration</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>181MH222</td>
                  <td>18/12:22</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Options">
                      <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-camera"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>
                      <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Paid Vehicles Table -->
          <div class="content">
            <div class="title">
              Paid Vehicles
            </div>
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col">Ticket ID</th>
                  <th scope="col float"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php $vehicles->get_paidFeed()?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-5">
          <div class="content">
            <div class="title">
              Marked Renewals
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
                <?php $vehicles->get_renewalFeed() ?>
              </tbody>
            </table>
          </div>
          <div class="content">
            <div class="title">
              Recently Exit Vehicles
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time OUT</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php $vehicles->get_exitFeed() ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <footer>
        ParkingManager (PM) &copy; 2018/2019 | Designed, developed by <a href="mailto:ryan@roadkingcafe.uk"><b>Ryan. W</b> with RoadKing Truckstops &copy;</a>
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
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="0">
                    N/A
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="1" checked>
                    Cab &amp; Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="2">
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="3">
                    Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="4">
                    Rigid
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="5">
                    Coach
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="6">
                    Car
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="7">
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
    <script src="<?php echo URL?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/mousetrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/Chart.bundle.min.js"></script>
    <!-- Menu Hide JS -->
    <script type="text/javascript">
      function menuHide() {
        var sideBar = document.getElementById("sideBar");
        var wrapper = document.getElementById("wrapper");
        if (sideBar.style.marginLeft === "-220px") {
            sideBar.style.marginLeft = "0px";
            sideBar.style.transition = "0.2s ease-in-out";
            //Wrapper
            wrapper.style.paddingLeft = "220px";
            wrapper.style.transition = "0.2s ease-in-out";
        } else {
            sideBar.style.marginLeft = "-220px";
            sideBar.style.transition = "0.2s ease-in-out";
            //Wrapper
            wrapper.style.paddingLeft = "0px";
            wrapper.style.transition = "0.2s ease-in-out";
        }
      }
    </script>
    <!-- Focus on Modal -->
    <script type="text/javascript">
    $('.modal').on('shown.bs.modal', function() {
      $(this).find('[autofocus]').focus();
    });
    </script>
    <script type="text/javascript">
    Mousetrap.bind('tab', function() {
      $('#addVehicleModal').modal('show');
    });
    </script>
    <!-- Chart JS -->
    <script type="text/javascript">
    var ctx = document.getElementById("lastChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: 'This week',
                data: [190, 122, 221, 120, 200, 222, 170],
                borderWidth: [0],
                backgroundColor: [
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
            },
            {
              label: 'Last week',
              data: [90, 177, 221, 123, 229, 222, 122],
              borderWidth: [0],
              backgroundColor: [
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)'
              ],
              borderColor: [
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)'
              ]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    </script>
  </body>
</html>
