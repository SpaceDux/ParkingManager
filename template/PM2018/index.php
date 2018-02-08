 <!DOCTYPE html>
<HTML>
  <HEAD>
    <title>{SITE_NAME} | Hub</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/assets/css/main.css" />
    <link rel="stylesheet" href="{URL}/template/{TPL}/assets/css/nav.css" />
    <link rel="stylesheet" href="{URL}/template/{TPL}/assets/css/fontawesome-all.min.css" />
  </HEAD>
  <BODY>
    <div class="topNav">
      <div class="ContentArea">
        <a href="{URL}/index">
        <div class="LogoHolder">
          <div class="Logo"><i style="color: #fff;" class="fas fa-anchor"></i> Parking Manager</div>
        </div>
        </a>
        <div class="Search">
          <form method="post">
            <input type="search" name="query" placeholder="Query a Vehicle, Ticket ID & more..." />
          </form>
        </div>
      </div>
    </div>
    <nav class="mainNav">
      <ul class="center">
        <li>
          <a href="{URL}/index" class="nav-item">
            <div class="icon"><i style="color: #fff;" class="fas fa-home"></i></div>
            Dashboard
          </a>
        </li>
        <li>
          <a href="#" class="nav-item">
            <div class="icon"><i style="color: #fff;" class="fas fa-calculator"></i></div>
            Account Tools
          </a>
          <div class="nav-content">
            <div class="nav-sub">
              <ul>
                <li>
                  <a href="#"><i style="color: #inherit; width: 19px;" class="fas fa-chart-area"></i> Account Reports</a>
                </li>
                <li>
                  <a href="#"><i style="color: #inherit;width: 19px;" class="fas fa-users"></i> Fleet Manager</a>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li>
          <a href="#" class="nav-item">
            <div class="icon"><i style="color: #fff;" class="fas fa-truck"></i></div>
            Vehicle Tools
          </a>
          <div class="nav-content">
            <div class="nav-sub">
              <ul>
                <li>
                  <a href="#"><i style="color: #inherit;width: 19px;" class="fas fa-flag"></i> Yard Check</a>
                </li>
            </div>
          </div>
        </li>
        <li>
          <a href="#" class="nav-item">
            <div class="icon"><i style="color: #fff;" class="fas fa-cogs"></i></div>
            PM Tools
          </a>
          <div class="nav-content">
            <div class="nav-sub">
              <ul>
                <li>
                  <a href="#"><i style="color: #inherit;width: 19px;" class="fas fa-exclamation-triangle"></i> Notices</a>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </nav>
    
  </BODY>
</HTML>
