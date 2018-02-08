 <!DOCTYPE html>
<HTML>
  <HEAD>
    <title>{SITE_NAME} | Hub</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/assets/css/main.css" />
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
      <div class="mainNav">
        <div class="ContentArea">
          <div class="Options">
            <a href="{URL}/index">
              <div class="Option Selected">
                <div class="icon"><i class="fas fa-home"></i></div>
                Dashboard
              </div>
            </a>
            <a href="{URL}/index">
              <div class="Option">
                <div class="icon"><i class="fas fa-truck"></i></div>
                Vehicle Tools
              </div>
            </a>
            <a href="{URL}/index">
              <div class="Option">
                <div class="icon"><i class="fas fa-calculator"></i></div>
                Account Tools
              </div>
            </a>
            <a href="{URL}/index">
              <div class="Option">
                <div class="icon"><i class="fas fa-cogs"></i></div>
                PM Tools
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </BODY>
</HTML>
