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
      <div class="mobile-opt" onClick="Navi_Tog()">
        <span><i class="fa fa-align-justify"></i></span>
        Navigate
      </div>
      <div class="MenuOptions" id="Menu">
        <a href="{URL}/home">
          <span><i class="fa fa-home"></i></span>
          Home
        </a>
        <a href="{URL}/account">
          <span><i class="fa fa-user"></i></span>
          My Account
        </a>
        <a href="{URL}/logout.php">
          <span><i class="fas fa-sign-out-alt"></i></span>
          Logout
        </a>
      </div>
    </div>
    <div class="Wrapper">
      <div class="row">
        <div class="col-md-6">
          <div class="Box">
            <div class="Title">
              Update Your Vehicles
            </div>
            <div class="Body">
              <div class="container">
                <form id="AddPlates">
                  <div id="AddPlate_Error"></div>
                  <div class="row">
                    <div class="col-md-5">
                      <label>Enter a Vehicle Registration</label>
                      <input type="text" class="form-control" name="Plate" placeholder="EX43 PLE" style="text-transform: uppercase;" required>
                    </div>
                    <div class="col-md-5">
                      <label>Choose a name for this plate (E.G; My Scania)</label>
                      <input type="text" class="form-control" name="Name" placeholder="Assign a name" required>
                    </div>
                    <div class="col">
                      <input type="submit" class="btn btn-primary" style="margin-top: 10px;width: 100%;" value="Save Plate">
                    </div>
                  </div>
                </form>
              </div>
              <hr>
              <div class="container">
                <div class="row">
                  <div class="col">
                    <div id="MYPLATES-TABLE"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="Box">
            <div class="Title">
              Update Your Account
            </div>
            <div class="Body">
              <form id="Update_UserForm">
                <div class="container">
                  <div id="Update_UserError"></div>
                  <div class="row">
                    <div class="col">
                      <label for="Update_User_FirstName">First Name</label>
                      <input type="text" class="form-control" name="First" value="{FIRST_NAME}" required>
                    </div>
                    <div class="col">
                      <label for="Update_User_LastName">Last Name</label>
                      <input type="text" class="form-control" name="Last" value="{LAST_NAME}" required>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <label for="Update_User_Email">Email Address</label>
                      <input type="email" class="form-control" name="Email" value="{EMAIL}" required>
                    </div>
                    <div class="col">
                      <label for="Update_User_Telephone">Telephone</label>
                      <input type="text" class="form-control" name="Telephone" value="{TELEPHONE}" required>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <label for="Update_User_Email">Enter your Password</label>
                      <input type="password" class="form-control" name="Password" placeholder="Enter your current password" required>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <input type="submit" class="btn btn-primary float-right" value="Update Account">
                      <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#User_ChangePassword_Modal">Change Password</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <br>
      <br>
      <center>Copyright &copy; Roadking Truckstops 2020 | By using our website, you agree to our <a data-target="#CookiePolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Cookie Policy</b></a> & <a data-target="#PrivacyPolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Privacy Policy</b></a></center>
      <br>
    </footer>
    <!-- STYLE BASED SCRIPTS -->
    <?php require_once('./modals.php'); ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{URL}/template/{TPL}/js/style.js"></script>
    <script src="{URL}/template/{TPL}/js/bootstrap.bundle.js"></script>
    <script src="{URL}/template/{TPL}/js/all.min.js"></script>
    <?php require_once('./core/ajax/controller.php'); ?>
  </body>
</html>
