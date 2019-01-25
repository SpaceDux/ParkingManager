<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth(1);


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
    <?php $pm->PM_Nav() ?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small><b> Manage Notices</b>
        </div>
      </div>
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
