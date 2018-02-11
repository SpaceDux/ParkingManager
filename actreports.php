<?php
	require_once __DIR__.'/init.php'; //Init file

	if(isset($_GET['a'])) {

		$sql = "SELECT * FROM parking WHERE company = ? AND col != '4' AND timein BETWEEN ? and ? ORDER by type";

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
	<div id="page-inner">
	   <div class="row">
	     <div class="col-lg-12">
	         <div class="panel panel-default">
	             <div class="panel-heading no-print">
	                 REPORT BETWEEN 0hours & 4:15hours
	             </div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours <= 3 AND $interval->format('%i') <= 60) {
													?>
											  	 <tbody>
											  	 	<tr>
																<td><?php echo $counter ?></td>
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

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			 }
													?>
					</table>
					<br>
					<div class="panel panel-default">
							<div class="panel-heading no-print">
									REPORT BETWEEN 4hours & 29hours (1 DAY)
							</div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours >= 4 AND $hours <= 29) {
													?>
											  	 <tbody>
											  	 	<tr>
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
															} else if ($report['type'] == 0) {
																 echo "<td>N/A</td>";
															 }
															 ?>
												  	   <td><?php echo $report['timein'] ?></td>
												  	   <td><?php echo $report['timeout'] ?></td>
												  	   <?php if(isset($report['timein']) && isset($report['timeout'])) {

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			}
													?>
					</table>
					<br>
					<div class="panel panel-default">
							<div class="panel-heading no-print">
									REPORT BETWEEN 29hours & 52hours (2 DAY)
							</div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours >= 29 AND $hours <= 52) {
													?>
											  	 <tbody>
											  	 	<tr>
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

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			 }
													?>
								</table>
					<br>
					<div class="panel panel-default">
							<div class="panel-heading no-print">
									REPORT BETWEEN 53hours & 79hours (3 DAYS)
							</div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours >= 53 AND $hours <= 79) {
													?>
											  	 <tbody>
											  	 	<tr>
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

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			 }
													?>
					</table>
					<br>
					<div class="panel panel-default">
							<div class="panel-heading no-print">
									REPORT BETWEEN 79hours & 104hours (4 DAYS)
							</div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours >= 79 AND $hours <= 104) {
													?>
											  	 <tbody>
											  	 	<tr>
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

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			 }
													?>
					</table>
					<br>
					<div class="panel panel-default">
							<div class="panel-heading no-print">
									REPORT BETWEEN 105hours & 129hours (5 DAYS)
							</div>
			 		<table class="table table-bordered">
			 			 <thead>
                          <tr>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
                              <th>Time Out</th>
                              <th>Duration</th>
                          </tr>
                      	 </thead>
                      	 	<?php foreach( $result as $report ) {
													$datetime1 = new DateTime($report['timein']);
													$datetime2 = new DateTime($report['timeout']);
													$interval = $datetime2->diff($datetime1);
													$hours = $interval->h;
													$hours = $hours + ($interval->days*24);

													if($hours >= 105 AND $hours <= 129) {
													?>
											  	 <tbody>
											  	 	<tr>
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

															echo "<td>".$hours." : ".$interval->format('%i')."</td>";
												  	   }?>
											  	 	</tr>
											  	 </tbody>
												 <?php }
											 			 }
													?>
					</table>
                 <!-- /.row (nested) -->
             </div>
             <!-- /.panel-body -->
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
