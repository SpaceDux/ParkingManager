<?php
	require_once __DIR__.("/init.php"); //require the initiation file

	$Parked = new fetchParked();
	$fetchBreak = $Parked->fetchBreak();
	$fetchPaid = $Parked->fetchPaid();
	$fetchExit = $Parked->fetchExit();
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
                <a class="navbar-brand" href="<?php echo $url ?>/index.php"><strong>Parking Manager</strong></a>

        </nav>
                <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="<?php echo $url ?>/index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?php echo $url ?>/vehindex.php"><i class="fa fa-truck"></i> Vehicle Index</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       <div id="page-wrapper">
		  <div class="header">
                        <h1 class="page-header">
                            Dashboard <small>// main hub</small>
                        </h1>
						<ol class="breadcrumb">
					  <li><a href="#">Home</a></li>
					  <li class="active">Dashboard</li>
					  </ol>
		</div>
		<!-- start page -->
		    <div id="page-inner">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                              <div class="panel-left pull-left blue">
                                <i class="fa fa-road fa-5x"></i>
								</div>

                            <div class="panel-right">
							<h3><?php echo count($fetchBreak) + count($fetchPaid)?><small>/220</small></h3>
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
							<h3><?php echo count($fetchBreak) ?> </h3>
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
                    <button class="btn btn-primary pull-right" type="button" data-toggle="modal" data-target="#addModal">Register Vehicle <i class="fa fa-plus" aria-hidden="true"></i></button>
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
                              <?php foreach ($fetchBreak as $Parked) { ?>
                              <tbody>
                                  <tr <?php if ($Parked['h_light'] == 1) {
	                                 	echo 'class="warning"'; //Renewal mark
	                                  } else if ($Parked['h_light'] == 2) {
		                              	echo 'class="success"'; //48hr
	                                  } else if ($Parked['h_light'] == 3) {
		                              	echo 'class="info"'; //72hr
	                                  } else if ($Parked['h_light'] == 0) {
		                              	echo ""; //no highlight 
	                                  }?>>
                                      <td><?php echo $Parked['company'] ?></td>
                                      <td><?php echo $Parked['reg'] ?></td>
                                     <?php if ($Parked['type'] == 1) {
	                                     echo "<td>C/T</td>";
                                     } else if ($Parked['type'] == 2) {
	                                     echo "<td>CAB</td>";
                                     } else if ($Parked['type'] == 3) {
	                                     echo "<td>TRL</td>";
                                     } else if ($Parked['type'] == 4) {
	                                     echo "<td>RIGID</td>";
                                     } else if ($Parked['type'] == 5) {
	                                     echo "<td>COACH</td>";
                                     } else if ($Parked['type'] == 6) {
	                                     echo "<td>CAR</td>";
                                     }
                                     ?>
                                      <td><?php echo $Parked['timein'] ?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=<?php echo $Parked['id']?>" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a href="<?php echo $url ?>/quickexit.php?id=<?php echo $Parked['id'] ?>">Quick Exit</a></li>
                                          <li role="separator" class="divider"></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=1">Renewal</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=2">Mark 48hr</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=3">Mark 72hr</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=0">Remove Highlight</a></li>
                                          
                                        </ul>
                                      </div>
                                      </td>
                                  </tr>
                              </tbody>
                              <?php } ?>
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
                              <?php foreach ($fetchPaid as $Parked) { ?>
                              <tbody>
                                  <tr <?php if ($Parked['h_light'] == 1) {
	                                 	echo 'class="warning"'; //Renewal mark
	                                  } else if ($Parked['h_light'] == 2) {
		                              	echo 'class="success"'; //48hr
	                                  } else if ($Parked['h_light'] == 3) {
		                              	echo 'class="info"'; //72hr
	                                  } else if ($Parked['h_light'] == 0) {
		                              	echo ""; //no highlight 
	                                  }?>>
                                      <td><?php echo $Parked['company'] ?></td>
                                      <td><?php echo $Parked['reg'] ?></td>
                                     <?php if ($Parked['type'] == 1) {
	                                     echo "<td>C/T</td>";
                                     } else if ($Parked['type'] == 2) {
	                                     echo "<td>CAB</td>";
                                     } else if ($Parked['type'] == 3) {
	                                     echo "<td>TRL</td>";
                                     } else if ($Parked['type'] == 4) {
	                                     echo "<td>RIGID</td>";
                                     } else if ($Parked['type'] == 5) {
	                                     echo "<td>COACH</td>";
                                     } else if ($Parked['type'] == 6) {
	                                     echo "<td>CAR</td>";
                                     }
                                     ?>
                                      <td><?php echo $Parked['timein'] ?></td>
                                      <td><?php echo $Parked['tid'] ?></td>
                                      <td><?php echo $Parked['paid'] ?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=<?php echo $Parked['id']?>" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-cog"></span></a>
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <li><a href="<?php echo $url ?>/quickexit.php?id=<?php echo $Parked['id'] ?>">Quick Exit</a></li>
                                          <li role="separator" class="divider"></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=1">Renewal</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=2">Mark 48hr</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=3">Mark 72hr</a></li>
                                          <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $Parked['id'] ?>&col=0">Remove Highlight</a></li>
                                          
                                        </ul>
                                      </div>
                                      </td>
                                  </tr>
                              </tbody>
                              <?php } ?>
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
                                      <th>Time Out</th>
                                      <th>Options</th>
                                  </tr>
                              </thead>
                              <?php foreach ($fetchExit as $Parked) { ?>
                              <tbody>
                                  <tr>
                                      <td><?php echo $Parked['company']?></td>
                                      <td><?php echo $Parked['reg']?></td>
                                      <td><?php echo $Parked['timeout']?></td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=<?php echo $Parked['id']?>" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-cog"></span></a>
                                      </div>
                                      </td>
                                  </tr>
                              </tbody>
                              <?php } ?>
                        </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
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
                <input type="text" class="form-control" id="company" name="company" placeholder="Company..." style="text-transform: uppercase;" autofocus>
              </div>

              <div class="form-group">
                <label>Registration Number</label>
                <input type="text" class="form-control" id="reg" name="reg" placeholder="Registration Number (Trailer Number)..." style="text-transform: uppercase;">
              </div>
              
              <div class="form-group">
                <label>Trailer Number</label>
                <input type="text" class="form-control" id="trlno" name="trlno" placeholder="Trailer Number" style="text-transform: uppercase;">
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
                <input type="text" class="form-control" id="timein" name="timein" value="<?php echo date("d/H:i")?>" placeholder="Time of Arrival...">
              </div>

              <div class="form-group">
                <label>Ticket ID</label>
                <input type="text" class="form-control" id="tid" name="tid" placeholder="Ticket ID...">
              </div>

              <div class="form-group">
                <label>Payment Detail</label>
                <input type="text" class="form-control" id="paid" name="paid" placeholder="FUEL £23 EXT" style="text-transform: uppercase;">
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
  var trlno = $('#trlno').val();
  var type = $(".type:checked").val();
  var timein = $('#timein').val();
  var tid = $('#tid').val();
  var column = $(".column:checked").val();
  var paid = $('#paid').val();
  $.ajax({
  type: "POST",
  //remember to update this!
  url: "http://localhost/ParkingManager/core/processor.php?p=add",
  data: "company="+company+"&reg="+reg+"&trlno="+trlno+"&type="+type+"&timein="+timein+"&tid="+tid+"&column="+column+"&paid="+paid
  })
}
</script>


</html>
