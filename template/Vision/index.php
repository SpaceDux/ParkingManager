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
    <div class="Login_Body">
      <div class="Login_FormArea">
        <div class="Body">
          <img src="{URL}/template/{TPL}/img/Roadking.png" alt="">
          <div class="Form">
            <div class="AlertInfo">
              <div class="alert alert-primary alert-dismissible fade show" role="alert">Parking<b>Manager</b> is currently under heavy development. Please report any bugs that may arise immediately<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
            </div>
            <hr>

            <form class="form-group" id="Login_Form">
              <input type="text" class="form-control dark" name="Login_Email" placeholder="Email Address" autofocus>
              <hr>
              <input type="password" class="form-control dark" name="Login_Password" placeholder="Password">
              <hr>
              <input type="submit" class="btn btn-block btn-primary" value="Sign In">
            </form>
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
