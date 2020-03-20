<script type="text/javascript">
  $(document).ready(function() {
    // Registration form submit
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
    // Login Form submit
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
    // Update USER Account form
    $(document).on('submit', '#Update_UserForm', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_Update",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#Update_UserError').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Update_UserError').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
      return false;
    });
    // Add USER Plates
    $(document).on('submit', '#Update_UserForm', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_Update",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#Update_UserError').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Update_UserError').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
      return false;
    });
    // Change user password
    $(document).on('submit', '#User_ChangePassword_Form', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_ChangePassword",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#User_ChangePassword_Note').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#User_ChangePassword_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
    });
  });
</script>
