<?php
  require(__DIR__.'/global.php');
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
      <div id="tables">
        <div class="updateContent">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Service Name</th>
                      <th>Service Price (Gross)</th>
                      <th>Service Price (Net)</th>
                      <th>Service Expiry (Hours)</th>
                      <th>Service Meal</th>
                      <th>Service Shower</th>
                      <th>Service Cash</th>
                      <th>Service Card</th>
                      <th>Service Account</th>
                      <th>Service SNAP</th>
                      <th>Service Fuel</th>
                      <th>Updated By</th>
                      <th>Service Campus</th>
                      <th><button data-toggle="modal" data-target="#Payment_Service_AddModal" type="button" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $payment->list_services();?>
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
    <script src="<?php echo URL?>/assets/js/jquery.lwMultiSelect.min.js"></script>
    <?php require(__DIR__."/assets/require.php");?>
    <script type="text/javascript">
    $('#Service_Vehicles_Update').lwMultiSelect({
      addAllText: "Select All",
      removeAllText: "Remove All",
      selectedLabel: "Values accepted",
      maxSelect: 0
    });
    </script>
  </body>
</html>
