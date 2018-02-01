<?php
	require_once __DIR__.'/init.php'; //Init file

		$sql = "SELECT * FROM parking WHERE col < 3";
		$stmt = $dbConn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Parking Manager | Yard Check</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/noprint.css" rel="stylesheet" />
    <link href="assets/css/print.css" rel="stylesheet" />
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
                 Yard Check
             </div>
			 		<table class="table table-bordered" >
			 			 <thead>
                          <tr>
                              <th>Company</th>
                              <th>Registration</th>
                              <th>Trailer Number</th>
                              <th>Ticket ID</th>
                              <th>Type</th>
                              <th>Time In</th>
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
									 <td>
										 <div class="form-check">
											<input type="checkbox" class="form-check-input" id="exampleCheck1">
										</div>
									 </td>
									 <td>
										 <div class="btn-group pull-right">
											 <a href="<?php echo $url ?>/update.php?id=<?php echo $report['id']?>" type="button" class="btn btn-danger" target="_blank"> <span class="glyphicon glyphicon-cog"></span></a>
										 </div>
									 </td>
					  	 	</tr>
					  	 </tbody>

					  	 	<?php } ?>
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
<script src="assets/js/print.js"></script>
