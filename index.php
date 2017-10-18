<?php
  require_once("/core/seldata.php");
  $selData = new Parking;
  $Parked = $selData->fetchParked1();
  $Parked2 = $selData->fetchParked2();
  $Parked3 = $selData->fetchParked3();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parking Manager | Hub</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><strong>Parking Manager</strong></a>

		<div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="ui-elements.php"><i class="fa fa-truck"></i> Vehicle Index</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->

		<div id="page-wrapper">
		  <div class="header">
                        <h1 class="page-header">
                            Dashboard <small>//</small>
                        </h1>
						<ol class="breadcrumb">
					  <li><a href="#">Home</a></li>
					  <li class="active">Dashboard</li>
					  </ol>

		</div>
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                                <i class="fa fa-eye fa-5x"></i>

                            </div>
                            <div class="panel-right">
								                 <h3>67</h3>
                               <strong> Total Spaces Used</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                              <div class="panel-left pull-left blue">
                                <i class="fa fa-shopping-cart fa-5x"></i>
								</div>

                            <div class="panel-right">
							<h3>12 </h3>
                               <strong> Total Awaiting Payment</strong>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                                <i class="fa fa fa-comments fa-5x"></i>

                            </div>
                            <div class="panel-right">
							 <h3>122 </h3>
                               <strong> What Else Can Go here! </strong>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                                <i class="fa fa-users fa-5x"></i>

                            </div>
                            <div class="panel-right">
							<h3>72,525 </h3>
                             <strong>What About Here?</strong>

                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
          <div class="col-md-7 col-sm-12 col-xs-12">

              <div class="panel panel-default">
                  <div class="panel-heading">
                    <button class="btn btn-primary pull-right" type="button" data-toggle="modal" data-target="#addModal">  Register Vehicle</button>
                      Break / Unpaid
                  </div>
                  <div class="panel-body">
                      <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th>Company</th>
                                      <th>Registration</th>
                                      <th>Type</th>
                                      <th>Time In</th>
                                      <th>Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($Parked as $selData) { ?>
                                  <tr>
                                      <td><?php echo $selData['company'] ?> </td>
                                      <td><?php echo $selData['reg'] ?></td>
                                      <?php
                                      if ($selData['type'] == 1) {
                                      echo "<td>C/T</td>";
                                      } else if ($selData['type'] == 2) {
                                        echo "<td>CAB</td>";
                                      } else if ($selData['type'] == 3) {
                                        echo "<td>TRL</td>";
                                      } else if ($selData['type'] == 4) {
                                        echo "<td>RIGID</td>";
                                      } else if ($selData['type'] == 5) {
                                        echo "<td>COACH</td>";
                                      } else if ($selData['type'] == 6) {
                                        echo "<td>CAR</td>";
                                      } ?>
                                      <td><?php echo $selData['timein']?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
<<<<<<< HEAD
                                        <a href="/ParkingManager/update.php?id=<?php echo $selData['id']; ?>" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
=======
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#updateModal" id="<?php echo $selData['id']?>"> Update <span class="glyphicon glyphicon-cog"></span></button>
>>>>>>> parent of e1a5a4c... fuck knows
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a href="#delete">Delete Record</a></li>
                                        </ul>
                                      </div>
                                      </td>
                                  </tr>
                             <?php } ?>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

              <div class="panel panel-default">
                  <div class="panel-heading">
                      Paid
                  </div>
                  <div class="panel-body">
                      <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th>Company</th>
                                      <th>Registration</th>
                                      <th>Type</th>
                                      <th>Time In</th>
                                      <th>Ticket ID</th>
                                      <th>Paid</th>
                                      <th>Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach($Parked2 as $selData) {?>
                                  <tr>
                                      <td><?php echo $selData['company']?></td>
                                      <td><?php echo $selData['reg']?></td>
                                      <?php
                                      if ($selData['type'] == 1) {
                                        echo "<td>C/T</td>";
                                      } else if ($selData['type'] == 2) {
                                        echo "<td>CAB</td>";
                                      } else if ($selData['type'] == 3) {
                                        echo "<td>TRL</td>";
                                      } else if ($selData['type'] == 4) {
                                        echo "<td>RIGID</td>";
                                      } else if ($selData['type'] == 5) {
                                        echo "<td>COACH</td>";
                                      } else if ($selData['type'] == 6) {
                                        echo "<td>CAR</td>";
                                      } ?>
                                      <td><?php echo $selData['timein']?></td>
                                      <td><?php echo $selData['tid']?></td>
                                      <td><?php echo $selData['paid']?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=<?php echo $selData['id']; ?>" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a href="#delete">Delete Record</a></li>
                                        </ul>
                                      </div>
                                      </td>
                                  </tr>
                                <?php } ?>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

          </div>
          <div class="col-md-5 col-sm-12 col-xs-12">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      Exited Vehicles
                  </div>
                  <div class="panel-body">
                      <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th>Company</th>
                                      <th>Registration</th>
                                      <th>Time In</th>
                                      <th>Time Out</th>
                                      <th>Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach($Parked3 as $selData) { ?>
                                  <tr>
                                      <td><?php echo $selData['company']?></td>
                                      <td><?php echo $selData['reg']?></td>
                                      <td><?php echo $selData['timein']?></td>
                                      <td><?php echo $selData['timeout']?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=<?php echo $selData['id']; ?>" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a href="#delete">Delete Record</a></li>
                                        </ul>
                                      </div>
                                      </td>
                                  </tr>
                                <?php } ?>

                              </tbody>
                        </div>
                      </div>

              </div>
          </div>
      </div>
    </div>
