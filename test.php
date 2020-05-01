<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form id="form" >
      <input type="text" id="Date1" name="Date1" value="<?php echo date("Y-m-01 21:30:00")?>">
      <input type="text" id="Date2" name="Date2" value="<?php echo date("Y-m-02 21:30:00")?>">
      <button id="Submit"> Submit</button>
    </form>
    <?php phpinfo();?>

    <div id="Response">

    </div>
    <script type="text/javascript" src="/template/Vision/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
      $(document).on('click', '#Submit', function() {
        event.preventDefault();
        var Date1 = $('#Date1').val();
        var Date2 = $('#Date2').val();
        $.ajax({
          url: 'test2.php',
          data: {Date1:Date1, Date2:Date2},
          method: 'POST',
          dataType: "text",
          success:function(Response) {
            $('#Response').html(Response);
          }
        })
      })
    </script>
  </body>
</html>
