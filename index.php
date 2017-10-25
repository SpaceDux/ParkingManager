<?php
	require_once __DIR__.("/init.php"); //require the initiation file
	
	
	
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

        </nav>
                <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="v_index.php"><i class="fa fa-truck"></i> Vehicle Index</a>
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
                                  <tr>
                                      <td>DIXON</td>
                                      <td>KY65OMR</td>
                                      <td>CAB</td>
                                      <td>21/13:12</td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
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
                                  <tr>
                                      <td>NOLAN</td>
                                      <td>07WX2232</td>
                                      <td>C/T</td>
                                      <td>21/12:22</td>
                                      <td>86777</td>
                                      <td>ACCT£10</td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=" type="button" class="btn btn-danger"> Update <span class="glyphicon glyphicon-cog"></span></a>
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
                                      <th>Time Out</th>
                                      <th>Options</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>MARKTRANS</td>
                                      <td>WPR1445M</td>
                                      <td>13/11:22</td>
                                      <td>
                                        <!-- Split button -->
                                      <div class="btn-group pull-right">
                                        <a href="/ParkingManager/update.php?id=" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-cog"></span></a>
                                      </div>
                                      </td>
                                  </tr>
                              </tbody>
                        </div>
                  </div>
              </div>
          </div>
      </div>
    </div>


</html>