<?php
	require_once __DIR__.'/init.php'; //require the init file

	if (isset($_GET['id'])) {
	  $stmt = $dbConn->prepare("SELECT * FROM parking WHERE id = ?");
	  $stmt->bindParam(1, $_GET['id']);
	  $stmt->execute();
	  $result = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	$id = $_GET['id'];
	$message = "";

	if (!empty($_POST['reg'])) {
		$sql = "UPDATE parking SET company = :company,
		reg = :reg,
		trlno = :trlno,
		type = :type,
		timein = :timein,
		tid = :tid,
		col = :col,
		paid = :paid,
		timeout = :timeout,
		comment = :comment WHERE id = $id";
		$stmt2 = $dbConn->prepare($sql);
		$stmt2->bindParam(':company', strtoupper($_POST['company']));
		$stmt2->bindParam(':reg', strtoupper($_POST['reg']));
		$stmt2->bindParam(':trlno', strtoupper($_POST['trlno']));
		$stmt2->bindParam(':type', $_POST['type']);
		$stmt2->bindParam(':timein', $_POST['timein']);
		$stmt2->bindParam(':tid', $_POST['tid']);
		$stmt2->bindParam(':col', $_POST['column']);
		$stmt2->bindParam(':paid', strtoupper($_POST['paid']));
		$stmt2->bindParam(':timeout', $_POST['timeout']);
		$stmt2->bindParam(':comment', $_POST['comment']);

		if($stmt2->execute()) {
			header('Location:'.$url.'/update.php?id='.$id);
			$message = "You have successfully updated this record!";
		} else {
			$message = "The record has not been updated!";
		}
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
                          Dashboard <small>// update record</small>
                      </h1>
          <ol class="breadcrumb">
          <li><a href="#">Home</a></li>
          <li class="active">Updating <?php echo $result['reg'] ?>'s Record</li>
          </ol>

  </div>
<div id="page-inner">
   <div class="row">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Updating Record for <?php echo $result['reg'] ?>
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-lg-6">
	                     <?php echo $message ?>
                         <form method="post" >
                             <div class="form-group">
                                 <label>Company</label>
                                 <input type="text" class="form-control" name="company" style="text-transform: uppercase;" value="<?php echo $result['company']?>">
                             </div>
                             <div class="form-group">
                                 <label>Registration Number</label>
                                 <input type="text" class="form-control" name="reg" style="text-transform: uppercase;" value="<?php echo $result['reg']?>">
                               </div>
                             <div class="form-group">
                                 <label>Trailer Number</label>
                                 <input type="text" class="form-control" name="trlno" style="text-transform: uppercase;" value="<?php echo $result['trlno']?>">
                               </div>
                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="1" <?php if($result['type'] == 1) echo "checked" ?>>
                                   Cab &amp; Trailer
                                 </label>
                               </div>
                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="2" <?php if($result['type'] == 2) echo "checked" ?>>
                                   Cab
                                 </label>
                               </div>

                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="3" <?php if($result['type'] == 3) echo "checked" ?>>
                                   Trailer
                                 </label>
                               </div>
                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="4" <?php if($result['type'] == 4) echo "checked" ?>>
                                   Rigid
                                 </label>
                               </div>
                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="5" <?php if($result['type'] == 5) echo "checked" ?>>
                                   Coach
                                 </label>
                               </div>

                               <div class="radio">
                                 <label>
                                   <input type="radio" class="type" name="type" value="6" <?php if($result['type'] == 6) echo "checked" ?>>
                                   Car
                                 </label>
                               </div>
                     </div>
                     <!-- /.col-lg-6 (nested) -->
                     <div class="col-lg-6">
                       <div class="form-group">
                           <label>Time IN</label>
                           <input type="text" class="form-control" name="timein" value="<?php echo $result['timein']?>">
                         </div>
                     <div class="form-group">
                         <label>Ticket ID</label>
                         <input type="text" class="form-control" name="tid" value="<?php echo $result['tid']?>">
                       </div>
                   <div class="form-group">
                     <label>Payment Details</label>
                       <input type="text" class="form-control" name="paid" style="text-transform: uppercase;" value="<?php echo $result['paid']?>">
                     </div>

                     <div class="radio">
                       <label>
                         <input type="radio" class="column" name="column" value="1" <?php if($result['col'] == 1) echo "checked" ?>>
                         Break (2hours)
                       </label>
                     </div>

                     <div class="radio">
                       <label>
                         <input type="radio" class="column" name="column" value="2" <?php if($result['col'] == 2) echo "checked" ?>>
                         Paid
                       </label>
                     </div>

                     <div class="radio">
                       <label>
                         <input type="radio" class="column" name="column" value="3" <?php if($result['col'] == 3) echo "checked" ?>>
                         Exited
                       </label>
                     </div>
                     <div class="form-group">
                       <label>Time EXIT</label>
                         <input type="text" class="form-control" name="timeout" placeholder="Leave blank until vehicle leaves, use format <?php echo date("Y-m-d H:i:s")?>" value="<?php echo $result['timeout']?>">
                     </div>
										 <div class="form-group">
											 <label>Comment</label>
												 <input type="text" class="form-control" name="comment" placeholder="Add a comment: Took shower" value="<?php echo $result['comment']?>">
										 </div>
                     <!-- /.col-lg-6 (nested) -->
                       <input type="submit" class="btn btn-primary" value="Update"></input>
										 </form>
											 <a href="<?php echo $url ?>/highlight.php?id=<?php echo $result['id'] ?>&col=0"><button class="btn btn-warning">Remove Highlight</button></a>
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
