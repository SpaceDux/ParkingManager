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
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo URL ?>/index">
      <div class="brand">
        Parking<b>Manager</b>
      </div>
      </a>
      <ul>
        <a onClick="menuHide()"><li><i class="fas fa-align-justify"></i></li></a>
        <li data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></li>
        <li data-toggle="modal" data-target="#addVehicleModal"><i class="fa fa-plus"></i></li>
      </ul>
    </nav>
    <!-- Sidebar -->
    <nav id="sideBar" style="margin-left: -220px;">
      <div class="userBox">
        <div class="userInfo">
          <div class="userName">
            <?php echo $user->userInfo('first_name')?> <b><?php echo substr($user->userInfo('last_name'), 0, 1);?>.</b>
          </div>
          <div class="userLocation">
            RK: Holyhead | Security
          </div>
          <div class="pmVer">
            <?php echo VER ?>
          </div>
        </div>
        <div class="buttons">
          <a href="#settings"><i class="fa fa-cog"></i></a>
          <a href="<?php echo URL?>/logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="<?php echo URL ?>/main"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li class="active"><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="<?php echo URL?>/yardcheck" target="_blank"><li>Yard Check</li></a>
          </ul>
        </li>
        <li><i class="fa fa-pound-sign"></i> Payment Tools
          <ul>
            <a href="<?php echo URL?>/alltransactions"><li>Transactions History</li></a>
          </ul>
        </li>
        <li><i class="fa fa-book"></i> Account Tools
          <ul>
            <a href="<?php echo URL?>/reports"><li>Account Reports</li></a>
            <a href="<?php echo URL?>/reports"><li>Account Fleets</li></a>
          </ul>
        </li>
        <li><i class="fa fa-cogs"></i> P<b>M</b> Tools
          <ul>
            <a href="<?php echo URL?>/notices"><li>Notices</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
        <li><i class="fa fa-chart-line"></i> Admin Tools
          <ul>
            <a href="#"><li>Something</li></a>
          </ul>
        </li>
      </ul>
    </nav>
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
