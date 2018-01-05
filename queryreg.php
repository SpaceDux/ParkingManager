<?php
	require_once __DIR__.'/init.php'; //Init file

  if(isset($_POST['q'])) {
  $q = $_POST['q'];
  $q2 = "%".$_POST['q']."%";

	$sql = "SELECT * FROM parking WHERE reg = ? OR tid LIKE ?";
  $stmt = $dbConn->prepare($sql);
  $stmt->bindParam(1, $q);
  $stmt->bindParam(2, $q2);
  $stmt->execute();
	$result = $stmt->fetchAll();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $q ?> Query</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/noprint.css" rel="stylesheet" />
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
      <nav class="navbar navbar-default top-navbar no-print" role="navigation">
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
      <nav class="navbar-default navbar-side no-print" role="navigation">
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
                          Vehicle Tools <small>// Query</small>
                      </h1>
          <ol class="breadcrumb no-print">
          <li><a href="#">Home</a></li>
          <li class="active">Query Vehicle</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Vehicle Query for <?php echo $q ?>
             </div>

			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Company</th>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) { ?>
					  	 <tbody>
					  	 	<tr>
                   <td><?php echo $report['company'] ?></td>
						  	   <td><?php echo $report['reg'] ?></td>
						  	   <td><?php echo $report['trlno'] ?></td>
						  	   <td><?php echo $report['tid'] ?></td>
									 <?php if ($report['type'] == 1) {
										echo "<td>C/T</td>";
									} else if ($report['type'] == 2) {
										echo "<td>CAB</td>";
									} else if ($report['type'] == 3) {
										echo "<td>TRL</td>";
									} else if ($report['type'] == 4) {
										echo "<td>RIGID</td>";
									} else if ($report['type'] == 5) {
										echo "<td>COACH</td>";
									} else if ($report['type'] == 6) {
										echo "<td>CAR</td>";
									 }
									 ?>
						  	   <td><?php echo $report['timein'] ?></td>
						  	   <td><?php echo $report['timeout'] ?></td>
						  	   <?php if(isset($report['timein']) && isset($report['timeout'])) {
									$datetime1 = new DateTime($report['timein']);
									$datetime2 = new DateTime($report['timeout']);
									$interval = $datetime2->diff($datetime1);
									$hours = $interval->h;
									$hours = $hours + ($interval->days*24);
									echo "<td>".$hours." Hours & ".$interval->format('%i')." Minutes</td>";
						  	   }?>
                   <td>
										 <div class="btn-group pull-right">
											 <a href="<?php echo $url ?>/update.php?id=<?php echo $report['id']?>" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-cog"></span></a>
											 <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												 <span class="caret"></span>
												 <span class="sr-only">Toggle Dropdown</span>
											 </button>
											 <ul class="dropdown-menu">
												<li><a href="<?php echo $url ?>/quickexit.php?id=<?php echo $report['id'] ?>">Quick Exit</a></li>
												<li role="separator" class="divider"></li>
												 <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $report['id'] ?>&col=1">Renewal</a></li>
												 <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $report['id'] ?>&col=2">Mark 48hr</a></li>
												 <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $report['id'] ?>&col=3">Mark 72hr</a></li>
												 <li><a href="<?php echo $url ?>/highlight.php?id=<?php echo $report['id'] ?>&col=0">Remove Highlight</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="<?php echo $url ?>/duplicate.php?id=<?php echo $report['id'] ?>"> Mark Duplicate</a></li>
											 </ul>
										 </div>
					  	 	  </tr>
               </tbody>
					  	 	<?php } ?>
					</table>
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
