<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{SITE_NAME}: Account Reports</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/vision.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/jquery-ui.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body>
    <!-- Transaction List START -->
    <div class="PaymentPane" id="TransactionListPane">
      <div class="Title">
        view all transactions.
        <div class="btn-group float-right" role="group">
          <button type="button" class="btn btn-danger" onClick="ListTransactionsPaneClose()"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="Body">
        <form class="form-row" action="" method="post" id="TransactionListForm">
        <div class="col">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input type="text" class="form-control" name="TL_DateStart" placeholder="Start Date" data-toggle="datepicker" id="TL_DateStart" value="<?php echo date("d-m-Y", strtotime("- 1 day")) ?>" autocomplete="off">
          </div>
        </div>
        <div class="col">
          <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
            <input type="text" class="form-control" name="TL_DateEnd" placeholder="End Date" data-toggle="datepicker" id="TL_DateEnd" value="<?php echo date("d-m-Y") ?>" autocomplete="off">
          </div>
        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">

        </div>
        <div class="col">
          <div class="btn-group float-right" role="group" aria-label="View Sales">
            <button type="button" id="TL_ViewSales" class="btn btn-lg btn-secondary">View Sales</button>
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
    <!-- Payment Pane END -->
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
            <a href="#yardcheck">Yard Check</a>
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
          </div>
          <div class="col-md-3">
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
            <div class="row">
              <div class="col-md-2">
                <select class="form-control" name="SitePick" id="Report_Account">
                  <option value="unselected">-- Please choose an Account --</option>
                  {ACCOUNTS}
                </select>
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Date From" id="Report_DateFrom" value="<?php echo date("Y-m-01") ?>">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Date Too" id="Report_DateToo" value="<?php echo date("Y-m-31") ?>">
              </div>
              <div class="col-md-2">
                <div class="btn-group dropdown">
                  <button type="button" id="Report_Generate" class="btn btn-primary">Generate</button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only"></span>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Download</a>
                  </div>
                </div>
              </div>
            </div>
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
    <script type="text/javascript" src="{URL}/template/{TPL}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/vision.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/Chart.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/mousetrap.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/datatables.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/notify.min.js"></script>

    <script type="text/javascript">
      $( function() {
        $( "#Report_DateFrom" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#Report_DateToo" ).datepicker({dateFormat: "yy-mm-dd"});
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
