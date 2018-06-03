<?php
  require __DIR__.'/global.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PM: Dashboard</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="/PM18/assets/css/theme.css">
    <link rel="stylesheet" href="/PM18/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/PM18/assets/css/fontawesome-all.min.css">
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
            {PM_VER}
          </div>
        </div>
        <div class="buttons">
          <a href="#settings"><i class="fa fa-cog"></i></a>
          <a href="{URL}/logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="{URL}/index"><li class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
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
            <a href="#"><li>Notices Board</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">

    </div>
    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addVehicleModalTitle">Add Vehicle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addVehicle">
              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" name="addCompany" id="addCompany" placeholder="NOLAN..." autofocus>
                <small class="form-text text-muted">Please ensure all company names are correct, especially account customers</small>
              </div>
              <div class="form-group">
                <label>Registration Number</label>
                <input type="text" class="form-control" name="addRegistration" id="addRegistration" placeholder="07WX8787...">
              </div>
              <div class="form-group">
                <label>Trailer Number</label>
                <input type="text" class="form-control" name="addTrl" id="addTrl" placeholder="MDI112...">
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
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="2">
                  <label class="form-check-label" for="addType">
                    Cab &amp; Trailer
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
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="6">
                  <label class="form-check-label" for="addType">
                    Car
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Time IN</label>
                <input type="text" class="form-control" name="addTimein" id="addTimein" value="<?php echo date("Y-m-d H:i:s")?>">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" onClick="addVehicle()" class="btn btn-primary">Save Vehicle</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Search DB Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="addPayment">
              <div class="form-group">
                <label for="tid">Ticket ID</label>
                <input type="text" name="tid" id="tid" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" placeholder="Ticket ID.. 198833" autofocus>
              </div>
              <div class="form-group">
                <label>Type of Ticket</label>
                <select class="form-control" name="tot" id="tot">
                  <option value="1">Change Over</option>
                  <option value="2">1 Hour</option>
                  <option value="2">2 Hours</option>
                  <option value="3">24 Hours</option>
                  <option value="4">48 Hours</option>
                  <option value="5">72 Hours</option>
                </select>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="veh_paid" id="veh_paid" checked>
                <label class="form-check-label" for="veh_paid">
                  Paid
                </label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save Payment</button>
          </div>
        </div>
      </div>
    </div>
    <!-- javascript Files -->
    <script src="/PM18/assets//js/jquery.min.js"></script>
    <script src="/PM18/assets//js/popper.min.js"></script>
    <script src="/PM18/assets//js/bootstrap.min.js"></script>
    <script src="/PM18/assets//js/Chart.bundle.min.js"></script>
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
    <!-- Chart JS -->
    <script type="text/javascript">
    var ctx = document.getElementById("lastChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: 'This week',
                data: [200, 222, 100, 244, 66, 87, 110],
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
              data: [123, 199, 97, 222, 88, 55, 32],
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
    <!-- Focus on Modal -->
    <script type="text/javascript">
    $('.modal').on('shown.bs.modal', function() {
      $(this).find('[autofocus]').focus();
    });
    </script>
    <script type="text/javascript">
      function addVehicle() {
        var company = $('#addCompany');
        var registration = $('#addRegistration');
        var trailer = $('#addTrl');
        var type = $('#addType:checked');
        var timein = $('#addTimein');

        $.ajax({
          url:"{URL}/core/vehicle.class.php?add",
          method:"post",
          data:$('#addVehicle').serilize(),
          success:function(data) {
            $('#addVehicle')[0].reset;
            $('#addVehicleModal').modal('hide');
            $('#BreakTable').html(data);
          }
        })
      }
    </script>
  </body>
</html>
