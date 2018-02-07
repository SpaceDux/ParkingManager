<?php
  require_once __DIR__.("/init.php"); //require the initiation file
  if(isset($_POST['ti'])) {
    header('Location:'.$url.'/actreports.php?a='.$_POST['act'].'&ti='.$_POST['ti'].'&to='.$_POST['to']);
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parking Manager | Generate a Report</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <script src="https://use.fontawesome.com/d70688b1a2.js"></script>
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
            </div>
              <div class="col-sm-3 col-md-3 pull-right">
                  <form class="navbar-form" role="search" method="POST" action="queryreg.php">
                  <div class="input-group">
                      <input type="text" class="form-control" placeholder="Query a Reg" name="q">
                      <div class="input-group-btn">
                          <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                  </div>
                  </form>
              </div>
      </nav>
      <!--/. NAV TOP  -->
      <nav class="navbar-default navbar-side" role="navigation">
          <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">

                <li>
                    <a class="" href="<?php echo $url ?>/index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="">
                    <a href="#"><i class="fa fa-truck"></i> Vehicle Tools<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                      <li>
                          <a href="<?php echo $url ?>/yrdchk.php" target="_blank"><i class="fa fa-flag-o"></i> Yard Check</a>
                      </li>
                    </ul>
                <li class="active-menu">
                    <a href="#"><i class="fa fa-sitemap"></i> Account Tools<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="<?php echo $url ?>/reporthub.php"><i class="fa fa-bar-chart"></i> Account Reports</a>
                            <a href="<?php echo $url ?>/account_list.php"><i class="fa fa-list-alt"></i> Account List</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-cog"></i> PM Tools<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li>
                      <a href="<?php echo $url ?>/viewnotice.php"><i class="fa fa-bar-chart"></i> Notices</a>
                    </li>
                  </ul>
                </li>
              </ul>
          </div>

      </nav>
      <!-- /. NAV SIDE  -->

  <div id="page-wrapper">
    <div class="header">
                      <h1 class="page-header">
                          Dashboard <small>// account reports</small>
                      </h1>
          <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Reports Hub</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Select an account to generate a report..
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-lg-6">
                         <form method="post" action="reporthub.php">

                            <div class="form-group">
                                <label>Account name</label>
                                <input type="text" class="form-control" name="act" style="text-transform: uppercase;" value="NOLAN">
                            </div>
                            <div class="form-group">
                                <label>Report Start</label>
                                <input type="text" class="form-control" name="ti" style="text-transform: uppercase;" value="<?php echo date("Y-m-01 00:00:00")?>">
                            </div>
                            <div class="form-group">
                                <label>Report End</label>
                                <input type="text" class="form-control" name="to" style="text-transform: uppercase;" value="<?php echo date("Y-m-31 23:59:59")?>">
                            </div>
                     <!-- /.col-lg-6 (nested) -->
                       <input type="submit" class="btn btn-primary" value="Generate Report"></input>
                        </form>
                 </div>
                 <!-- /.row (nested) -->
             </div>
             <!-- /.panel-body -->
         </div>
         <!-- /.panel -->
     </div>
     <center><footer>Property of <a href="http://ryanadamwilliams.co.uk">Ryan Adam Williams</a> ~ Parking Manager &copy; 2018 &nbsp; | &nbsp <b><?php echo $ver ?></footer></center>

     <!-- /.col-lg-12 -->
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
<!-- Custom Js -->
<script src="assets/js/custom-scripts.js"></script>
