<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{SITE_NAME}: Account Reports</title>
    {STYLESHEETS}
  </head>
  <body>
    <!-- Update Veh Pane START -->
    <div class="PaymentPane" id="UpdateVehPane" >
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
              <input type="hidden" name="Update_Expiry" id="Update_Expiry" class="form-control">
              <input type="hidden" name="Update_Flag" id="Update_Flag" class="form-control">
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
              <div id="Update_PaymentsTable">

              </div>
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
              <div class="btn-group btn-lg">
                <button type="button" class="btn btn-dark" onClick="UpdateVehicleRec()">Save <i class="fa fa-save"></i></button>
                <button type="button" class="btn btn-dark" id="Update_FlagBtn">Flag <i class="fa fa-flag"></i></button>
                <button type="button" class="btn btn-dark" id="Update_ExitBtn">Exit <i class="fa fa-times"></i></button>
                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Delete Vehicle</a>
                </div>
              </div>
              <span class="badge badge-secondary float-right" id="UD_Ref"></span>
              <span class="badge badge-primary float-right" id="UD_ExitKey"></span>
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
    <!-- Transaction List Pane START -->
    <div class="PaymentPane" id="TransactionListPane">
      <div class="Title">
        view all transactions.
        <div class="btn-group float-right" role="group">
          <button type="button" class="btn btn-danger" onClick="ListTransactionsPaneClose()"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="Body">
        <form class="form-row" action="{URL}/download_sales.php" method="POST" id="TransactionListForm">
        <div class="col">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input type="text" class="form-control" name="TL_DateStart" placeholder="Start Date" id="TL_DateStart" value="<?php echo date("d-m-Y", strtotime("- 1 day")) ?>" autocomplete="off" style="z-index: 10000;">
          </div>
        </div>
        <div class="col">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input type="text" class="form-control" name="TL_DateEnd" placeholder="End Date"  id="TL_DateEnd" value="<?php echo date("d-m-Y") ?>" autocomplete="off" style="z-index: 10000;">
          </div>
        </div>
        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_Cash" id="TL_Cash" value="1" checked="">
            <label class="form-check-label" for="TL_Cash">Cash</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_Card" id="TL_Card" value="1" checked="">
            <label class="form-check-label" for="TL_Card">Card</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_Account" id="TL_Account" value="1" checked="">
            <label class="form-check-label" for="TL_Account">Account</label>
          </div>
        </div>
        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_SNAP" id="TL_SNAP" value="1" checked="">
            <label class="form-check-label" for="TL_SNAP">SNAP Account</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_Fuel" id="TL_Fuel" value="1" checked="">
            <label class="form-check-label" for="TL_Fuel">Fuel Card</label>
          </div>
          <!-- <div class="form-check">
            <input class="form-check-input" type="checkbox" name="TL_Deleted" id="TL_Deleted" value="1" checked="">
            <label class="form-check-label" for="TL_Deleted">Hide Deleted</label>
          </div> -->
        </div>
        <div class="col">
          <div class="form-group">
            <select class="form-control form-control-lg" name="TL_Group" id="TL_Group" autocomplete="off">
              <option value="unselected">-- Choose a Group --</option>
              {TARIFF_GROUPS}
            </select>
          </div>
        </div>
        <div class="col">
          <div class="btn-group float-right" role="group" aria-label="View Sales">
            <button type="button" id="TL_ViewSales" class="btn btn-lg btn-secondary">View Sales</button>
            <button type="submit" class="btn btn-lg btn-secondary"><i class="fa fa-download"></i></button>
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              <a class="dropdown-item" href="#" onclick="EOD_SettlementToggle()">EOD Settlement</a>
            </div>
          </div>
        </div>
      </form>
        <table id="PaymentsDataTable" class="table table-dark table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Registration</th>
              <th>Service</th>
              <th>Gross</th>
              <th>Nett</th>
              <th>Method</th>
              <th>Processed</th>
              <th>Account</th>
              <th>Author</th>
              <th><i class="fa fa-cogs"></i></th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>Registration</th>
              <th>Service</th>
              <th>Gross</th>
              <th>Nett</th>
              <th>Method</th>
              <th>Processed</th>
              <th>Account</th>
              <th>Author</th>
              <th><i class="fa fa-cogs"></i></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <!-- Transaction List Pane END -->
    <!-- Top Navigation Bar START -->
    <div class="TopBar">
      <div class="Logo">
        <a href="{URL}/main">Parking<b>Manager</b></a>
      </div>
      <div class="Logo_mbl">
        <a href="{URL}/main">P<b>M</b></a>
      </div>
      <div class="Options">
        <a href="#" class="mbl_only" onClick="Navi_Tog()"><i class="fa fa-align-justify"></i></a>
        <a href="#" data-toggle="modal" data-target="#Search_Records_Modal"><i class="fa fa-search"></i></a>
        <a href="#" onClick="ANPR_AddPlate()"><i class="fa fa-plus"></i></a>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-key"></i>
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#" onClick="BarrierToggle(1)">Open Entry Barrier</a>
          <a class="dropdown-item" href="#" onClick="BarrierToggle(2)">Open Exit Barrier</a>
        </div>
      </div>
      <div class="Options-Right">
        <div class="Btn" id="NotificationsBtn" onClick="Notifications()"><i class="fas fa-bell"></i></div>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user"></i>
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#" onClick="Logout()">Logout</a>
        </div>
      </div>
    </div>
    <!-- Top Navigation Bar END -->
    <!-- Main Navigation Bar START -->
    <div class="Navigation_Bar">
      <ul>
        <li>
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
            <a target="_blank" href="{URL}/yardcheck">Yard Check</a>
          </div>
        </li>
        <li>
          <a>
            <i class="fa fa-pound-sign"></i>
            PAYMENT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a onClick="ListTransactionsPane()">Transaction History</a>
            <a href="#">Settlement Structure</a>
            <a href="{URL}/tariffs">Tariffs</a>
          </div>
        </li>
        <li class="Selected">
          <a>
            <i class="fa fa-file-invoice"></i>
            ACCOUNT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="{URL}/accounts">Account Management</a>
            <a href="{URL}/reports">Reports</a>
          </div>
        </li>
        <li>
          <a>
            <i class="fa fa-cogs"></i>
            P<b>M</b> TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#notices">Notices</a>
            <a href="{URL}/users">User Management</a>
            <a href="{URL}/sites">Site Management</a>
          </div>
        </li>
      </ul>
    </div>
    <!-- Main Navigation Bar END -->
    <!-- Notifications Pane START -->
    <div class="NotificationPane" id="NotificationPane">
      <div class="Body">
        <div id="Load_Notifications">

        </div>
      </div>
    </div>
    <!-- Notifications Pane END -->
    <!-- Stat Bar START -->
    <div class="StatBar">
      <div class="StatContent">
        <div class="row">
          <div class="col-md-3">
            <div class="StatBox">
              <div class="Stat">
                <b>{ALL_COUNT}</b><small>/200</small>
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
                <b>{ANPR_COUNT}</b>
              </div>
              <div class="Text">
                awaiting <b>payment</b>
              </div>
              <div class="Icon">
                <i class="fa fa-shopping-basket"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="StatBox">
              <div class="Stat">
                <b>{RENEWAL_COUNT}</b>
              </div>
              <div class="Text">
                awaiting <b>renewal</b>
              </div>
              <div class="Icon">
                <i class="fa fa-clock"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Stat Bar END -->
    <div class="Wrapper" id="Wrapper">
      <div class="row" style="padding-top: 10px;">
        <div class="col">
          <div class="jumbotron">
            <h1 class="display-7">Account Reports</h1>
            <p class="lead">To view account transactions, please choose an account and a date range.
            <form action="{URL}/download_report.php" method="post">
              <div class="row">
                <div class="col-md-2">
                  <select class="form-control" name="Report_Account" id="Report_Account" required>
                    <option>-- Please choose an Account --</option>
                    {ACCOUNTS}
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="Date From" name="Report_DateFrom" id="Report_DateFrom" value="<?php echo date("Y-m-01") ?>" required>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control" placeholder="Date Too" name="Report_DateToo" id="Report_DateToo" value="<?php echo date("Y-m-31") ?>" required>
                </div>
                <div class="col-md-2">
                  <div class="btn-group dropdown">
                    <button type="button" id="Report_Generate" class="btn btn-primary">Generate</button>
                    <input type="submit" id="Report_Generate_Download" class="btn btn-primary" value="Download">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div id="AccountTotals">

          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table id="AccReport_Tbl" class="table table-dark table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Registration</th>
                <th>Service</th>
                <th>Gross</th>
                <th>Nett</th>
                <th>Processed</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Registration</th>
                <th>Service</th>
                <th>Gross</th>
                <th>Nett</th>
                <th>Processed</th>
                <th><i class="fa fa-cogs"></i></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    {SCRIPTS}
    <script type="text/javascript">
      $( function() {
        $( "#Report_DateFrom" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#Report_DateToo" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#TL_DateStart" ).datepicker({dateFormat: "dd-mm-yy"});
        $( "#TL_DateEnd" ).datepicker({dateFormat: "dd-mm-yy"});
      });

      Mousetrap.bind('esc', function() {
        $('#ANPR_AddPlate_Form')[0].reset();
        $('#AddPlate_Plate').focus();
        ANPR_AddPlate();
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