<<<<<<< HEAD
    <!-- Modal / Add vehicle -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="addModalLabel">Add vehicle to the log</h4>
          </div>
          <div class="modal-body">
            <form>

              <div class="form-group">
                <label>Company</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="Company..." autofocus>
              </div>

              <div class="form-group">
                <label>Registration Number &amp; Trailer Number (Accounts)</label>
                <input type="text" class="form-control" id="reg" name="reg" placeholder="Registration Number (Trailer Number)...">
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="1" checked>
                  Cab &amp; Trailer
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="2">
                  Cab
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="3">
                  Trailer
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="4">
                  Rigid
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="5">
                  Coach
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="type" name="type" value="6">
                  Car
                </label>
              </div>

              <div class="form-group">
                <label>Time in</label>
                <input type="text" class="form-control" id="timein" name="timein" value="<?php echo date("d/h:i")?>" placeholder="Time of Arrival...">
              </div>

              <div class="form-group">
                <label>Ticket ID</label>
                <input type="text" class="form-control" id="tid" name="tid" placeholder="Ticket ID...">
              </div>

              <div class="form-group">
                <label>Payment Detail</label>
                <input type="text" class="form-control" id="paid" name="paid" placeholder="FUEL £23 EXT">
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="column" name="column" value="1" checked>
                  Break (2hours)
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="column" name="column" value="2">
                  Paid
                </label>
              </div>

              <div class="radio">
                <label>
                  <input type="radio" class="column" name="column" value="3">
                  Exited
                </label>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" onclick="saveData()" class="btn btn-primary">Add Vehicle</button>
            </form>
          </div>
