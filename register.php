<?php
  require __DIR__.'/global.php';

  if(isset($_POST['reg_firstName'])){
    $first = $_POST['reg_firstName'];
    $second = $_POST['reg_secondName'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $rank = $_POST['reg_rank'];

    $pm->regUser($first, $second, $email, $password, $rank);
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: Register</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $url ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <!-- Top Navbar -->
    <!-- Top Navbar -->
    <nav class="topBar">
      <a href="<?php echo $url?>/index">
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
            Road <b>K</b>.
          </div>
          <div class="userLocation">
            RK: Holyhead | Security
          </div>
          <div class="pmVer">
            <?php echo $ver?>
          </div>
        </div>
        <div class="buttons">
          <a href="#settings"><i class="fa fa-cog"></i></a>
          <a href="#logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
      </div>
      <ul>
        <a href="<?php echo $url ?>/index"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>
        <li><i class="fa fa-truck-moving"></i> Vehicle Tools
          <ul>
            <a href="<?php echo $url?>/yardcheck" target="_blank"><li>Yard Check</li></a>
          </ul>
        </li>
        <li><i class="fa fa-book"></i> Account Tools
          <ul>
            <a href="<?php echo $url?>/reports"><li>Account Reports</li></a>
          </ul>
        </li>
        <li class="active"><i class="fa fa-cogs"></i> P<b>M</b> Tools
          <ul>
            <a href="<?php echo $url?>/notices"><li>Notices</li></a>
            <a href="#"><li>Users</li></a>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo $url ?>/index">Dashboard</a> <small>\\\</small> PM Tools<small>\\\</small> <b>New User</b>
        </div>
      </div>
      <div class="updateContent" id="tables">
        <div class="container">
          <div class="row">
            <div class="col">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email Adress</th>
                    <th scope="col"><i class="fa fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pm->fetchUsers() as $row) {?>
                  <tr>
                    <td><?php echo $row['first_name']?></td>
                    <td><?php echo $row['second_name']?></td>
                    <td><?php echo $row['email']?></td>
                    <td>
                      <button class="btn btn-sm btn-danger"><i class="fa fa-cog"></i></button>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
            <div class="col">
              <form method="post" id="reg_user">
                <div class="form-group">
                  <label for="reg_firstName">First Name</label>
                  <input type="text" class="form-control" name="reg_firstName" id="reg_firstName" placeholder="First Name" autofocus>
                </div>
                <div class="form-group">
                  <label for="reg_secondName">Second Name</label>
                  <input type="text" class="form-control" name="reg_secondName" id="reg_secondName" placeholder="Second Name" autofocus>
                </div>
                <div class="form-group">
                  <label for="reg_email">Email Address</label>
                  <input type="email" class="form-control" name="reg_email" id="reg_email" placeholder="Email Address" autofocus>
                </div>
                <div class="form-group">
                  <label for="reg_password">Password</label>
                  <input type="password" class="form-control" name="reg_password" id="reg_password" placeholder="Password" autofocus>
                </div>
                <div class="form-group">
                  <label>Rank</label>
                  <select class="custom-select" name="reg_rank">
                    <option value="1" >Cafe Staff</option>
                    <option value="2">Security Staff</option>
                  </select>
                </div>
                <div class="form-group">
                  <label></label>
                  <button type="submit" class="btn btn-success float-right">Add Notice</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <footer style="position: fixed; bottom: 0;">
        ParkingManager (PM) &copy; 2018/2019 | Designed, developed & maintained by <a href="https://ryanadamwilliams.co.uk"><b>Ryan. W</b></a>
      </footer>
    </div>
    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addVehicleModalTitle">Add Vehicle</h5>
            <button type="button" class="close" tabindex="-1"  data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addVehicleForm">
              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" name="addCompany" id="addCompany" placeholder="NOLAN..." style="text-transform: uppercase;" tabindex="" autofocus>
                <small class="form-text text-muted">Please ensure all company names are correct, especially account customers</small>
              </div>
              <div class="form-group">
                <label>Registration Number</label>
                <input type="text" class="form-control" name="addRegistration" id="addRegistration" placeholder="07WX8787..." style="text-transform: uppercase;">
              </div>
              <div class="form-group">
                <label>Trailer Number</label>
                <input type="text" class="form-control" name="addTrl" id="addTrl" placeholder="MDI112..." style="text-transform: uppercase;">
              </div>
              <div class="form-group">
                <label>Type of Vehicle</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="0">
                  <label class="form-check-label" for="addType">
                    N/A
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="1" checked>
                  <label class="form-check-label" for="addType">
                    Cab &amp; Trailer
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="2">
                  <label class="form-check-label" for="addType">
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="3">
                  <label class="form-check-label" for="addType">
                    Trailer
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="4">
                  <label class="form-check-label" for="addType">
                    Rigid
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="addType" id="addType" value="5">
                  <label class="form-check-label" for="addType">
                    Coach
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="6">
                  <label class="form-check-label" for="addType">
                    Car
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="addType" name="addType" value="7">
                  <label class="form-check-label" for="addType">
                    Motor Home
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Time IN</label>
                <input type="text" class="form-control" name="addTimein" id="addTimein" value="<?php echo date("Y-m-d H:i:s")?>">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" onClick="saveData()" class="btn btn-primary">Save Vehicle</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Search DB Modal -->
    <!-- Search DB Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="searchModal">Search Database Enteries</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <label>Search Vehicle Details</label>
                <input type="text" id="searchData" class="form-control" placeholder="Search Registration, company, trailer number..." autofocus>
              </div>
              <div class="col">
                <label>Search Payment Details</label>
                <input type="text" id="searchPay" class="form-control" placeholder="Search Ticket ID">
              </div>
            </div>
            <div class="modal-body">
              <div id="return">

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- javascript Files -->
    <script src="<?php echo $url?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo $url?>/assets/js/popper.min.js"></script>
    <script src="<?php echo $url?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url?>/assets/js/mousetrap.min.js"></script>
    <?php require(__DIR__.'/assets/jsreq.php')?>
    <script>
    function delNotice(str) {
       var notice_id = str;
       $.ajax({
        url: "<?php echo $url ?>/core/ajax.func.php?p=delNotice",
        type: "POST",
        data: "notice_id="+notice_id
       })
       $('#tables').load(' #tables');
    }
    </script>

  </body>
</html>
