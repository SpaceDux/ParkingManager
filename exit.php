<?php
  // require(__DIR__.'/global.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Exit Keypad</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="template/Vision/css/bootstrap.min.css">
  </head>
  <body>
    <form id="ExitForm">
      <input type="text" class="form-control" id="PM_ExitCode" autofocus>
    </form>
    <!-- javascript Files -->
    <script src="template/Vision/js/jquery-3.4.1.min.js"></script>
    <script src="template/Vision/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).on('keyup', '#PM_ExitCode', function() {
        event.preventDefault();
        Code = $(this).val();

        if (Code.includes("*")) {
          $('#ExitForm')[0].reset();
        }

        if(Code.includes("£") || Code.includes("#")) {
          $.ajax({
            url: "core/ajax/pm.handler.php?handler=PM.ExitCode",
            type: "POST",
            data: {Code:Code},
            success:function(data) {
              if(data == "1") {
                $('#ExitForm')[0].reset();
              } else {
                $('#ExitForm')[0].reset();
              }
            }
          })
        }
      });
    </script>
  </body>
</html>
