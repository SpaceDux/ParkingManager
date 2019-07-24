<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{SITE_NAME}: Dashboard</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/vision.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body>
    <!-- Update Veh Pane START -->
    <div class="PaymentPane" id="UpdateVehPane">
      <div class="Title">
        update vehicle.
        <div class="btn-group float-right" role="group">
          <button type="button" class="btn btn-danger" onClick="UpdateVehPaneClose()"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="Body">
        <form id="UpdateVehicle_Form">
          <div class="row">
            <div class="col">
              <input type="hidden" name="Update_Ref" id="Update_Ref" class="form-control">
              <label for="Update_Plate">Update Vehicle Plate</label>
              <input type="text" class="form-control" name="Update_Plate" id="Update_Plate">
              <hr>
              <label for="Update_Name">Update Vehicle Company/Name</label>
              <input type="text" class="form-control" name="Update_Name" id="Update_Name">
              <hr>
              <label for="Update_Trailer">Update Vehicle Trailer</label>
              <input type="text" class="form-control" name="Update_Trailer" id="Update_Trailer">
              <hr>
              <label for="Update_VehType">Update Vehicle Type</label>
              <select class="form-control" id="Update_VehType" name="Update_VehType">
                <option value="unselected">Please Choose a Vehicle Type...</option>
                {VEHTYPES}
              </select>
              <hr>
              <label>ANPR Images</label>
              <div id="Update_Images">

              </div>
            </div>
            <div class="col">
              <div class="alert alert-primary" id="Update_Duration"></div>
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">Service</th>
                    <th scope="col">Method</th>
                    <th scope="col">Processed</th>
                    <th scope="col">Printed</th>
                    <th scope="col">Author</th>
                    <th scope="col"><button type="button" class="btn btn-sm btn-danger float-right"><i class="fa fa-pound-sign"></i> New Payment</button></th>
                  </tr>
                </thead>
                <tbody>
                  <div id="Update_PaymentsTable">

                  </div>
                </tbody>
              </table>
              <label for="Update_Column">Update Vehicle Parking Column</label>
              <select class="form-control" id="Update_Column" name="Update_Column">
                <option value="unselected">Please Choose a Parking Column...</option>
                <option value="1">Paid</option>
                <option value="2">Exit</option>
              </select>
              <hr>
              <label for="Update_Arrival">Update Time of Arrival</label>
              <input type="text" class="form-control" name="Update_Arrival" id="Update_Arrival">
              <hr>
              <label for="Update_Exit">Update Time of Exit</label>
              <input type="text" class="form-control" name="Update_Exit" id="Update_Exit">
              <hr>
              <label for="Update_Notes">Add a Comment</label>
              <textarea class="form-control" id="Update_Notes" name="Update_Notes"></textarea>
              <br><br><hr>
              <div class="btn-group btn-group-lg" role="group">
                <button type="button" class="btn btn-primary" onClick="UpdateVehicleRec()">Save <i class="fa fa-save"></i></button>
                <button type="button" class="btn btn-warning">Flag <i class="fa fa-flag"></i></button>
                <button type="button" class="btn btn-danger">Delete <i class="fa fa-trash"></i></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Update Pane END -->
    <!-- Payment Pane START -->
    <div class="PaymentPane" id="PaymentPane">
      <div class="Title">
        new transaction.
        <div class="btn-group float-right" role="group">
          <button type="button" class="btn btn-danger" onClick="PaymentPaneClose()"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="Body">
        <form id="PaymentPane_Form">
          <div class="row">
            <div class="col">
              <input type="hidden" name="Payment_Type" id="Payment_Type" class="form-control">
              <input type="hidden" name="Payment_Ref" id="Payment_Ref" class="form-control">
              <input type="hidden" name="Payment_CaptureDate" id="Payment_CaptureDate" class="form-control">
              <label>Vehicle Registration Plate</label>
              <input type="text" name="Payment_Plate" id="Payment_Plate" class="form-control" placeholder="E.G CY15GHX" style="text-transform: uppercase;" readonly>
              <hr>
              <label>Company / Name</label>
              <input type="text" name="Payment_Name" id="Payment_Name" class="form-control" placeholder="E.G EXAMPLE TRANSPORT" style="text-transform: uppercase;">
              <hr>
              <label>Vehicle Trailer Number</label>
              <input type="text" name="Payment_Trl" class="form-control" id="Payment_Trl" placeholder="E.G TRL001" style="text-transform: uppercase;">
              <hr>
              <label>Vehicle Type</label>
              <select class="form-control" id="Payment_VehType" name="Payment_VehType">
                <option value="unselected">Please Choose a Vehicle Type...</option>
                {VEHTYPES}
              </select>
              <hr>
              <div id="ANPR_Images">

              </div>
            </div>
            <div class="col">
              <div class="alert alert-primary" id="Payment_TimeCalculation"></div>
              <label>How many days parking</label><br>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                  <input type="radio" name="Payment_Services_Expiry" value="24" autocomplete="off" checked=""> 1 Day
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="48" autocomplete="off"> 2 Days
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="72" autocomplete="off"> 3 Days
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="96" autocomplete="off"> 4 Days
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="120" autocomplete="off"> 5 Days
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="144" autocomplete="off"> 6 Days
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="Payment_Services_Expiry" value="168" autocomplete="off"> 7 Days
                </label>
              </div>
              <hr>
              <div id="PaymentOptions">

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Payment Pane END -->
    <div class="TopBar">
      <div class="Logo">
        <a href="{URL}/main">Parking<b>Manager</b></a>
      </div>
      <div class="Logo_mbl">
        <a href="{URL}/main">P<b>M</b></a>
      </div>
      <div class="Options">
        <a href="#" class="mbl_only" onClick="Navi_Tog()"><i class="fa fa-align-justify"></i></a>
        <a href="#"><i class="fa fa-search"></i></a>
        <a href="#" onClick="ANPR_AddPlate()"><i class="fa fa-plus"></i></a>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-key"></i>
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Open Entry Barrier</a>
          <a class="dropdown-item" href="#">Open Exit Barrier</a>
        </div>
      </div>
      <div class="Options-Right">
        <div class="Btn" id="NotificationsBtn" onClick="Notifications()"><i class="fas fa-bell"></i></div>
        <a href="#"><i class="fa fa-user"></i></a>
      </div>
    </div>
    <div class="Navigation_Bar">
      <ul>
        <li class="Selected">
          <a href="{URL}/main">
            <i class="fa fa-tachometer-alt"></i>
            DASHBOARD
          </a>
        </li>
        <li>
          <a>
            <i class="fa fa-truck"></i>
            VEHICLE TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Yard Check</a>
          </div>
        </li>
        <li>
          <a>
            <i class="fa fa-pound-sign"></i>
            PAYMENT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Transaction History</a>
            <a href="#yc">Settlement Structure</a>
          </div>
        </li>
        <li>
          <a>
            <i class="fa fa-file-invoice"></i>
            ACCOUNT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Account Management</a>
            <a href="#se">Reports</a>
          </div>
        </li>
        <li>
          <a>
            <i class="fa fa-cogs"></i>
            P<b>M</b> TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Notices</a>
            <a href="#se">User Management</a>
            <a href="#se">Site Management</a>
          </div>
        </li>
      </ul>
    </div>
    <div class="NotificationPane" id="NotificationPane">
      <div class="Body">
        <div id="Load_Notifications">

        </div>
      </div>
    </div>
    <div class="StatBar">
      <div class="StatContent">
        <div class="row">
          <div class="col-md-3">
            <div class="StatBox">
              <div class="Stat">
                <b id="ALL_Count"></b><small>/200</small>
              </div>
              <div class="Text">
                vehicles <b>parked</b>
              </div>
              <div class="Icon">
                <i class="fa fa-road"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="StatBox">
              <div class="Stat">
                <b id="ANPR_Count"></b>
              </div>
              <div class="Text">
                awaiting <b>payment</b>
              </div>
              <div class="Icon">
                <i class="fa fa-shopping-basket"></i>
              </div>
            </div>
            <div class="StatBox">
              <div class="Stat">
                <b id="RENEWAL_Count"></b>
              </div>
              <div class="Text">
                awaiting <b>renewal</b>
              </div>
              <div class="Icon">
                <i class="fa fa-clock"></i>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="StatBox-LG">
              <canvas id="myChart" style="max-width: 97%;max-height: 100%;display: block;margin: 0 auto;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="Wrapper" id="Wrapper">
      <div class="row">
        <div class="col-md-7">
          <div class="Box">
            <div class="Title">
              <i class="fa fa-video" style="color: red; padding-right: 10px;"></i>  Live ANPR Feed
              <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                <button type="button" class="btn btn-secondary" onClick="ANPR_AddPlate()"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-secondary" onClick="ANPR_Feed_Refresh()"><i class="fa fa-redo-alt"></i></button>
              </div>
            </div>
            <div id="ANPR_Feed">

            </div>
          </div>
          <div class="Box">
            <div class="Title">
              PAID Feed
            </div>
            <div id="PAID_Feed">

            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="Box">
            <div class="Title">
              RENEWALS Feed
            </div>
            <div id="RENEWAL_Feed">

            </div>
          </div>
          <div class="Box">
            <div class="Title">
              EXIT Feed
            </div>
            <div id="EXIT_Feed">

            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/vision.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/Chart.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/mousetrap.min.js"></script>
    <script type="text/javascript">
      Mousetrap.bind('esc', function() {
        $('#ANPR_AddPlate_Form')[0].reset();
        $('#AddPlate_Plate').focus();
        ANPR_AddPlate();
      });

      var ctx = document.getElementById('myChart');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
          			labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
          			datasets: [{
          				label: 'This Week',
          				backgroundColor: 'rgba(197,197,197,0.7)',
          				borderColor: 'rgba(96,96,96,0.7)',
          				fill: true,
          				data: [177,111,165,133,134,176,144]
          			}, {
          				label: 'Last Week',
                  backgroundColor: 'rgba(96,96,96,0.7)',
          				borderColor: 'rgba(197,197,197,0.7)',
          				fill: true,
          				data: [188,166,122,144,168,155,157]
          			}]
          		},
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true
                      }
                  }]
              }
          }
      });
      // Handle Modal autofocus
      $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
      });
    </script>
    <?php require("core/ajax/controller.php"); ?>
    <?php require("modals.php"); ?>
  </body>
</html>
