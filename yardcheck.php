<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Yard Check</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <?php $pm->PM_Nav()?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Parking Manager</a> <small>\\\</small> <b>Yard Check</b>
        </div>
      </div>
      <div class="updateContent">
        <table class="table table-dark table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col">Company</th>
              <th scope="col">Registration</th>
              <th scope="col">Type</th>
              <th scope="col">Time IN</th>
              <th scope="col">Ticket ID's</th>
              <th scope="col"><i class="fa fa-cog"></i></th>
            </tr>
          </thead>
          <tbody>
            <?php $vehicles->yardCheck() ?>
          </tbody>
        </table>
      </div>
      <footer>
        <?php echo Footer ?>
      </footer>
    </div>
    <?php require(__DIR__.'/assets/modals.php');?>
    <!-- javascript Files -->
    <script src="<?php echo URL ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/mousetrap.min.js"></script>
    <?php require(__DIR__.'/assets/require.php');?>
  </body>
</html>
