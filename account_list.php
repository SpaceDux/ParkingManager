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
                <li class="">
                    <a href="#"><i class="fa fa-truck"></i> Vehicle Tools<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                      <li>
                          <a href="<?php echo $url ?>/yrdchk.php" target="_blank"><i class="fa fa-flag-o"></i> Yard Check</a>
                      </li>
                    </ul>
                <li class="active-menu">
                    <a href="#"><i class="fa fa-sitemap"></i> Account Tools<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="<?php echo $url ?>/reporthub.php"><i class="fa fa-bar-chart"></i> Account Reports</a>
                            <a href="<?php echo $url ?>/account_list.php"><i class="fa fa-list-alt"></i> Account List</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-cog"></i> PM Tools<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li>
                      <a href="<?php echo $url ?>/viewnotice.php"><i class="fa fa-bar-chart"></i> Notices</a>
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
                 List of our account customers
             </div>
             <div class="panel-body">
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             AGRO (Sawyers, Woolsey, Browne)
                         </div>
                         <p style="padding: 10px;">AGRO has multiple sister companies parking on their account. <br> SAWYERS, Woolsey, Browne all park under AGRO.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=AGRO"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             NOLAN Transport
                         </div>
                         <p style="padding: 10px;">NOLAN Transport is one of our largest accounts with over 100 transactions processed for them every month.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=NOLAN"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             HANNON Transport
                         </div>
                         <p style="padding: 10px;">HANNON Transport also has a SNAP! account, becareful when billing as it can be quite easy to charge them through snap
                         instead of there account.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=HANNON"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             NOONE Transport
                         </div>
                         <p style="padding: 10px;">Noone Transport also has a SNAP! account, becareful when billing as it can be quite easy to charge them through snap
                         instead of there account.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=NOONE"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             KCT (K. Connolly Transport)
                         </div>
                         <p style="padding: 10px;">Kevin Connolly Transport is another large account with 100's of transactions processed every month.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=KCT"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             LEATRANS
                         </div>
                         <p style="padding: 10px;">LEATRANS quite often have two drivers for one truck, we can charge them £3 (1hr) as a shower voucher.</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=LEATRANS"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             GIST (Zellwood)
                         </div>
                         <p style="padding: 10px;">GIST also has a sister company "Zellwood" and allows them to park on their account</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=GIST"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             DIXON
                         </div>
                         <p style="padding: 10px;">Dixon Transport is our largest account</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=DIXON"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             BREEN
                         </div>
                         <p style="padding: 10px;">Breen Transport</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=BREEN"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             BALLINALARD
                         </div>
                         <p style="padding: 10px;">Ballinalard Transport</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=BALLINALARD"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             O'LEARY TRANSPORT
                         </div>
                         <p style="padding: 10px;">O'Leary Transport</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=OLEARY"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
                     <div class="col-lg-6">
                       <div class="panel panel-primary">
                         <div class="panel-heading">
                             VIRGINIA TRANSPORT
                         </div>
                         <p style="padding: 10px;">Virginia Transport</p>
                         <ul class="list-group">
                           <li class="list-group-item">Email: </li>
                           <li class="list-group-item">Telephone: </li>
                           <li class="list-group-item">Tools:
                             <a href="<?php echo $url?>/fleets.php?a=OLEARY"><button type="button" class="btn btn-primary">Fleet List</button></a>
                           </li>
                         </ul>
                       </div>
                     </div>
             </div>
         </div>
         <!-- /.panel -->
     </div>
     <center><footer>Property of <a href="http://ryanadamwilliams.co.uk">Ryan Adam Williams</a> ~ Parking Manager &copy; 2018 &nbsp; | &nbsp <b><?php echo $ver ?></footer></center>

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
