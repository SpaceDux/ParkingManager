<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth(1);

  $user->redirectRank(2);
  if(isset($_POST['addVehicleTypeName'])) {
    $pm->addVehicleType($_POST['addVehicleTypeName'], $_POST['addVehicleTypeShort'], $_POST['addVehicleTypeURL']);
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Admin | Services</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/jquery.lwMultiSelect.css">
  </head>
  <body>
    <?php $pm->PM_Nav();?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> Admin Tools <small>\\\</small> <b>Services</b>
        </div>
      </div>
        <div class="updateContent">
          <div class="container">
            <ul class="nav nav-tabs" id="Payment_Service_Tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="0-tab" data-toggle="tab" href="#dev" role="tab" aria-controls="0" aria-selected="false">Roadking: Development</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="1-tab" data-toggle="tab" href="#holyhead" role="tab" aria-controls="1" aria-selected="false">Roadking: Holyhead</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="2-tab" data-toggle="tab" href="#hollies" role="tab" aria-controls="2" aria-selected="false">Roadking: Hollies</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="dev" role="tabpanel" aria-labelledby="dev">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Service Name</th>
                      <th>Price (Gross)</th>
                      <th>Price (Net)</th>
                      <th>Cash</th>
                      <th>Card</th>
                      <th>Account</th>
                      <th>SNAP</th>
                      <th>Fuel Card</th>
                      <th>Meal Voucher</th>
                      <th>Shower Voucher</th>
                      <th>Discount Voucher</th>
                      <th>WiFi Voucher</th>
                      <th>SNAP API</th>
                      <th>Active</th>
                      <th><button data-toggle="modal" data-target="#Payment_Service_AddModal" type="button" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $payment->Payment_Services_List(0);?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="holyhead" role="tabpanel" aria-labelledby="holyhead">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Service Name</th>
                      <th>Price (Gross)</th>
                      <th>Price (Net)</th>
                      <th>Cash</th>
                      <th>Card</th>
                      <th>Account</th>
                      <th>SNAP</th>
                      <th>Fuel Card</th>
                      <th>Meal Voucher</th>
                      <th>Shower Voucher</th>
                      <th>Discount Voucher</th>
                      <th>WiFi Voucher</th>
                      <th>SNAP API</th>
                      <th>Active</th>
                      <th><button data-toggle="modal" data-target="#Payment_Service_AddModal" type="button" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $payment->Payment_Services_List(1);?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade" id="hollies" role="tabpanel" aria-labelledby="hollies">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Service Name</th>
                      <th>Price (Gross)</th>
                      <th>Price (Net)</th>
                      <th>Cash</th>
                      <th>Card</th>
                      <th>Account</th>
                      <th>SNAP</th>
                      <th>Fuel Card</th>
                      <th>Meal Voucher</th>
                      <th>Shower Voucher</th>
                      <th>Discount Voucher</th>
                      <th>WiFi Voucher</th>
                      <th>SNAP API</th>
                      <th>Active</th>
                      <th><button data-toggle="modal" data-target="#Payment_Service_AddModal" type="button" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $payment->Payment_Services_List(2);?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Vehicle Type Name</th>
                      <th>Vehicle Type Short</th>
                      <th>Vehicle Image</th>
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $pm->PM_VehicleTypes(); ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-4">
                <form action="services.php" method="post">
                  <div class="form-group">
                    <label>Vehicle Type Name</label>
                    <input type="text" class="form-control" name="addVehicleTypeName" value="" placeholder="Vehicle Type Name">
                  </div>
                  <div class="form-group">
                    <label>Vehicle Type Short-name</label>
                    <input type="text" class="form-control" name="addVehicleTypeShort" value="" placeholder="C/T" style="text-transform:uppercase;">
                  </div>
                  <div class="form-group">
                    <label>Vehicle Type Image URL</label>
                    <input type="text" class="form-control" name="addVehicleTypeURL" value="" placeholder="http://example.com/img.png">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Add Type">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <footer>
        <?php echo Footer ?>
      </footer>
    </div>
    <?php require(__DIR__."/assets/modals.php");?>
    <!-- javascript Files -->
    <script src="<?php echo URL?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/mousetrap.min.js"></script>
    <?php require(__DIR__."/assets/require.php");?>
  </body>
</html>
