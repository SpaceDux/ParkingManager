<?php
	require_once __DIR__.'/init.php'; //Init file

	if(isset($_GET['a'])) {

		$sql = "SELECT * FROM parking WHERE company = ? AND timein BETWEEN ? and ?";

		$stmt = $dbConn->prepare($sql);
		$stmt->bindParam(1, $_GET['a']);
		$stmt->bindParam(2, $_GET['ti']);
		$stmt->bindParam(3, $_GET['to']);

		$stmt->execute();

		$result = $stmt->fetchAll();

		}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $_GET['a']." REPORT ".$_GET['ti']." / ".$_GET['to']?></title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/noprint.css" rel="stylesheet" />
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
      <nav class="navbar navbar-default top-navbar no-print" role="navigation">
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
      <nav class="navbar-default navbar-side no-print" role="navigation">
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
                          Account <small>// Report</small>
                      </h1>
          <ol class="breadcrumb no-print">
          <li><a href="#">Home</a></li>
          <li class="active">Account Report</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Account Report for <?php echo $_GET['a']?>
             </div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Company</th>
                              <td>Registration</td>
                              <td>Trailer Number</td>
                              <td>Ticket ID</td>
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
