<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{SITE_NAME}: Dashboard</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/vision.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body>
    <div class="TopBar">
      <div class="Logo">
        <a href="{URL}/main">Parking<b>Manager</b></a>
      </div>
      <div class="Options">
        <a href="#" class="mbl_only"><i class="fa fa-align-justify"></i></a>
        <a href="#"><i class="fa fa-search"></i></a>
        <a href="#"><i class="fa fa-plus"></i></a>
        <a href="#"><i class="fa fa-key"></i></a>
      </div>
      <div class="Options-Right">
        <a href="#"><i class="fas fa-bell"></i></a>
        <a href="#"><i class="fa fa-user"></i> {FNAME}</a>
      </div>
    </div>
    <div class="Navigation_Bar">
      <ul>
        <li class="Selected">
          <a href="{URL}/main">
            <i class="fa fa-tachometer-alt"></i>
            DASHBOARD
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-truck"></i>
            VEHICLE TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Yard Check</a>
            <a href="#se">Something else</a>
          </div>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-pound-sign"></i>
            PAYMENT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Transaction History</a>
          </div>
        </li>
        <li>
          <a href="{URL}/main">
            <i class="fa fa-file-invoice"></i>
            ACCOUNT TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Account Management</a>
            <a href="#se">Reports</a>
          </div>
        </li>
        <li>
          <a href="{URL}/main">
            <i class="fa fa-cogs"></i>
            P<b>M</b> TOOLS
          </a>
          <div class="Dropdown_Menu">
            <a href="#yc">Notices</a>
            <a href="#se">User Management</a>
            <a href="#se">Site Management</a>
          </div>
        </li>
      </ul>
    </div>
    <div class="Wrapper">
      <div class="row">
        <div class="col-md-3">
          STATS
        </div>
        <div class="col-md-3">
          STATS
        </div>
        <div class="col-md-3">
          STATS
        </div>
        <div class="col-md-3">
          STATS
        </div>
      </div>
      <div class="row">
        <div class="col-md-7">
          <div class="Box">
            <div class="Title">
              <i class="fa fa-video" style="color: red; padding-right: 10px;"></i>  Live ANPR Feed
            </div>
            <table class="table table-striped table-dark table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Plate</th>
                  <th scope="col">Time IN</th>
                  <th scope="col">Patch</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="Box">
            <div class="Title">
              PAID Feed
            </div>
            <table class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Plate</th>
                  <th scope="col">Time IN</th>
                  <th scope="col">Patch</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-5">
          <div class="Box">
            <div class="Title">
              RENEWALS Feed
            </div>
            <table class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Plate</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                </tr>
                <tr class="table-warning">
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>@fat</td>
                </tr>
                <tr class="table-danger">
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="Box">
            <div class="Title">
              EXIT Feed
            </div>
            <table class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th scope="col">Company</th>
                  <th scope="col">Plate</th>
                  <th scope="col">Time IN</th>
                  <th scope="col"><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                </tr>
                <tr class="table-warning">
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                  <td>@fat</td>
                </tr>
                <tr class="table-danger">
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{URL}/template/{TPL}/js/bootstrap.bundle.min.js"></script>
    <?php require("core/ajax/controller.php"); ?>
  </body>
</html>
