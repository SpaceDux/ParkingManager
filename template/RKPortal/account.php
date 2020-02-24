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
        <div class="col-md-6">
          <div class="Box">
            <div class="Title">
              Update Your Account
            </div>
            <div class="Body">
              <form>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <label for="Update_User_FirstName">First Name</label>
                      <input type="text" class="form-control" name="Update_User_FirstName" value="{FIRST_NAME}">
                    </div>
                    <div class="col">
                      <label for="Update_User_LastName">Last Name</label>
                      <input type="text" class="form-control" name="Update_User_LastName" value="{LAST_NAME}">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <label for="Update_User_Email">Email Address</label>
                      <input type="email" class="form-control" name="Update_User_Email" value="{EMAIL}">
                    </div>
                    <div class="col">
                      <label for="Update_User_Telephone">Telephone</label>
                      <input type="text" class="form-control" name="Update_User_Telephone" value="{TELEPHONE}">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <input type="submit" class="btn btn-primary float-right" value="Update Account">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="Box">
            <div class="Title">
              Update Your Vehicles
            </div>
            <div class="Body">

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
