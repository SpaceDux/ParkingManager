<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth(1);

  $user->redirectRank(2);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Admin | User Management</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <?php $pm->PM_Nav();?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> Admin Tools <small>\\\</small> <b>User Management</b>
        </div>
      </div>
      <div id="tables">
        <div class="updateContent">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email address</th>
                      <th>Access ANPR</th>
                      <th>Rank</th>
                      <th>Campus</th>
                      <th>Currently Active</th>
                      <th>Last Processed Auth</th>
                      <th><button data-toggle="modal" data-target="#User_New" type="button" class="btn btn-danger"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $user->ListUsers();?>
                  </tbody>
                </table>
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
