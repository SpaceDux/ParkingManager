<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Account Report</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/datepicker.min.css">
  </head>
  <body style="background: #fff;">
    <?php $pm->PM_Nav() ?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/main">Dashboard</a> <small>\\\</small><b> Account Report</b>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <form class="form-row" action="" method="post">
                <div class="col">
                  <?php $account->Account_List_Dropdown() ?>
                </div>
                <div class="col">
                  <div class="input-group input-group-lg mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="DateFromIcon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Report Start Date" data-toggle="datepicker" id="DateFrom">
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-lg mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="DateTooIcon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Report End Date" data-toggle="datepicker" id="DateToo">
                  </div>
                </div>
                <div class="col-md-2">
                  <button type="button" id="GenerateAccountReport" class="btn btn-success btn-lg">Generate Report</button>
                </div>
              </form>
            </div>
          </div>
          <div id="result">
            
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
    <script src="<?php echo URL?>/assets/js/datepicker.min.js"></script>
    <?php require(__DIR__."/assets/require.php");?>
    <script type="text/javascript">
    $('[data-toggle="datepicker"]').datepicker({format: 'dd-mm-yyyy'});
  </script>
  </body>
</html>
