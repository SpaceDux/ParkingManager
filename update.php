<?php
  require(__DIR__.'/global.php')
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Update | REG</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
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
        <a href="<?php echo URL ?>/main"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li class="active"><i class="fa fa-truck-moving"></i> Vehicle Tools
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
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> Update <small>\\\</small> <b>REG</b>
          <div class="float-right">
            6hours
          </div>
        </div>
      </div>
      <div class="updateContent">
        <div id="tables">
        <div class="container">
          <form method="post" id="update">
          <div class="row">
            <div class="col">
              <div class="alert alert-warning" role="alert"><i class="fa fa-flag"></i> This vehicle appears to be <b>flagged</b>, please see Comment\'s / Notes</div>
              <div class="alert alert-danger" role="alert"><i class="fa fa-times"></i> This vehicle has been <b>deleted</b></div>
              <div class="form-group">
                <label for="upd_company">Company Name</label>
                <input type="text" class="form-control" name="upd_company" id="upd_company" placeholder="Company..." value="">
              </div>
              <div class="form-group">
                <label for="upd_reg">Registration</label>
                <input type="text" class="form-control" name="upd_reg" id="upd_reg" placeholder="Vehicle Registration" value="">
              </div>
              <div class="form-group">
                <label for="upd_trl">Trailer Number</label>
                <input type="text" class="form-control" name="upd_trl" id="upd_trl" placeholder="Trail Number" value="">
              </div>
              <div class="form-group">
              <label>Type of Vehicle</label>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="0">
                    N/A
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="1">
                    Cab &amp; Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="2">
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="3">
                    Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="4">
                    Rigid
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="5">
                    Coach
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="6">
                    Car
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="7">
                    Motor Home
                  </label>
                </div>
              </div>
            </div>
            <div class="col">
              <table class="table table-striped table-dark text-center">
                <thead>
                  <tr>
                    <th scope="col">Ticket ID</th>
                    <th scope="col">Type of Ticket</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" tabindex="-1" class="btn btn-danger btn-sm payBtn" data-id="" data-toggle="modal" data-target="#addPaymentModal"><i class="fas fa-pound-sign"></i></i></button>
                        <button type="button" tabindex="-1" class="btn btn-danger btn-sm payBtn2" data-id="" data-toggle="modal" data-target="#addPaymentModalRenew"><i class="far fa-clock"></i></i></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>19191</td>
                    <td>
                      TICKET TYPE
                    </td>
                    <td>
                      H:I:S
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" id="edit" tabindex="-1" class="btn btn-danger btn-sm" data-id=""><i class="fas fa-cog"></i></button>
                        <button type="button" tabindex="-1" onClick="deletePayment()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="form-group">
                <label for="upd_timein">Time IN</label>
                <input type="text" class="form-control" id="upd_timein" name="upd_timein" placeholder="Time IN: Y-m-d H:m" value="">
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="1">
                  Break
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="2">
                  Paid
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="3">
                  Exit
                </label>
              </div>
              <div class="form-group">
                <label for="upd_timeout">Time OUT</label>
                <input type="text" class="form-control" id="upd_timeout" name="upd_timeout" placeholder="Time OUT: Y-m-d H:m" value="">
              </div>
              <div class="form-group">
                <label for="upd_comment">Comment / Notes</label>
                <textarea type="text" id="upd_comment" class="form-control" name="upd_comment" rows="3" cols="1" form="update"></textarea>
              </div>
              <div class="btn-group float-right" role="group" aria-label="Button Group">
                <button type="submit" class="btn btn-dark"><i class="fa fa-save"></i> Save Data</button>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu">
                    <a style="cursor: pointer" class="dropdown-item" onClick="quickExit()">Exit Vehicle</a>
                    <div class="dropdown-divider"></div>
                      <a style="cursor: pointer" class="dropdown-item" onClick="markRenewal()">Mark Renewal</a>
                      <a style="cursor: pointer" class="dropdown-item" onClick="unmarkRenewal()">Un-mark Renewal</a>
                      <a style="cursor: pointer" class="dropdown-item" onClick="setFlag()">Flag Vehicle</a>
                      <a style="cursor: pointer" class="dropdown-item" onClick="unsetFlag()">Un-Flag Vehicle</a>
                    <div class="dropdown-divider"></div>
                    <a style="cursor: pointer" class="dropdown-item" onClick="delVeh()">Delete Vehicle</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
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
    <!-- Add Renewal Payment Modal -->
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
    <!-- Add Renewal Payment Modal -->
    <div class="modal fade" id="updPaymentModal" tabindex="-1" role="dialog" aria-labelledby="updPaymentModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updPaymentModal">Update Payment</h5>
            <button type="button" tabindex="-1" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="updPaymentModal">
              <div class="form-group">
                <label for="tid">Ticket ID</label>
                <input type="hidden" name="upd_id" id="upd_id" class="form-control" value="">
                <input type="text" name="upd_tid" id="upd_tid" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" placeholder="Ticket ID.. 198833" autofocus>
              </div>
              <div class="form-group">
                <label>Type of Ticket</label>
                <select class="form-control" name="upd_tot" id="upd_tot">
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
            <button type="submit" onClick="updPayment()" class="btn btn-primary">Save Payment</button>
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
  </body>
</html>
