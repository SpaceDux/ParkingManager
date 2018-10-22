<?php
  require(__DIR__.'/global.php');
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
              <b><?php echo $vehicles->vehicle_count_paid() + $vehicles->vehicle_count_anpr();?></b><small>/200</small>
              </div>
              <div class="statText">
                vehicles <b>parked</b>
              </div>
            </div>
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
                <i class="fas fa-shopping-basket"></i>
              </div>
              <div class="Stat">
                <b><?php echo $vehicles->vehicle_count_anpr();?></b>
              </div>
              <div class="statText">
                awaiting <b>payment</b>
              </div>
            </div>
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
          <div class="col-md-6">
            <div class="statBox-LG">
              <canvas id="lastChart" width="400" height="auto" style="width:auto;max-height:181px;"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div id="tables">
      <div class="row">
        <div class="col-md-7">
          <?php $pm->displayNotice(); ?>
          <!-- ANPR Feed Table -->
            <div class="content">
              <div class="title">
                <b style="color:red;">Live</b> ANPR Feed
                <div class="float-right"><button type="button" class="btn btn-primary" id="refreshANPR"><i class="fa fa-sync"></i></button></div>
              </div>
              <div id="anpr">
              <table class="table table-dark table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">Registration</th>
                    <th scope="col">Time IN</th>
                    <th scope="col">Patch</th>
                    <th scope="col"><i class="fa fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $vehicles->get_anprFeed()?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Paid Vehicles Table -->
          <div class="content">
            <div class="title">
              Paid Vehicles
            </div>
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col">T.ID</th>
                  <th scope="col float"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                  <?php $vehicles->get_paidFeed()?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-5">
          <div class="content">
            <div class="title">
              Renewals
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php $vehicles->get_renewalFeed() ?>
              </tbody>
            </table>
          </div>
          <div class="content">
            <div class="title">
              Recently Exit Vehicles
            </div>
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Registration</th>
                  <th scope="col">Type</th>
                  <th scope="col">Time OUT</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php $vehicles->get_exitFeed() ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <footer>
        <?php echo Footer ?>
      </footer>
    </div>
    </div>
    <?php require(__DIR__.'/assets/modals.php');?>
    <!-- javascript Files -->
    <script src="<?php echo URL?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/mousetrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/Chart.bundle.min.js"></script>
    <?php require(__DIR__.'/assets/require.php');?>
    <!-- Chart JS -->
    <script type="text/javascript">
    var ctx = document.getElementById("lastChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: 'This week',
                data: [190, 122, 221, 120, 200, 222, 170],
                borderWidth: [0],
                backgroundColor: [
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
            },
            {
              label: 'Last week',
              data: [90, 177, 221, 123, 229, 222, 122],
              borderWidth: [0],
              backgroundColor: [
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)'
              ],
              borderColor: [
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)'
              ]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    </script>
  </body>
</html>
