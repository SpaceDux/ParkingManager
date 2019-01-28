<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth(1);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Main Hub</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
    <?php $pm->PM_Nav() ?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <!-- Dark Header -->
      <div class="darkHead">
        <div class="row">
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-truck"></i>
              </div>
              <div class="Stat">
              <b><?php echo $vehicles->vehicle_count_paid() + $vehicles->vehicle_count_anpr() + $vehicles->vehicle_count_renewals();?></b><small>/200</small>
              </div>
              <div class="statText">
                vehicles <b>parked</b>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-shopping-basket"></i>
              </div>
              <div class="Stat">
                <b><?php echo $vehicles->vehicle_count_anpr();?></b>
              </div>
              <div class="statText">
                awaiting <b>payment</b>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="far fa-clock"></i>
              </div>
              <div class="Stat">
                <b><?php echo $vehicles->vehicle_count_renewals();?></b>
              </div>
              <div class="statText">
                renewals
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="statBox">
              <div class="statIcon">
                <i class="fas fa-h-square"></i>
              </div>
              <div class="Stat">
              <b>2</b>
              </div>
              <div class="statText">
                rooms <b>checked-in</b>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="statBox-LG">
              <canvas id="lastChart" width="400" height="auto" style="width:auto;max-height:181px;"></canvas>
            </div>
          </div> -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-7">
          <?php $pm->displayNotice(); ?>
          <!-- ANPR Feed Table -->
          <div class="content">
            <div class="title">
              <b style="color:red;">Live</b> ANPR Feed
              <div class="btn-group float-right" role="group" aria-label="">
                <button type="button" class="btn btn-primary" id="refreshANPR"><i class="fa fa-sync-alt"></i></button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ANPR_FilterSearchModal"><i class="fa fa-search"></i></button>
              </div>
            </div>
            <div id="ANPR_Feed">

            </div>
          </div>
          <!-- Paid Vehicles Table -->
          <div class="content">
            <div class="title">
              Paid Vehicles
            </div>
            <div id="PAID_Feed">

            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="content">
            <div class="title">
              Renewals
            </div>
            <div id="RENEWAL_Feed">

            </div>
          </div>
          <div class="content">
            <div class="title">
              Recently Exit Vehicles
            </div>
            <div id="EXIT_Feed">

            </div>
          </div>
        </div>
      </div>
      <footer>
        <?php echo Footer ?>
      </footer>
    </div>
    <?php require(__DIR__.'/assets/modals.php');?>
    <!-- javascript Files -->
    <script src="<?php echo URL?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/mousetrap.min.js"></script>
    <?php require(__DIR__.'/assets/require.php');?>
    <script type="text/javascript">
    //Tab Key opens "AddVehicleModal" Modal
      Mousetrap.bind('tab', function() {
        $('#ANPR_AddModal').modal('show');
        var d = new Date();
        var date = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
        var h = addZero(d.getHours());
        var m = addZero(d.getMinutes());
        var s = addZero(d.getSeconds());
        var datetime = date+' '+h+':'+m+':'+s;
        $('#ANPR_Add_Date').val(datetime);
        $(this).find('[autofocus]').focus();
      });
    </script>
  </body>
</html>
