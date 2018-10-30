<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: 24hr Transaction History</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body style="background: #fff;">
    <?php $pm->PM_Nav() ?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/main">Dashboard</a> <small>\\\</small><b> Transaction History (9pm - 9pm)</b>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-dark table-hover table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Company</th>
                    <th scope="col">Plate</th>
                    <th scope="col">Payment Service Name</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Gross</th>
                    <th scope="col">Net</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment Ref</th>
                    <th scope="col">Account</th>
                    <th scope="col">Author</th>
                    <th scope="col"><i class="fa fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $payment->Transaction_Log_24() ?>
                </tbody>
              </table>
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
