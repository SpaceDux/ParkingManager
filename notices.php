<?php
  require(__DIR__.'/global.php');

  if(isset($_POST['add_notice_short'])) {
    $pm->newNotice($_POST['add_notice_short'], $_POST['add_notice_body'], $_POST['add_notice_type']);

    unset($_POST['add_notice_short']);
    unset($_POST['add_notice_body']);
    unset($_POST['add_notice_type']);
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Notices</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body style="background: #fff;">
    <!-- Top Navbar -->
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo URL?>/index">
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
            <a href="<?php echo URL?>/reports"><li>Transactions History</li></a>
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
      </ul>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small><b> Manage Notices</b>
        </div>
      </div>
      <div id="tables">
      <div class="updateContent">
        <div class="container">
          <div class="row">
            <div class="col">
              <?php $pm->listNotices() ?>
            </div>
            <div class="col">
              <form method="post" id="add_notice">
                <div class="form-group">
                  <label for="add_notice_short">Short Title</label>
                  <input type="text" class="form-control" name="add_notice_short" id="add_notice_short" placeholder="HEADS UP:..." required autofocus>
                </div>
                <div class="form-group">
                  <label for="add_notice_body">Body</label>
                  <textarea type="text" id="add_notice_body" class="form-control" name="add_notice_body" rows="3" cols="1" form="add_notice" placeholder="The driver of this vehicle has been...." required></textarea>
                </div>
                <div class="form-group">
                  <label>Alert Colour</label>
                  <select class="custom-select" name="add_notice_type">
                    <option value="info"> Blue </option>
                    <option value="primary"> Darker Blue </option>
                    <option value="warning"> Yellow </option>
                    <option value="danger"> Red </option>
                    <option value="success"> Green </option>
                    <option value="dark"> Black </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="add_notice_body"></label>
                  <button type="submit" class="btn btn-success float-right">Add Notice</button>
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
    <?php require(__DIR__."/assets/require.php");?>
  </body>
</html>
