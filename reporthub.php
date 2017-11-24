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
              <a class="navbar-brand" href="<?php echo $url ?>/index.html"><strong>Parking Manager</strong></a>
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
                            <a href="<?php echo $url ?>/queryreg.php">Vehicle Search</a>
                        </li>
                    </ul>
                <li class="active-menu">
                    <a href="#"><i class="fa fa-sitemap"></i> Account Tools<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="<?php echo $url ?>/reporthub.php"><i class="fa fa-flag-o"></i> Account Reports</a>
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
                                <input type="text" class="form-control" name="ti" style="text-transform: uppercase;" value="<?php echo date("Y-m-d 00:00:00")?>">
                            </div>
                            <div class="form-group">
                                <label>Report End</label>
                                <input type="text" class="form-control" name="to" style="text-transform: uppercase;" value="<?php echo date("Y-m-d 23:59:59")?>">
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
