<!DOCTYPE html>
<style>
html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100vh;
  overflow: hidden !important;
}
.Pane {
  max-width: 100%;
  display: inline-block;
  max-height: 100vh;
}
.Content {
  max-height: 100vh;
  margin: 0 auto;
  text-align: center;
  display: block;
}
.Content > img {
  max-height: 100%;
  max-width: 100%;
  display: flex;
  margin: 0 auto;
}
.Hidden {
  transition: all 0.5s ease;
  width: 0px;
}
.Show {
  transition: all 0.5s ease;
  width: 100%;
}
</style>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Parking Digisign</title>
  </head>
  <body>
    <div class="Pane">
      <div class="Content" id="ShowImages">

      </div>
    </div>
  </body>
  <script src=".\..\template\Vision\js\jquery-3.4.1.min.js"></script>
  <script type="text/javascript">
    function Slides()
    {
      var count = 0;
      var images = ["Parking-Digisign.png", "MakeTheMost.png"];
      var previous = count;
      var html = '';
      for(var i = 0; i < images.length; i++)
  	  {
  		    html += '<img src="'+images[i]+'" id="'+i+'" class="Hidden" alt="'+images[i]+'">';
      }
      $('#ShowImages').html(html);
      $('#'+count).addClass('Show');
      count++;
      setInterval(function()
      {
        if(!images[count])
        {
          count = 0;
        }
        $('#'+previous).removeClass('Show');
        $('#'+count).addClass('Show');
        previous = count;
        count++;
      }, 10000);
    }
    Slides();
  </script>
</html>
