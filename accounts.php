<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Account List</title>
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
          <a href="<?php echo URL ?>/main">Dashboard</a> <small>\\\</small><b> Account List</b>
        </div>
      </div>
      <div id="tables">
        <div class="updateContent">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Account Name</th>
                      <th scope="col">Account Tel</th>
                      <th scope="col">Account Email</th>
                      <th scope="col">Account Site</th>
                      <th scope="col">Account Updated</th>
                      <th scope="col">Account Shared</th>
                      <th scope="col">Fleet</th>
                      <th><button data-toggle="modal" data-target="#New_AccountModal" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $account->Account_ListAll(); ?>
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
