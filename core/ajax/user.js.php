<script type="text/javascript">
  $(document).on('click', '#JoinForm_Submit', function() {
    event.preventDefault();
    var Data = $('#JoinForm').serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.User_Registration",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response)
      {
        if(Response.Result < 1) {
          $('#User_JoinModal_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          $('#User_JoinModal_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
        }
      }
    });
    return false;
  });
  $(document).on('submit', '#LoginForm', function() {
    event.preventDefault();
    var Data = $('#LoginForm').serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.User_Login",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response)
      {
        if(Response.Result < 1) {
          $('#User_LoginForm_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          $('#User_LoginForm_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
          setInterval(function() {
            location.replace("{URL}/home");
          }, 3000);
        }
      }
    });
    return false;
  });
</script>
