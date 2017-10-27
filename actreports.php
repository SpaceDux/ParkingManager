<?php
	require_once __DIR__.'/init.php'; //Init file
	
	if(isset($_GET['a'])) {
		
	$sql = "SELECT * FROM parking WHERE company = ?";
	
	$stmt = $dbConn->prepare($sql);
	$stmt->bindParam(1, $_GET['a']);
	
	$stmt->execute();
	
	$result = $stmt->fetchAll();
	
	}
	
	
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
              <a class="navbar-brand" href="<?php echo $url ?>/index.html"><strong>Parking Manager</strong></a>
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
                          Dashboard <small>// update record</small>
                      </h1>
          <ol class="breadcrumb">
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
						  	   <td><?php echo $report['type'] ?></td>
						  	   <td><?php echo $report['timein'] ?></td>
						  	   <td><?php echo $report['timeout'] ?></td>
						  	   <?php if(isset($report['timein']) && isset($report['timeout'])) {
							  	   $duration = abs($report['timein'] - $report['timeout']) / 3600,2);
						  	   }?>
						  	   <td><?php echo $duration ?></td>
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