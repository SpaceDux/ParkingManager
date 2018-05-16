<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{SITE_NAME} | Dashboard</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/style.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/simple-grid.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/css/fontawesome-all.min.css">
  </head>
  <body>
    <div class="topBar">
      <div id="Brand">
        Parking<b>Manager</b>
      </div>
      <div class="topContainer">
        <a class="button" onclick="hideNav()"><i class="fas fa-align-justify"></i></a>
        <a href="#" class="button">button</a>
        <a href="#" class="button">button</a>
        <a href="#" class="button right" style="margin-left: 0px;">USER</a>
        <a href="#" class="button right" style="margin-left: 0px;">ANPR</a>
      </div>
    </div>
    <div id="sideBar">
      <div class="navWrap">
        <div class="userBox">
          <div class="userInfo">
            <div class="userName">
              Ryan. <b>W</b>
            </div>
          </div>
        </div>
        <div class="sidenav">
          <a href="{URL}/index" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <button class="dropdown-btn"><i class="fas fa-truck"></i> Vehicle Tools
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#" class="option">Yard Check</a>
          </div>
          <button class="dropdown-btn"><i class="fas fa-balance-scale"></i> Account Tools
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#" class="option">Reports</a>
            <a href="#" class="option">Fleets</a>
          </div>
          <button class="dropdown-btn"><i class="fas fa-h-square"></i> Room Tools
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#" class="option">Bookings</a>
          </div>
          <button class="dropdown-btn"><i class="fas fa-cogs"></i> P<b>M</b> Tools
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="dropdown-container">
            <a href="#" class="option">Notices</a>
          </div>
        </div>
      </div>
    </div>
    <div id="wrapper">
      <div class="darkHead">
        <div class="container">
          <div class="row">
            <div class="col-3">
              <div class="StatBox">
                <div class="statIcon">
                  <i class="fas fa-truck"></i>
                </div>
                <div class="Stat">
                <b>98</b><small>/200</small>
                </div>
                <div class="statText">
                  vehicles <b>parked</b>
                </div>
              </div>
              <div class="StatBox">
                <div class="statIcon">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="Stat">
                <b>12</b>
                </div>
                <div class="statText">
                  renewals
                </div>
              </div>
            </div>
            <div class="col-3">
              <div class="StatBox">
                <div class="statIcon">
                  <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="Stat">
                <b>6</b>
                </div>
                <div class="statText">
                  awaiting <b>payment</b>
                </div>
              </div>
              <div class="StatBox">
                <div class="statIcon">
                  <i class="fas fa-car"></i>
                </div>
                <div class="Stat">
                <b>2</b>
                </div>
                <div class="statText">
                  cars
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="StatBox-LG">
                <canvas id="lastChart" width="400" height="auto" style="width:auto;max-height:181px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-7">
            <div class="notice red">
              <div class="notice-text">
                <b>Lorem:</b> ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <div class="notice blue">
              <div class="notice-text">
                <b>Lorem:</b> ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </div>
            </div>
            <div class="box">
              <div class="col-8">
                <div class="title">
                  Break / Awaiting Payment
                </div>
              </div>
              <div class="col-4">
                <div class="opt-button blue-b right">Add vehicle <i class="fas fa-plus"></i></div>
              </div>
              <table>
                <tr>
                  <th>Company</th>
                  <th>Registration</th>
                  <th>Type</th>
                  <th>Time IN</th>
                  <th>Options</th>
                </tr>
                <tr>
                  <td>HANNON</td>
                  <td>EGZ1234</td>
                  <td>CAB</td>
                  <td>22/00:15</td>
                  <td>
                    button
                  </td>
                </tr>
                <tr>
                  <td>HANNON</td>
                  <td>EGZ1234</td>
                  <td>COACH</td>
                  <td>22/00:15</td>
                  <td>button</td>
                </tr>
                <tr>
                  <td>HANNON</td>
                  <td>EGZ1234</td>
                  <td>CAB</td>
                  <td>22/00:15</td>
                  <td>
                    <div class="opt-button amber-b multi" style="border-radius: 4px 0 0 4px"><i class="fa fa-cog"></i></div>
                    <div class="opt-button blue-b multi" style="border-radius: 0 0 0 0"><i class="fa fa-cog"></i></div>
                    <div class="opt-button red-b multi" style="border-radius: 0 4px 4px 0"><i class="fa fa-cog"></i></div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-5">
            <div class="box">
              <div class="col-8">
                <div class="title">
                  Renewals
                </div>
              </div>
              <table>
                <tr>
                  <th>Company</th>
                  <th>Registration</th>
                  <th>Time IN</th>
                  <th>Options</th>
                </tr>
                <tr>
                  <td>HANNON</td>
                  <td>EGZ1234</td>
                  <td>22/00:15</td>
                  <td>
                    <div class="opt-button red-b">B</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{URL}/template/{TPL}/js/jquery.min.js"></script>
    <script src="{URL}/template/{TPL}/js/Chart.bundle.min.js"></script>
    <script>
    var ctx = document.getElementById("lastChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            datasets: [{
                label: 'This week',
                data: [200, 222, 100, 244, 66, 87, 110],
                borderWidth: [0],
                backgroundColor: [
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)',
                    'rgba(255, 255, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
            },
            {
              label: 'Last week',
              data: [123, 199, 97, 222, 88, 55, 32],
              borderWidth: [0],
              backgroundColor: [
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)',
                  'rgba(104,104,104, 0.6)'
              ],
              borderColor: [
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)',
                  'rgba(104,104,104, 1)'
              ]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    //Navbar dropdown-btn
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;
    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
    //Navbar hide
    function hideNav() {
      var x = document.getElementById("sideBar");
      var z = document.getElementById("wrapper");
      var logo = document.getElementById("Brand");
      //Sidebar
      if (x.style.display === "block") {
          x.style.display = "none";
      } else {
          x.style.display = "block";
      }
      //Wrapper
      if (z.style.paddingLeft === "220px") {
          z.style.paddingLeft = "0px";
      } else {
          z.style.paddingLeft = "220px";
      }
      //Logo
      if (logo.style.position === "fixed") {
          logo.style.position = "absolute";
      } else {
          logo.style.position = "fixed";
      }
    }
    </script>
  </body>
</html>
