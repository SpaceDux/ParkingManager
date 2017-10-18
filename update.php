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
              <a class="navbar-brand" href="index.html"><strong>Parking Manager</strong></a>

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
                      <a href="ui-elements.html"><i class="fa fa-truck"></i> Vehicle Index</a>
                  </li>
              </ul>

          </div>

      </nav>
      <!-- /. NAV SIDE  -->

  <div id="page-wrapper">
    <div class="header">
                      <h1 class="page-header">
                          Dashboard <small>// update record</small>
                      </h1>
          <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Updating <?php echo $reg ?>'s Record</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Updating Record for <?php echo $reg ?>
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-lg-6">
                         <form role="form">
                             <div class="form-group">
                                 <label>Company</label>
                                 <input class="form-control">
                             </div>
                             <div class="form-group">
                                 <label>Registration Number (Trailer Number)</label>
                                 <input class="form-control">
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
                     </div>
                     <!-- /.col-lg-6 (nested) -->
                     <div class="col-lg-6">
                     <!-- /.col-lg-6 (nested) -->
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
