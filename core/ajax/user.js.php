<script type="text/javascript">
  // Login
  $('#Login_Form_Btn').on('click', function() {
    event.preventDefault();
    var Data = $('#Login_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Login",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Code != "0") {
          $('.AlertInfo').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+Response.Text+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          document.location.replace("{URL}/main");
        }
      }
    });
  });
  $(document).ready(function() {
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.LoggedIn",
      method: "POST",
      dataType: "json",
      success:function(Response){
        if(Response.Code == "0" && "<?php echo $_GET['page']?>" != "index") {
          document.location.replace("{URL}/index");
        }else if(Response.Code == "1" && "<?php echo $_GET['page']?>" == "index") {
          document.location.replace("{URL}/main");
        }
      }
    });
  });
</script>
