<?php
  $db = new PDO("mysql:host=localhost;dbname=rkpm;", 'root', '1123');

  $stmt = $db->prepare("SELECT * FROM parking WHERE id = ?");
  $stmt->bindParam(1, $_GET['id']);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $stmt2 = $db->prepare("UPDATE parking SET (company, reg, type, timein, tid, col, paid, timeout, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt2->bindParam(1, $_POST['company']);
  $stmt2->bindParam(2, $_POST['reg']);
  $stmt2->bindParam(3, $_POST['type']);
  $stmt2->bindParam(4, $_POST['timein']);
  $stmt2->bindParam(5, $_POST['tid']);
  $stmt2->bindParam(6, $_POST['col']);
  $stmt2->bindParam(7, $_POST['paid']);
  $stmt2->bindParam(8, $_POST['timeout']);
  $stmt2->bindParam(9, $_POST['comment']);

  $stmt2->execute();


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
                         <form role="form">
                             <div class="form-group">
                                 <label>Company</label>
                                 <input class="form-control" value="<?php echo $result['company']?>">
                             </div>
                             <div class="form-group">
                                 <label>Registration Number (Trailer Number)</label>
                                 <input class="form-control" value="<?php echo $result['reg']?>">
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
                               <div class="form-group">
                                 <label>Add a Comment</label>
                                   <textarea class="form-control" rows="4" value="<?php echo $result['comment']?>"></textarea>
                                 </div>
                     </div>
                     <!-- /.col-lg-6 (nested) -->
                     <div class="col-lg-6">
                       <div class="form-group">
                           <label>Time IN</label>
                           <input class="form-control" value="<?php echo $result['timein']?>">
                         </div>
                     <div class="form-group">
                         <label>Ticket ID</label>
                         <input class="form-control" value="<?php echo $result['tid']?>">
                       </div>
                   <div class="form-group">
                     <label>Payment Details</label>
                       <input class="form-control" value="<?php echo $result['paid']?>">
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
                         <input class="form-control" placeholder="Leave blank until vehicle leaves, use format 22/11:23" value="<?php echo $result['timeout']?>">
                       </div>
                     <!-- /.col-lg-6 (nested) -->
                       <button type="submit" class="btn btn-primary">Update Vehicle</button>
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
