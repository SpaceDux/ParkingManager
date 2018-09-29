<?php
  require(__DIR__.'/global.php');
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
