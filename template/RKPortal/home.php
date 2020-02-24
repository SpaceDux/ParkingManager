<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roadking Portal | Hub</title>
    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/all.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/style.css">
  </head>
  <body>
    <div class="TopBar">
      <a href="{URL}/home">
        <div class="Brand">
          Roadking<b>Portal</b>
        </div>
      </a>
      <div class="mobile-opt">
        <span><i class="fa fa-align-justify"></i></span>
        Navigate
      </div>
      <div class="MenuOptions">
        <a href="{URL}/home">
          <div class="Opt">
            <span><i class="fa fa-home"></i></span>
            Home
          </div>
        </a>
        <a href="{URL}/account">
          <div class="Opt">
            <span><i class="fa fa-user"></i></span>
            My Account
          </div>
        </a>
      </div>
    </div>
    <div class="Wrapper">
      <div class="row">
        <div class="col-md-12">
          <div class="jumbotron">
            <h1 class="display-4">Reserve your Parking</h1>
            <p class="lead">You can now pre-book your parking space with us..</p>
            <hr>
            <a class="btn btn-primary btn-lg" href="#" role="button">Reserve My Space</a>
          </div>
        </div>
        <div class="col-md-12">
          <div class="Box">
            <div class="Title">
              Upcoming Bookings
              <div class="float-right">
                <button type="button" class="btn btn-primary"><i class="fa fa-sync-alt"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">CY15GHX</h5>
              <p class="card-text">Thanks {FIRST_NAME}, your booking has been confirmed.</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Roadking: Cannock</li>
              <li class="list-group-item"><i class="fa fa-clock"></i> ETA: 24/02/20 @ 15:30</li>
              <li class="list-group-item"><i class="far fa-clock"></i> ETD: 25/02/20 @ 08:30</li>
              <li class="list-group-item">Not Checked In</li>
            </ul>
            <div class="card-body">
              <a href="#" class="card-link">Modify Booking</a>
              <a href="#" class="card-link">Cancel Booking</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">YP11RNO</h5>
              <p class="card-text">Thanks {FIRST_NAME}, your booking has been confirmed.</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Roadking: Cannock</li>
              <li class="list-group-item"><i class="fa fa-clock"></i> ETA: 24/02/20 @ 15:30</li>
              <li class="list-group-item"><i class="far fa-clock"></i> ETD: 25/02/20 @ 08:30</li>
              <li class="list-group-item">Not Checked In</li>
            </ul>
            <div class="card-body">
              <a href="#" class="card-link">Modify Booking</a>
              <a href="#" class="card-link">Cancel Booking</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">CY15GHX</h5>
              <p class="card-text">Thanks {FIRST_NAME}, your booking has been confirmed.</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Roadking: Cannock</li>
              <li class="list-group-item"><i class="fa fa-clock"></i> ETA: 24/02/20 @ 15:30</li>
              <li class="list-group-item"><i class="far fa-clock"></i> ETD: 25/02/20 @ 08:30</li>
              <li class="list-group-item">Not Checked In</li>
            </ul>
            <div class="card-body">
              <a href="#" class="card-link">Modify Booking</a>
              <a href="#" class="card-link">Cancel Booking</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- STYLE BASED SCRIPTS -->
    <?php require_once('./modals.php'); ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{URL}/template/{TPL}/js/style.js"></script>
    <script src="{URL}/template/{TPL}/js/bootstrap.bundle.js"></script>
    <script src="{URL}/template/{TPL}/js/all.min.js"></script>
    <?php require_once('./core/ajax/controller.php'); ?>
  </body>
</html>
