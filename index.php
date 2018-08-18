<?php
  require(__DIR__.'/global.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Login</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo URL ?>/index">
      <div class="brand">
        Parking<b>Manager</b>
      </div>
      </a>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Parking Manager</a> <small>\\\</small> <b>Login</b>
        </div>
      </div>
      <div class="text-center">
        <?php
        #Initialize Login
        if(isset($_POST['pm_login_email'])) {
          $user->Login($_POST['pm_login_email'], $_POST['pm_login_pass']);
        }
        ?>
        <form class="form-signin" method="post">
          <label for="PM_Email" class="sr-only">Email address</label>
          <input autocomplete="new-password" type="email" name="pm_login_email" id="PM_Email" class="form-control" placeholder="Email Address" required autofocus>
          <label for="PM_Pass" class="sr-only">Password</label>
          <input autocomplete="new-password" type="password" name="pm_login_pass" id="PM_Pass" class="form-control" placeholder="Password" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
      </div>
      <footer style="position: fixed; bottom: 0;">
        ParkingManager (PM) &copy; 2018/2019 | Designed, developed by <a href="mailto:ryan@roadkingcafe.uk"><b>Ryan. W</b> with RoadKing Truckstops &copy;</a>
      </footer>
    </div>
    <!-- javascript Files -->
    <script src="<?php echo URL ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL ?>/assets/js/mousetrap.min.js"></script>
  </body>
</html>
