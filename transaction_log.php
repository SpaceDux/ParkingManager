<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Transaction History</title>
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
          <a href="<?php echo URL ?>/main">Dashboard</a> <small>\\\</small><b> Transaction History</b>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <div class="row">
            <div class="row">
              <div class="col-md-12">
                <form class="form-row" action="" method="post" id="TL_Form">
                  <!-- <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="TL_Search" id="TL_Search" placeholder="Plate OR Company">
                  </div> -->
                  <div class="col">
                    <div class="input-group input-group-lg mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control" name="TL_DateStart" placeholder="Start Date" data-toggle="datepicker" id="TL_DateStart" value="<?php echo date("d-m-Y"); ?>" autocomplete="off">
                    </div>
                  </div>
                  <div class="col">
                    <div class="input-group input-group-lg mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control" name="TL_DateEnd" placeholder="End Date" data-toggle="datepicker" id="TL_DateEnd" value="<?php echo date("d-m-Y"); ?>" autocomplete="off">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <!-- <input type="hidden" name="TL_Cash" value="0"> -->
                      <input class="form-check-input" type="checkbox" name="TL_Cash" id="TL_Cash" value="1" checked>
                      <label class="form-check-label" for="TL_Cash">Cash</label>
                    </div>
                    <div class="form-check">
                      <!-- <input type="hidden" name="TL_Card" value="0"> -->
                      <input class="form-check-input" type="checkbox" name="TL_Card" id="TL_Card" value="1" checked>
                      <label class="form-check-label" for="TL_Card">Card</label>
                    </div>
                    <div class="form-check">
                      <!-- <input type="hidden" name="TL_Account" value="0"> -->
                      <input class="form-check-input" type="checkbox" name="TL_Account" id="TL_Account" value="1" checked>
                      <label class="form-check-label" for="TL_Account">Account</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-check">
                      <!-- <input type="hidden" name="TL_SNAP" value="0"> -->
                      <input class="form-check-input" type="checkbox" name="TL_SNAP" id="TL_SNAP" value="1" checked>
                      <label class="form-check-label" for="TL_SNAP">SNAP Account</label>
                    </div>
                    <div class="form-check">
                      <!-- <input type="hidden" name="TL_Fuel" value="0"> -->
                      <input class="form-check-input" type="checkbox" name="TL_Fuel" id="TL_Fuel" value="1" checked>
                      <label class="form-check-label" for="TL_Fuel">Fuel Card</label>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <select class="form-control form-control-lg" name="TL_Group" id="TL_Group" autocomplete="off">
                        <?php $payment->Payment_Service_Group_Dropdown() ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="btn-group" role="group" aria-label="View Sales">
                      <button type="button" id="TL_ViewSales" class="btn btn-lg btn-secondary">View Sales</button>
                      <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </button>
                      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#" onClick="EOD_SettlementToggle()">EOD Settlement</a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
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
