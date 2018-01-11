<?php

?>
<?php
	require_once __DIR__.'/init.php'; //require the init file

  $stmt = $dbConn->prepare("SELECT * FROM acts");
  $stmt->execute();

  $acts = $stmt->fetchAll();
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
									<li class="active-menu">
											<a href="#"><i class="fa fa-truck"></i> Vehicle Tools<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
												<li>
														<a href="<?php echo $url ?>/yrdchk.php" target="_blank"><i class="fa fa-flag-o"></i> Yard Check</a>
												</li>
											</ul>
									<li class="">
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
                          Dashboard <small>// all accounts</small>
                      </h1>
          <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Accounts List</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Listing all ACCOUNTS
             </div>
             <div class="panel-body">
               <div class="list-group">
                 <a href="#" class="list-group-item">DIXON</a>
                 <a href="#" class="list-group-item">NOLAN</a>
                 <a href="#" class="list-group-item">BALLINALARD</a>
                 <a href="#" class="list-group-item">AGRO</a>
               </div>
                 <!-- /.row (nested) -->
             </div>
             <!-- /.panel-body -->
         </div>
         <!-- /.panel -->
     </div>
     <!-- /.col-lg-12 -->
		 <center><footer>Property of <a href="http://ryanadamwilliams.co.uk">Ryan Adam Williams</a> ~ Parking Manager &copy; 2018</footer></center>
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
