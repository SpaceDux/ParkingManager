<html>

<head>
    <title>{SITE_NAME} - Thoriums</title>
    <link rel="stylesheet" href="{URL}/template/{TPL}/style.css">
    <link rel="stylesheet" href="{URL}/template/{TPL}/simple-grid.css">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <div class="row header">
      <div class="col-7">
          <h1 class="headerText">Poole High School</h1>
      </div>
      <div class="col-2">
          <ul>
              <li>
                  <p id="date"></p>
              </li>
          </ul>
      </div>
      <div class="col-3">
          <div class="headerList">
              <ul>
                <li><p><i class='fa fa-facebook fa'></i> POOLEHS</p></li><li><p><i class='fa fa-twitter fa'></i>POOLE_HIGH</p></li>
              </ul>
          </div>
      </div>
  </div>

<div class="row col-12 panel">

</div>

<div class="row">
    <div class="col-3">
        <div class="slider datePanel">
            <ul>
            </ul>
        </div>
    </div>
    <div class="col-7">
        <div id="slider">
            <ul>

            </ul>
        </div>
    </div>
    <div class="col-2">
        <a class="twitter-timeline" href="{TWAPI}" data-chrome="noscrollbar" data-width="400" data-height="500" tweet-limit="3">
        </a>
    </div>
</div>

<div class="row">

    <div class="col-2">
        <ul>
            <li>
                <a href="https://danielpullan.co.uk"><i class="fa fa-code fa"></i> Daniel Pullan</a>
            </li>
            <li>
                <a href="https://github.com/danielpullan/thorium"><i class="fa fa-github fa"></i> Github</a>
            </li>
        </ul>
    </div>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function($) {
        $('#checkbox').ready(function() {
            setInterval(function() {
                moveRight();
            }, 3000);
        });
        var slideCount = $('#slider ul li').length;
        var slideWidth = $('#slider ul li').width();
        var slideHeight = $('#slider ul li').height();
        var sliderUlWidth = slideCount * slideWidth;
        $('#slider').css({
            width: slideWidth,
            height: slideHeight
        });
        $('#slider ul').css({
            width: sliderUlWidth,
            marginLeft: -slideWidth
        });
        $('#slider ul li:last-child').prependTo('#slider ul');
        function moveLeft() {
            $('#slider ul').animate({
                left: +slideWidth
            }, 200, function() {
                $('#slider ul li:last-child').prependTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };
        function moveRight() {
            $('#slider ul').animate({
                left: -slideWidth
            }, 200, function() {
                $('#slider ul li:first-child').appendTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };
        $('a.control_prev').click(function() {
            moveLeft();
        });
        $('a.control_next').click(function() {
            moveRight();
        });
    });
</script>
<script>
    var today = new Date();
    $('#date').html(today.toDateString());
</script>
<script>
    window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };
        return t;
    }(document, "script", "twitter-wjs"));
</script>


</html>