=======
                <!-- Modal / Add vehicle -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="addModalLabel">Add vehicle to the log</h4>
                      </div>
                      <div class="modal-body">
                        <form>

                          <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" id="company" name="company" placeholder="Company..." autofocus>
                          </div>

                          <div class="form-group">
                            <label>Registration Number &amp; Trailer Number (Accounts)</label>
                            <input type="text" class="form-control" id="reg" name="reg" placeholder="Registration Number (Trailer Number)...">
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="1" checked>
                              Cab &amp; Trailer
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="2">
                              Cab
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="3">
                              Trailer
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="4">
                              Rigid
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="5">
                              Coach
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="type" value="6">
                              Car
                            </label>
                          </div>

                          <div class="form-group">
                            <label>Time in</label>
                            <input type="text" class="form-control" id="timein" name="timein" placeholder="Time of Arrival...">
                          </div>

                          <div class="form-group">
                            <label>Ticket ID</label>
                            <input type="text" class="form-control" id="tid" name="tid" placeholder="Ticket ID...">
                          </div>

                          <div class="form-group">
                            <label>Payment Detail</label>
                            <input type="text" class="form-control" id="paid" name="paid" placeholder="FUEL £23 EXT">
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="column" value="1" checked>
                              Break (2hours)
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="column" value="2">
                              Paid
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="column" value="3">
                              Exited
                            </label>
                          </div>

                      </div>
                      <div class="modal-footer">
                        <button type="submit" onclick="saveData()" class="btn btn-primary">Add Vehicle</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>



                <!-- Modal / Update vehicle -->
                <div class="modal fade" id="updModal" tabindex="-1" role="dialog" aria-labelledby="updModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="updModalLabel">Add vehicle to the log</h4>
                      </div>
                      <div class="modal-body">
                        <form>

                          <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" id="upd_company" name="company" placeholder="Company..." autofocus>
                          </div>

                          <div class="form-group">
                            <label>Registration Number &amp; Trailer Number (Accounts)</label>
                            <input type="text" class="form-control" id="upd_reg" name="reg" placeholder="Registration Number (Trailer Number)...">
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="1" checked>
                              Cab &amp; Trailer
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="2">
                              Cab
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="3">
                              Trailer
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="4">
                              Rigid
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="5">
                              Coach
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="type" name="upd_type" value="6">
                              Car
                            </label>
                          </div>

                          <div class="form-group">
                            <label>Time in</label>
                            <input type="text" class="form-control" id="upd_timein" name="timein" placeholder="Time of Arrival...">
                          </div>

                          <div class="form-group">
                            <label>Ticket ID</label>
                            <input type="text" class="form-control" id="upd_tid" name="tid" placeholder="Ticket ID...">
                          </div>

                          <div class="form-group">
                            <label>Payment Detail</label>
                            <input type="text" class="form-control" id="upd_paid" name="paid" placeholder="FUEL £23 EXT">
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="upd_column" value="1" checked>
                              Break (2hours)
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="upd_column" value="2">
                              Paid
                            </label>
                          </div>

                          <div class="radio">
                            <label>
                              <input type="radio" class="column" name="upd_column" value="3">
                              Exited
                            </label>
                          </div>

                      </div>
                      <div class="modal-footer">
                        <button type="submit" onclick="saveData()" class="btn btn-primary">Add Vehicle</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            <!-- /. PAGE INNER  -->
>>>>>>> parent of e1a5a4c... fuck knows
        </div>
      </div>
    </div>
<<<<<<< HEAD
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- Bootstrap Js -->
<script src="assets/js/bootstrap.min.js"></script>

<!-- Metis Menu Js -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>

<script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>

<!-- Custom Js -->
<script src="assets/js/custom-scripts.js"></script>

<script>
$('.modal').on('shown.bs.modal', function() {
$(this).find('[autofocus]').focus();
});
function saveData(){
var company = $('#company').val();
var reg = $('#reg').val();
var type = $(".type:checked").val();
var timein = $('#timein').val();
var tid = $('#tid').val();
var column = $(".column:checked").val();
var paid = $('#paid').val();
$.ajax({
type: "POST",
//remember to update this!
url: "http://localhost/ParkingManager/core/processor.php?p=add",
data: "company="+company+"&reg="+reg+"&type="+type+"&timein="+timein+"&tid="+tid+"&column="+column+"&paid="+paid,
dataType: 'json'
})
}
</script>
=======
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>

	 <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>

    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

      <script>
      $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
      });
      function saveData(){
        var company = $('#company').val();
        var reg = $('#reg').val();
        var type = $(".type:checked").val();
        var timein = $('#timein').val();
        var tid = $('#tid').val();
        var column = $(".column:checked").val();
        var paid = $('#paid').val();
        $.ajax({
          type: "POST",
          url: "/core/processor.php?p=add",
          data: "company="+company+"&reg="+reg+"&type="+type+"&timein="+timein+"&tid="+tid+"&column="+column+"&paid="+paid
        })
      }
      </script>
      <script>
      $(document).on('click', '.edit_data', function(){
     var truck_id = $(this).attr("id");
     $.ajax({
          url:"fetch.php",
          method:"POST",
          data:{truck_id:truck_id},
          dataType:"json",
          success:function(data){
               $('#name').val(data.name);
               $('#address').val(data.address);
               $('#gender').val(data.gender);
               $('#designation').val(data.designation);
               $('#age').val(data.age);
               $('#employee_id').val(data.id);
               $('#insert').val("Update");
               $('#add_data_Modal').modal('show');
          }
     });
});
      </script>
>>>>>>> parent of e1a5a4c... fuck knows
</script>

</body>

</html>
