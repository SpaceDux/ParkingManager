<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{SITE_NAME}: Login</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/vision.css">
  </head>
  <body>
    <!-- <div class="TopBar">
      <div class="Logo">
        Parking<b>Manager</b>
      </div>
    </div> -->
    <div class="Login_Body">
      <div class="Login_FormArea">
        <div class="Body">
          <img src="{URL}/template/{TPL}/img/Roadking.png" alt="">
          <div class="Form">
            <div class="AlertInfo">

            </div>
            <form class="form-group" id="Login_Form">
              <label>Email Address</label>
              <input type="text" class="form-control dark" name="Login_Email" placeholder="example@parking.man" autofocus>
              <label>Password</label>
              <input type="password" class="form-control dark" name="Login_Password" placeholder="Password">
            </form>
            <button type="button" id="Login_Form_Btn" class="btn btn-block btn-primary">Login</button>
          </div>
        </div>
        <div class="Footer">
          {COPY}
        </div>
      </div>
    </div>

    <script type="text/javascript" src="{URL}/template/{TPL}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.bundle.min.js"></script>
    <?php require("core/ajax/controller.php"); ?>
  </body>
</html>
