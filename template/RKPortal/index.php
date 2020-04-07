<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Roadking Portal | Pre-book your HGV parking with us</title>
    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/all.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/style.css">
  </head>
  <body>
    <div class="LoginWrapper">
      <div class="LoginPane">
        <div class="Logo">
          <img src="{URL}/template/{TPL}/img/Roadking.png" alt="Pre-Book your HGV Parking with Roadking"></img>
        </div>
        <div class="LoginForm">
          <div id="User_LoginForm_Error"></div>
          <form id="LoginForm">
            <label for="Email">Email Address</label>
            <input type="email" class="form-control LoginForm_B dark" name="Email" id="Email" placeholder="Email Address" value="" autofocus>
            <br>
            <label for="Password">Password</label>
            <input type="password" class="form-control LoginForm_B dark" name="Password" id="Password" placeholder="Password">
            <br>
            <input type="submit" class="btn btn-primary" value="Login" style="width: 100%;">
            <hr>
          </form>
          <label>Not a member?</label>
          <button class="btn btn-success" data-toggle="modal" data-target="#User_JoinModal" style="width: 100%;">Join Today</button>
          <br>
          <hr>
          <small style="color:#f6f6f6">By using our website, you agree to our <a data-target="#CookiePolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Cookie Policy</b></a> & <a data-target="#PrivacyPolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Privacy Policy</b></a></small>
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
